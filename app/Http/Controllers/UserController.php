<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\CustomUser;
use App\Models\User_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PinMail;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Shifts;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate request data
        dd($request);
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'employment_number' => 'nullable|string',
            'user_type_id' => 'required|string',
            'status' => 'required|string',
            'email' => 'nullable|email',
            'department' =>  'nullable|string',
        ]);

        // Check if employment number already exists
        if ($validatedData['employment_number'] !== null && CustomUser::where('bsl_cmn_users_employment_number', $validatedData['employment_number'])->exists()) {
            return redirect()->back()->with('error', 'Employment number already exists.');
        }

        // Check if email already exists
        if ($validatedData['email'] && CustomUser::where('bsl_cmn_users_email', $validatedData['email'])->exists()) {
            return redirect()->back()->with('error', 'Email already exists.');
        }

        // Generate a random 4-digit PIN
        $pin = mt_rand(1000, 9999);

        // Create a new user instance
        $user = new CustomUser();
        $user->bsl_cmn_users_firstname = $validatedData['firstname'];
        $user->bsl_cmn_users_lastname = $validatedData['lastname'];
        $user->bsl_cmn_users_employment_number = $validatedData['employment_number'];
        $user->bsl_cmn_users_pin = $pin;
        $user->bsl_cmn_users_type = $validatedData['user_type_id'];
        $user->bsl_cmn_users_status = $validatedData['status'];
        $user->bsl_cmn_users_email = $validatedData['email'];
        $user->bsl_cmn_users_department = $validatedData['department'];

        try {
            // Save the user to the database
            $user->save();

            // Send email with PIN if email is provided
            if ($validatedData['email']) {
                Mail::to($validatedData['email'])->send(new PinMail($pin));
            }

            // Redirect back with success message
            return redirect()->route('login')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Error creating user: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to create user. Please try again.');
        }
    }


    public function login(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'pin' => 'required|digits:4', // Assuming PIN is a 4-digit number
        ]);

        // Attempt to find the user by PIN
        $user = CustomUser::where('bsl_cmn_users_pin', $validatedData['pin'])->first();
        if ($user) {
            // Log in the user
            Auth::login($user);



            // Check if user is authenticated
            if (Auth::check()) {
                // Redirect authenticated users to the dashboard or any other page
                return redirect()->route('dashboard');
            } else {
                // Debug: Log authentication failure
                logger('Authentication failed for user: ' . $user->id);
            }
        } else {
            // Debug: Log user not found
            logger('User not found for PIN: ' . $validatedData['pin']);
        }

        // If login fails, redirect back with error message
        return redirect()->back()->with('error', 'Invalid PIN');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
    public function index()
    {
        $users = CustomUser::with('userType', 'shifts')->get();
        $shifts = Shifts::all();

        return view('admin.users.index', ['users' => $users, 'shifts' => $shifts]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $shifts = Shifts::pluck('bsl_cmn_shifts_name', 'bsl_cmn_shifts_id')->all();
        $userTypes = User_type::pluck('bsl_cmn_user_types_name', 'bsl_cmn_user_types_id');
        return view('admin.users.create', [
            'roles' => $roles,
            'userTypes' => $userTypes,
            'shifts' => $shifts
        ]);
    }
    public function store(Request $request)
    {
        $pin = mt_rand(1000, 9999);
        echo $pin;
        //dd('Store function called', $request->all());

        try {
            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'password' =>  'required|string|min:8',
                'employment_number' => 'nullable|string',
                'user_type_id' => 'required|string',
                'status' => 'required|string',
                'email' => 'nullable|email',
                'department' =>  'nullable|string',
                'roles' => 'required',
                'shift' => 'required',
            ]);

            // Check if email exists before sending
            if (isset($validatedData['email'])) {
                Mail::to($validatedData['email'])->send(new PinMail($pin));
            }
        } catch (ValidationException $e) {
            // Return response with validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
        // Check if employment number already exists
        if ($validatedData['employment_number'] !== null && CustomUser::where('bsl_cmn_users_employment_number', $validatedData['employment_number'])->exists()) {
            return redirect()->back()->with('error', 'Employment number already exists.');
        }

        // Check if email already exists
        if ($validatedData['email'] && CustomUser::where('email', $validatedData['email'])->exists()) {
            return redirect()->back()->with('error', 'Email already exists.');
        }

        $user = CustomUser::create([
            'bsl_cmn_users_firstname' => $request->firstname,
            'bsl_cmn_users_lastname' => $request->lastname,
            'bsl_cmn_users_employment_number' => $request->employment_number,
            'password' => Hash::make($request->password),
            'bsl_cmn_users_type' => $request->user_type_id,
            'bsl_cmn_users_pin' => $pin,
            'bsl_cmn_users_status' => $request->status,
            'email' => $request->email,
            'bsl_cmn_users_department' => $request->department,
        ]);

        //dd($user);
        $user->syncRoles($request->roles);
        $user->shifts()->attach($request->input('shift'));

        return redirect('/users')->with('success', 'User created successfully with roles');
    }
    public function edit(CustomUser $user)
    {
        $role = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $userTypes = User_type::pluck('bsl_cmn_user_types_name', 'bsl_cmn_user_types_id');

        // Retrieve all shifts available (for dropdown selection)
        $allShifts = Shifts::pluck('bsl_cmn_shifts_name', 'bsl_cmn_shifts_id');

        // Retrieve the user with their associated shifts
        $user->load('shifts');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $role,
            'userTypes' => $userTypes,
            'userRoles' => $userRoles,
            'allShifts' => $allShifts,
        ]);
    }
    public function update(Request $request, CustomUser $user)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'employment_number' => 'nullable|string',
            'user_type_id' => 'required|string',
            'status' => 'required|string',
            'email' => 'nullable|email',
            'department' => 'nullable|string',
            'roles' => 'required',
            'shifts' => 'nullable|array',
            'pin'=> 'required|string|max:4'
        ]);
        // Check if the PIN already exists for a different user
        $existingPin = CustomUser::where('bsl_cmn_users_pin', $request->pin)
        ->where('bsl_cmn_users_id', '!=', $user->bsl_cmn_users_id) 
        ->first();
        // dd($existingPin);
        if ($existingPin) {
            return redirect()->back()->with('error', 'The PIN already exists for another user.');
        }

        $data = [
            'bsl_cmn_users_firstname' => $request->firstname,
            'bsl_cmn_users_lastname' => $request->lastname,
            'bsl_cmn_users_employment_number' => $request->employment_number,
            'bsl_cmn_users_type' => $request->user_type_id,
            'bsl_cmn_users_status' => $request->status,
            'email' => $request->email,
            'bsl_cmn_users_department' => $request->department,
            'bsl_cmn_users_pin' => $request->pin,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        // Sync the shifts for the user based on the submitted form data
        $user->shifts()->sync($request->input('shifts', []));

        return redirect('/users')->with('success', 'User updated successfully with roles and shifts');
    }
    public function destroy($userid)
    {
        $user = CustomUser::findOrFail($userid);
        $user->delete();

        return redirect('/users')->with('status', 'User deleted!');
    }
    public function adminLogin()
    {
        return view('auth.admin-login');
    }
    public function loginUser(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Retrieve the user by their email
        $user = CustomUser::where('email', $request->email)->first();

        if ($user) {
            // Dump the user's email and password for debugging


            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            // Dump the credentials array for debugging
            // dd($credentials);

            // if ($user->isAdmin()) {
            //     // Admin user - authenticate using password
                //dd($user);
                if (Auth::attempt($credentials)) {

                    return redirect()->route('admin.dashboard');
                } else {
                    return back()->withInput()->with('fail', 'Invalid email or password');
                }
            // } else {
            //     // Regular user - authenticate using PIN
            //     // Logic to authenticate using PIN goes here
            //     return redirect()->route('/');
            // }
        } else {
            return back()->withInput()->with('fail', 'User not found');
        }
    }
    public function adminLogout()
    {

        Auth::logout();

        return redirect('/admin-login');
    }
}

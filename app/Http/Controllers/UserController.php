<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\CustomUser;
use App\Models\User_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PinMail;


class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate request data
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

    public function showRegistrationForm()
    {
        $userTypes = User_type::pluck('bsl_cmn_user_types_name', 'bsl_cmn_user_types_id'); // Fetch all user types and select 'name' column as the dropdown option text and 'id' column as the value

        return view('register', compact('userTypes')); // Pass the $userTypes variable to the view
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
}

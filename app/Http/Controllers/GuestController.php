<?php

namespace App\Http\Controllers;

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

class GuestController extends Controller
{
    public function index()
    {
        $guests = CustomUser::where('bsl_cmn_users_type', 9)->get();
        return view('admin.guests.index', ['guests' => $guests]);
    }
    public function create()
    {
        $userTypes = User_type::pluck('bsl_cmn_user_types_name', 'bsl_cmn_user_types_id');
        //dd($userTypes);
        return view('admin.guests.create', [
            'userTypes' => $userTypes
        ]);

    }
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'no_of_days' => 'required'
                
            ]);

            // Generate the next guest ID
            $guestId = $this->generateGuestId();
            //Generate pin
            $pin = mt_rand(1000, 9999);

            // Create a new CustomUser instance and save it to the database
            $guest = new CustomUser();
            $guest->bsl_cmn_users_firstname = $validatedData['firstname'];
            $guest->bsl_cmn_users_lastname = $validatedData['lastname'];
            $guest->bsl_cmn_users_employment_number = $guestId;
            $guest->email = $guestId . '@bulkstream.com'; 
            $guest->bsl_cmn_users_pin = $pin;
            $guest->bsl_cmn_users_department = "GUEST";
            $guest->bsl_cmn_users_days = $validatedData['no_of_days'];
            $guest->bsl_cmn_users_type = 9; // Assign the 'Guest' user type directly
            $guest->save();

            
            $guest->assignRole(3); // Assign user to the user-role

            $guest->shifts()->attach(1); //Assign user to Normal user shift

            // Redirect or respond with success
            return redirect()->route('guests.index')->with('success', 'Guest registered successfully!');

        } catch (ValidationException $e) {
            // Return response with validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Method to generate the next guest ID
    private function generateGuestId()
    {
        // Get the last inserted guest with the 'Guest' user type (3)
        $lastGuest = CustomUser::where('bsl_cmn_users_type', 9) // Use '3' for Guest type
            ->orderBy('bsl_cmn_users_employment_number', 'desc')
            ->first();

        // Default starting ID if no guests are present
        $nextId = 'GUEST001';

        // Check if there is a last guest entry
        if ($lastGuest) {
            // Extract the number from the last guest ID (e.g., GUEST001 -> 001)
            $lastIdNumber = (int) substr($lastGuest->bsl_cmn_users_employment_number, 5);

            // Increment the number and format it back to the guest ID format (e.g., 2 -> GUEST002)
            $nextId = 'GUEST' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return $nextId;
    }
    public function destroy($guestId)
    {
        $guest = CustomUser::find($guestId);
        $guest->delete();
        return redirect('guests')->with('error', 'Guest Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;
use App\Models\User_type;
use App\Models\Sites;
use App\Models\CustomUser;
use App\Models\MealType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\PrintHelper;

class SecurityMealTicket extends Controller
{
    //
    public function index(Request $request)
    {

        $users = CustomUser::with('userType')
                ->where('bsl_cmn_users_department', 'Security')
                ->get();

        $companies = User_type::pluck('bsl_cmn_user_types_name');
        return view('admin.security.index', ['users' => $users]);
        
        
        
    }

    public function logTicket(Request $request)
    {
        $sourceDevice = $request->ip();
        $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();

        if (!$site) {
            return redirect()->back()->with('errors', 'Canteen Site/Device Mismatch, Contact IT admin!.' );
        }

        $validatedData = $request->validate([
            'tickets' => 'required|array',
            'site_id' => 'required|integer',
        ]);

        // Initialize an array to hold the names of users with more than one meal entry
        $usersWithMultipleMeals = [];
        // Initialize a flag for error messages
        $hasError = false;

        foreach ($validatedData['tickets'] as $ticket) {
            // Fetch the user based on the staff number
            $user = CustomUser::where('bsl_cmn_users_id', $ticket['userId'])->first();

            // Debug logging
            \Log::info('Processing ticket for staff number: ' . $ticket['userId']);
            \Log::info('User found: ' . ($user ? $user->bsl_cmn_users_id : 'No user found'));

            // Check if a user was found before accessing the ID
            if ($user) {
                try {
                    // Get user's shift
                    $usershift = CustomUser::with('shifts')->findOrFail($user->bsl_cmn_users_id);
                    $shift = $usershift->shifts->first();

                    // Determine shift start and end times
                    $currentDateTime = now();
                    $shiftStartTime = Carbon::parse($shift->bsl_cmn_shifts_starttime);
                    $shiftEndTime = Carbon::parse($shift->bsl_cmn_shifts_endtime);

                    // Adjust for shifts that end the next day
                    if ($currentDateTime->lessThan($shiftStartTime)) {
                        $shiftStartTime->subDay();
                    } else {
                        $shiftEndTime->addDay();
                    }

                    // Get the meal type ID
                    $mealType = Mealtype::where('bsl_cmn_mealtypes_mealname', $ticket['mealType'])->first();

                    // Check how many meals the user has logged
                    $mealCount = Logs::where('bsl_cmn_logs_person', $user->bsl_cmn_users_id) // Corrected to use user's ID
                        ->where('bsl_cmn_logs_mealtype', $mealType->bsl_cmn_mealtypes_id) // Check the specific meal type
                        ->whereBetween('created_at', [$shiftStartTime, $shiftEndTime])
                        ->count();

                    // If the number of meals taken exceeds the allowed number
                    if ($mealCount >= $shift->bsl_cmn_shifts_mealsnumber) {
                        // Add user name to the warning list and set error flag
                        $usersWithMultipleMeals[] = $ticket['name']; // Assuming the ticket contains the user name
                        $hasError = true; // Indicate that an error occurred
                        continue; // Skip this iteration for the user
                    }

                    // Create the log entry
                    Logs::create([
                        'bsl_cmn_logs_person' => (int)$user->bsl_cmn_users_id, // Cast to int
                        'bsl_cmn_logs_mealtype' => $mealType->bsl_cmn_mealtypes_id, // Using the correct meal type ID
                        'bsl_cmn_logs_time' => now()->format('Y-m-d H:i:s'), // Format as a timestamp string
                        'bsl_cmn_logs_site' => (int)$validatedData['site_id'], // Cast site_id to int if necessary
                    ]);

                    // Fetch the printer details from the site
                    $sitePrinter = $site->printer->first();

                    $mealDetails = (object)[
                        'staffid' => $ticket['staffNo'], // Change this key
                        'userName' => $ticket['name'], // Change this key
                        'company' => $ticket['company'],
                        'department' => $ticket['department'],
                        'mealtype' => $ticket['mealType'], // Change this key
                        'date' => $ticket['timestamp'],
                        'site' => $ticket['site']
                    ];

                    // Attempt to create a new PrintHelper instance and send the print job
                    $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
                    $printer->printMealTicket($mealDetails);

                } catch (\Exception $e) {
                    // Log the error for debugging
                    \Log::error('Error printing tickets: ' . $e->getMessage());
                    
                    // Continue processing the next ticket even if an error occurs
                    continue;
                }

            } else {
                // Log a warning if no user was found
                \Log::warning('No user found for staff number: ' . $ticket['userId']);
            }
        }

        // Prepare the final response message
        if ($hasError) {
            // If there were users with more than one meal entry, append their names
            $userNames = '';
            foreach ($usersWithMultipleMeals as $index => $name) {
                $userNames .= ($index + 1) . '. ' . $name . ' '; // Format with numbering and line break
            }

             return response()->json(['success' => false, 'message' => 'Printout failed, users with more than one meal entry:' . $userNames]);
        }

        // Return a success response after all tickets are processed without errors
        return response()->json(['success' => true, 'message' => 'Valid tickets processed successfully.']);
    }

}

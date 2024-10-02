<?php


namespace App\Http\Controllers;


use App\Models\CustomUser;
use Carbon\Carbon;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use App\Models\MealType;
use App\Models\Sites;
use App\Models\User_type;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Services\PrintHelper;
use Illuminate\Support\Facades\Log;

class MealSelectionController extends Controller
{
    public function selectMeal(Request $request)
    {
        // $sourceDevice = $request->ip();

        // Selectively fetch only the necessary fields from both the site and printer
        // $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)
        //             ->with(['printer' => function($query) {
        //                 $query->select('id', 'site_id', 'address', 'port'); // Fetch only necessary fields
        //             }])
        //             ->select('bsl_cmn_sites_id', 'bsl_cmn_sites_device_ip') // Select only necessary fields from Sites
        //             ->first();

        // Check if the site or printer is missing
        // if (!$site || !$site->printer) {
        //     return redirect('/dashboard')->with('errors', 'Unable to determine the site or printer based on the device IP.');
        // }
        $sourceDevice = $request->ip();
        $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();
        if (!$site) {
            return redirect('/dashboard')->with('errors', 'Canteen Site/Device Mismatch, Contact IT admin!.');
        }

        // At this point, you have both the site and the printer
        // $printerAddress = $site->printer->address;
        // $printerPort = $site->printer->port;
        // $printer = new PrintHelper($printerAddress, $printerPort);

        // Check if the printer is offline
        // if (!$printer->isOnline()) {
        //     return redirect('/dashboard')->with('error', 'Printer is currently offline. Please try again later.');
        // }
        
        // Validate the incoming request
        $validatedData = $request->validate([
            'meal_type_id' => 'required',
        ]);

        // Get the current user's ID
        $userId = auth()->id();

        // Retrieve the user and their shift
        $user = CustomUser::with('shifts')->findOrFail($userId);
        $shift = $user->shifts->first();

        $currentDateTime = Carbon::now();

        // if (!$shift) {
        //     return redirect('/dashboard')->with('error', 'You are not assigned to any shift.');
        // }

        // Determine shift start and end times
        $shiftStartTime = Carbon::parse($shift->bsl_cmn_shifts_starttime);
        $shiftEndTime = Carbon::parse($shift->bsl_cmn_shifts_endtime);

        // Adjust for shifts that end the next day
        if ($currentDateTime->lessThan($shiftStartTime)) {
            $shiftStartTime->subDay();
        } else {
            $shiftEndTime->addDay();
        }


        // Check the number of meals already taken in this shift
        // echo $currentDateTime . "<br>";
        // echo $shiftStartTime . "<br>";
        // echo $shiftEndTime . "<br>";
        $mealCount = Logs::where('bsl_cmn_logs_person', $userId)
            ->where('bsl_cmn_logs_mealtype', $validatedData['meal_type_id']) // Check the specific meal type
            ->whereBetween('created_at', [$shiftStartTime, $shiftEndTime])
            ->count();

        // If the number of meals taken exceeds the allowed number, return an error
        if ($mealCount >= $shift->bsl_cmn_shifts_mealsnumber) {
            return redirect('/dashboard')->with('error', 'You have already reached the maximum number of meals for your shift.');
        }

        // Get the current request's IP
        $sourceDevice = $request->ip();

        // Fetch the site based on the IP
        $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();
        $siteId = $site ? $site->bsl_cmn_sites_id : null;

        // Create a new Logs entry
        $log = new Logs();
        $log->bsl_cmn_logs_mealtype = $validatedData['meal_type_id'];
        $log->bsl_cmn_logs_person = $userId;
        $log->bsl_cmn_logs_time = now();
        $log->bsl_cmn_logs_site = $siteId;
        $log->save();

        // Fetch the latest log entry for the selected meal type
        $latestLog = Logs::where('bsl_cmn_logs_person', $userId)
            ->where('bsl_cmn_logs_mealtype', $validatedData['meal_type_id'])
            ->latest()
            ->first();

        // Fetch the related meal type details
        $mealType = MealType::find($validatedData['meal_type_id']);

        // Format the log time in the Nairobi timezone
        $logTime = Carbon::parse($latestLog->bsl_cmn_logs_time)->timezone('Africa/Nairobi')->format('d/m/Y H:i:s');

        // // Prepare the data for printing
        $mealDetails = (object) [
            'userid' => $user->bsl_cmn_users_id,
            'userName' => $user->bsl_cmn_users_firstname . ' ' . $user->bsl_cmn_users_lastname,
            'staffid' => $user->bsl_cmn_users_employment_number,
            'department' => $user->bsl_cmn_users_department,
            'company' => $user->userType->bsl_cmn_user_types_name,
            'mealtype' => $mealType->bsl_cmn_mealtypes_mealname,
            'date' => $logTime,
            'site' => $site ? $site->bsl_cmn_sites_name : 'Unknown'
        ];

        $sourceDevice = $request->ip();
        $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();
    
        try {
            $sitePrinter = $site->printer->first();
    
            // Handle printing
            $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
            $printer->printMealTicket($mealDetails);
            //dd($printer);
    
            // Redirect with success message if the print job is successful
            return redirect('/dashboard')->with('success', 'Meal selection logged and ticket printed successfully!');
        } catch (\Exception $e) {
            // Log the exception details
            Log::error('Meal ticket printing error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            // Catch any errors and return an error message to the user
            return redirect()->back()->with('errors', 'Failed to print meal ticket: ' . $e->getMessage());
        }
    }

    public function printTest(Request $request, $printerId)
    {
        // Validate request data
        $request->validate([
            'printer_address' => 'required',
            'printer_port' => 'required',
        ]);

        // Get printer address and port from the request
        $printerAddress = $request->input('printer_address');
        $printerPort = $request->input('printer_port');

        // Log the printer address and port for debugging
        Log::info('Printer Address: ' . $printerAddress);
        Log::info('Printer Port: ' . $printerPort);

        $mealDetails = (object)[
            'staffid' => '123456',
            'userName' => 'John Doe',
            'company' => 'Bulkstream Limited',
            'department' => 'Test',
            'mealtype' => 'Test Meal',
            'date' => Carbon::now()->toDateTimeString(),
            'site' => 'Test Site'
        ];

        try {
            // Attempt to create a new PrintHelper instance and send the print job
            $printer = new PrintHelper($printerAddress, $printerPort);
            $printer->printMealTicket($mealDetails);

            // Return a successful response
            return redirect()->back()->with('success', 'Test print job sent successfully.');
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return redirect()->back()->with('error', 'Failed to send test print job: ' . $e->getMessage());
        }
    }

 
    public function printTickets(Request $request)
    {
        $tickets = $request->input('tickets');

        // Log the tickets for debugging
        Log::info('Received tickets: ', $tickets);
        //dd($tickets); // Keep for debugging

        // Assuming the first ticket contains the site information
        $firstTicket = $tickets[0]; // Access the first ticket for site information
        $siteName = $firstTicket['site'];
        $site = Sites::where('bsl_cmn_sites_name', $siteName)->first();
        $sitePrinter = $site->printer->first();

        try {
            foreach ($tickets as $ticketData) {
                // Update to match the keys from your AJAX request
                $mealDetails = (object)[
                    'staffid' => $ticketData['staffNo'], // Change this key
                    'userName' => $ticketData['name'], // Change this key
                    'company' => $ticketData['company'],
                    'department' => $ticketData['department'],
                    'mealtype' => $ticketData['mealType'], // Change this key
                    'date' => $ticketData['timestamp'],
                    'site' => $ticketData['site']
                ];

                // Attempt to create a new PrintHelper instance and send the print job
                $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
                $printer->printMealTicket($mealDetails);
            }

            // Return a successful response
            return response()->json(['success' => true, 'message' => 'Print jobs sent successfully.']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error printing tickets: ' . $e->getMessage());

            // Return an error response with the exception message
            return response()->json(['success' => false, 'message' => 'Failed to send print job: ' . $e->getMessage()]);
        }
    }



}

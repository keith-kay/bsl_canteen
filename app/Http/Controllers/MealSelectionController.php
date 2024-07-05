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
        echo $currentDateTime . "<br>";
        echo $shiftStartTime . "<br>";
        echo $shiftEndTime . "<br>";
        $mealCount = Logs::where('bsl_cmn_logs_person', $userId)
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

        // Prepare the data for printing
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
        $sitePrinter = $site->printer->first();

        // Handle printing
        $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
        $printer->printMealTicket($mealDetails);

        return redirect('/dashboard')->with('success', 'Meal selection logged and ticket printed successfully!');
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
}
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

        // Create a new Logs entry
        $log = new Logs();
        $log->bsl_cmn_logs_mealtype = $validatedData['meal_type_id'];
        $log->bsl_cmn_logs_person = $userId;
        $log->bsl_cmn_logs_time = now();
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
        ];

        // $sourceDevice = $request->ip();
        // $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();
        // $sitePrinter = $site->printer->first();

        // // Handle printing
        // $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
        // $printer->printMealTicket($mealDetails);

        return redirect('/dashboard')->with('success', 'Meal selection logged and ticket printed successfully!');
    }

    public function printTest(Request $request)
    {
        $sourceDevice = $request->ip();
        $site = Sites::where('bsl_cmn_sites_device_ip', $sourceDevice)->first();
        $sitePrinter = $site->printer->first();
        #
        $mealDetails = (object)[
            'staffid' => '123456',
            'userName' => 'Victor Mtange',
            'company' => 'Mumo Humo Inc.',
            'department' => 'IT',
            'mealtype' => 'Brunch',
            'date' => '2030-09-01 12:00:00',
        ];
        ## Handle "Cannot initialise NetworkPrintConnector: No route to host"
        $printer = new PrintHelper($sitePrinter->address, $sitePrinter->port);
        $printer->printMealTicket($mealDetails);
    }
}

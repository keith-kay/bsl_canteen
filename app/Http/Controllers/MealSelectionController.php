<?php


namespace App\Http\Controllers;


use App\Models\CustomUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use App\Models\MealType;
use App\Models\User_type;
use App\Models\User;


class MealSelectionController extends Controller
{
    public function selectMeal(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'meal_type_id' => 'required|exists:bsl_cmn_mealtypes,bsl_cmn_mealtypes_id',
        ]);


        // Get the current user's ID
        $userId = auth()->id();


        // Get the current time
        $current_time = Carbon::now();


        // start of the current day at 7am
        $shiftStart = Carbon::now()->startOfDay()->setTime(7, 0, 0);


        // Calculate the start of the next day at 7am
        $nextDayStart = $shiftStart->copy()->addDay();


        if ($current_time->hour < 7) {
            $shiftStart->subDay();
        }




        // Check if the user has already made a meal selection between 7am to 7am of the next day
        $lastEntry = Logs::where('bsl_cmn_logs_person', $userId)
            ->where('bsl_cmn_logs_mealtype', $validatedData['meal_type_id'])
            ->whereBetween('created_at', [$shiftStart, $nextDayStart]) // Check within the current day from 7am to the next day at 7am
            ->exists();


        //If a previous entry exists within the specified time frame, prevent the user from making a new entry
        if ($lastEntry) {
            return redirect('/dashboard')->with('error', 'You have already made a meal selection in your shift. Please try again later.');
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


        // Fetch the related user details
        $user = CustomUser::find($userId);


        // Fetch the related meal type details
        $mealType = MealType::find($validatedData['meal_type_id']);

        //Fetch the usertype
        $userTypeId = $user->bsl_cmn_users_type;

        $userType = User_type::find($userTypeId)->bsl_cmn_user_types_name;


        // Format the log time in the Nairobi timezone
        $logTime = Carbon::parse($latestLog->bsl_cmn_logs_time)->timezone('Africa/Nairobi')->format('d/m/Y H:i:s');


        // Prepare the data for printing
        $data = [
            'userid' => $user->bsl_cmn_users_id,
            'userdetails' => $user->bsl_cmn_users_firstname . ' ' . $user->bsl_cmn_users_lastname,
            'staffid' => $user->bsl_cmn_users_employment_number,
            'department' => $user->bsl_cmn_users_department,
            'company' => $userType,
            'mealtype' => $mealType->bsl_cmn_mealtypes_mealname,
            'date' => $logTime,
        ];


        //echo json_encode($data);
        //echo $userId;
        // Use the data to print the log
        $curl = curl_init();
        $url = ''; //'http://api.bulkstream.com:1416/mealprint.php?userid=' . $userId . '&printerid=TCMEAL';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));


        $response = curl_exec($curl);
        if ($response === false) {
            echo "Error: Failed to connect to API.";
        } else {
            echo $response;
            echo $url;
            echo json_encode($data);
        }


        curl_close($curl);
        echo $response;


        // Return a success response
        return redirect('/dashboard')->with('success', 'Meal selection logged successfully!');
    }
}
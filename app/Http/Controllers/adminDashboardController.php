<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;
use Carbon\Carbon;

class adminDashboardController extends Controller
{
    public function adminDashboard()
    {
        $user = Auth::user();

        $logs = Logs::with('user', 'mealType')
            ->whereDate('bsl_cmn_logs_time', now()->toDateString())
            ->get();
        //$logCount = $logs->count();

        $dayShiftStart = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0); // 07:00 day shift start
        $dayShiftEnd = Carbon::today()->setHour(19)->setMinute(0)->setSecond(0); // 19:00  day shift end
        $previousDayStart = now()->subDay()->setHour(19)->setMinute(0)->setSecond(0); // 19:00:00 night shift start 
        $previousDayEnd = now()->subDay()->endOfDay();
        $currentDayStart = now()->startOfDay();
        $currentDayEnd = now()->setHour(7)->setMinute(0)->setSecond(0); // 07:00 night shift end


        $teaCount = Logs::where('bsl_cmn_logs_mealtype', 1)
            ->whereBetween('bsl_cmn_logs_time', [$dayShiftStart, $dayShiftEnd])
            ->count();
        $lunchCount = Logs::where('bsl_cmn_logs_mealtype', 2)
            ->whereBetween('bsl_cmn_logs_time', [$dayShiftStart, $dayShiftEnd])
            ->count();

        // Count the number of logs for supper between 19:00 and 23:59 on the previous day
        $supperCountPreviousDay = Logs::where('bsl_cmn_logs_mealtype', 3)
            ->whereBetween('bsl_cmn_logs_time', [$previousDayStart, $previousDayEnd])
            ->count();
        // Count the number of logs for supper between 00:00 and 07:00 on the current day
        $supperCountCurrentDay = Logs::where('bsl_cmn_logs_mealtype', 3)
            ->whereBetween('bsl_cmn_logs_time', [$currentDayStart, $currentDayEnd])
            ->count();

        // Add the counts together to get the total supper count
        $supperCount = $supperCountCurrentDay + $supperCountPreviousDay;

        //night shift Tea Count between 19:00 and 23:59 on the previous day
        $nightTeaPrevDay =  Logs::where('bsl_cmn_logs_mealtype', 1)
            ->whereBetween('bsl_cmn_logs_time', [$previousDayStart, $previousDayEnd])
            ->count();

        // Count the number of logs for tea between 00:00 and 07:00 on the current day
        $nightTeaCurrDay = Logs::where('bsl_cmn_logs_mealtype', 1)
            ->whereBetween('bsl_cmn_logs_time', [$currentDayStart, $currentDayEnd])
            ->count();

        $nightTeaCount = $nightTeaPrevDay + $nightTeaCurrDay;

        //echo $teaCount;
        //dd($logs);
        return view('admin.dashboard', [
            'user' => $user,
            'logs' => $logs,
            'teaCount' => $teaCount,
            'lunchCount' => $lunchCount,
            'supperCount' => $supperCount,
            'nightTeaCount' => $nightTeaCount
        ]);
    }
}
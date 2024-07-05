<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;
use App\Services\PrintHelper;
use Carbon\Carbon;

class MealticketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $logs = Logs::with('user', 'mealType')->get();

        return view('admin.tickets', ['logs' => $logs]);
    }

    public function printTicket(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'userid' => 'required|integer',
        ]);

        // Retrieve the log entry
        $log = Logs::with('user', 'mealType')->findOrFail($validatedData['userid']);

        // Prepare the data for printing
        $mealDetails = (object) [
            'userid' => $log->user->bsl_cmn_users_id,
            'userName' => $log->user->bsl_cmn_users_firstname . ' ' . $log->user->bsl_cmn_users_lastname,
            'staffid' => $log->user->bsl_cmn_users_employment_number,
            'department' => $log->user->bsl_cmn_users_department,
            'company' => $log->user->userType->bsl_cmn_user_types_name,
            'mealtype' => $log->mealType->bsl_cmn_mealtypes_mealname,
            'date' => Carbon::parse($log->bsl_cmn_logs_time)->timezone('Africa/Nairobi')->format('d/m/Y H:i:s'),
        ];

        // Printer details (these should be fetched or configured appropriately)
        $printerAddress = 'your_printer_ip_or_address';
        $printerPort = 631; // Default IPP port

        // Handle printing
        $printer = new PrintHelper($printerAddress, $printerPort);
        $printer->printMealTicket($mealDetails);

        return response()->json(['success' => 'Printing initiated.']);
    }
}

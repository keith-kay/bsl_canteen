<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;
use App\Models\User_type;
use App\Models\Sites;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $logs = Logs::with('user', 'mealType', 'site')->get();

        return view('admin.reports', ['logs' => $logs]);
    }
    public function fetchCompanies()
    {
        $companies = User_type::pluck('bsl_cmn_user_types_name');
        return response()->json($companies);
    }
    public function fetchSites()
    {
        $sites = Sites::pluck('bsl_cmn_sites_name');
        return response()->json($sites);
    }
}

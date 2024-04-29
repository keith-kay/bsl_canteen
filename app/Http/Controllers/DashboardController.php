<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomUser;
use App\Models\Logs;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        // Get the names of all logged-in users
        //$loggedInUsers = CustomUser::selectRaw("CONCAT(bsl_cmn_users_firstname, ' ', bsl_cmn_users_lastname) AS full_name")->pluck('full_name')->toArray();

        return view('auth.dashboard',);
    }
}
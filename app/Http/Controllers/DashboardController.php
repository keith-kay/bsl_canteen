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

        $ip_address = '';

        // Check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Check for IP address passed by proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Check for the client IP address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        // Handle cases where there might be multiple IP addresses
        if (strpos($ip_address, ',') !== false) {
            $ip_address = explode(',', $ip_address)[0];
        }

        ($ip_address);

        return view('auth.dashboard', ['ip_address' => $ip_address]);
    }
}

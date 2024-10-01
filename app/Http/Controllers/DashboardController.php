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
    public function index(Request $request)
    {

        $user = Auth::user();
        $user = Auth::user();
        
        return view('auth.dashboard')->with(
            [
                'user' => $user,
                'ip_address' => $request->ip(),
            ]
        );
        
    }
}
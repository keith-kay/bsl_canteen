<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        // Check if the user is not authenticated
        if (!Auth::check()) {
            // Redirect the user to the login page
            return redirect()->route('login');
        }

        // User is authenticated, allow the request to proceed
        return $next($request);
    }
}
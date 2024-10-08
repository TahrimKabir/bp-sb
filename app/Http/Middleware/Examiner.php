<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Examiner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the authenticated user is an examiner
        if (Auth::check() && Auth::user()->role === 'examiner') {
            return $next($request); // Allow access if user is an examiner
        }

        // Redirect or abort if the user is not an examiner
        return redirect('/')->withErrors(['You do not have permission to perform this action.']);
    }
}

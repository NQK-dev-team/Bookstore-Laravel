<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectVerifiedEmail
{
    /**
     * Check if the authenticated customer's email is verified, if yes then redirect the customer to the home page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Gate::allows('isVerified'))
            return redirect()->route('customer.index');

        return $next($request);
    }
}

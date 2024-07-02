<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail
{
    /**
     * Check if the authenticated customer's email is verified, if not then redirect the customer to the email verification page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Gate::allows('isVerified'))
            return redirect()->route('customer.authentication.verify-email');

        return $next($request);
    }
}

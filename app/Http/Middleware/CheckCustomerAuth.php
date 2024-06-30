<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerAuth
{
    /**
     * Check if the customer is authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('customer.authentication.index');
        }

        if (!Gate::allows('isAdmin')) {
            return $next($request);
        }
        // else {
        //     return redirect()->route('admin.index');
        // }
    }
}

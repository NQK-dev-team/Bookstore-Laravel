<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RedirectCustomer
{
    /**
     * Check if the customer is authenticated if yes then redirect the customer to the appropriate route
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Gate::allows('isAdmin')) {
            return redirect()->route('customer.index');
        }

        return $next($request);
    }
}

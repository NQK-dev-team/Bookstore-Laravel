<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuth
{
    /**
     * Check if the user is authenticated, if yes redirect to the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (str_contains($request->route()->getName(), 'admin'))
                return redirect()->route('admin.index');
            else
                return redirect()->route('customer.index');
        }

        return $next($request);
    }
}

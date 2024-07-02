<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Check if the user is authenticated, if not redirect to the login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if (str_contains($request->route()->getName(), 'admin'))
                return redirect()->route('admin.authentication.index');
            else
                return redirect()->route('customer.authentication.index');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RedirectRole
{
    /**
     * Redirect the user to the appropriate route based on the user type
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            if (Auth::check() && !Gate::allows('isAdmin')) {
                return redirect()->route('customer.index');
            }
        } else {
            if (Auth::check() && Gate::allows('isAdmin')) {
                return redirect()->route('admin.index');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAuth
{
  /**
   * Check if the admin is authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::check()) {
      return redirect()->route('admin.authentication.index');
    }

    if (Gate::allows('isAdmin')) {
      return $next($request);
    } else {
      return redirect()->route('customer.index');
    }
  }
}

<?php

namespace App\Http\Middleware;

use Closure;
use voku\helper\AntiXSS;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitization
{
    /**
     * Sanitize input from XSS attacks.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $antiXss = new AntiXSS();
        array_walk_recursive($input, function (&$input) use ($antiXss) {
            $input = $antiXss->xss_clean($input);
        });
        $request->merge($input);

        return $next($request);
    }
}

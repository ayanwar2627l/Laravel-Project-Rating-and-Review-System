<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    if (auth()->check() && auth()->user()->is_admin == 1) {
        return $next($request);
    }

    return redirect('/')->with('error', 'Access Denied! Admin only area.');
    }
}

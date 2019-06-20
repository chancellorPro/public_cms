<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Class RedirectIfAuthenticated
 */
class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param Request     $request Request
     * @param Closure     $next    Closure
     * @param string|null $guard   Guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}

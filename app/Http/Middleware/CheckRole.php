<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Cookie;

/**
 * Class CheckRole
 */
class CheckRole
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request Request
     * @param Closure $next    Closure
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pagesGate = config('pagesgate');

        $routeName      = $request->route()->getName();
        $routeNameParts = explode('.', $routeName);
        $pageName       = $routeNameParts[0] ?? '';

        if (Auth::user()->isSuperAdmin()) {
            $cookie = Cookie::make('is_super_admin', true, 5);
        } else {
            $cookie = Cookie::forget('is_super_admin');
        }
        
        if (isset($pagesGate[$pageName]['pages'])) {
            $params = $request->route()->parameters();
            foreach ($pagesGate[$pageName]['params'] ?? [] as $usedParam) {
                if (isset($params[$usedParam])) {
                    $routeName .= '/' . $params[$usedParam];
                }
            }
        }

        if (Gate::allows($routeName)) {
            return $next($request)->withCookie($cookie);
        }

        return redirect('forbidden');
    }
}

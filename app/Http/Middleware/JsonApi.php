<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 11.12.18
 * Time: 15:27
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * JsonApi Middleware
 * Prepare POST raw data
 */
class JsonApi
{

    /**
     * Parsed methods
     *
     * @var array
     */
    const PARSED_METHODS = [
        'POST',
        'PUT',
        'PATCH',
    ];

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
        if (in_array($request->getMethod(), self::PARSED_METHODS)) {
            $request->merge($request->json()->all());
        }

        return $next($request);
    }
}

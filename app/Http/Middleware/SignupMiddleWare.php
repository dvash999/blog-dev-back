<?php

namespace App\Http\Middleware;

use Closure;

class SignupMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $headerName = 'X-Name')
    {
        $response = $next($request);
//        $response->headers('Content-Security-Policy': font-src 'self' data:);
        $response->headers->set($headerName, config('app.name'));

        return $response;
    }
}

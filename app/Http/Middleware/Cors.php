<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://127.0.0.1:5500')
            ->header('Access-Control-Request-Method', 'OPTIONS, POST')
            ->header('Access-Control-Request-Headers', 'Content-Type')
            ->header('Content-Type', 'application/json');
//            ->header('Accept', '*/*');
    }
}

<?php


namespace App\Http\Middleware;


use App\Facades\Authorization;
use Closure;
use Illuminate\Http\Request;

class ApiAuthenticate
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!in_array($role, ['administrator', 'doctor', 'patient'])) {
            abort(500, 'Undefined value of $role variable:' . $role);
        }

        if (Authorization::check($role)) {
            return $next($request);
        }

        abort(403, 'Api request forbidden');
    }
}

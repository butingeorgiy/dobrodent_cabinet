<?php

namespace App\Http\Middleware;


use App\Facades\Authorization;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!in_array($role, ['administrator', 'doctor', 'patient'])) {
            abort(500, 'Undefined value of $role variable:' . $role);
        }


        if (Authorization::check()) {
            Authorization::user()->invalidTokens()->delete();

            return $next($request);
        } else {
            return redirect('/' . $role . '/login');
        }
    }
}

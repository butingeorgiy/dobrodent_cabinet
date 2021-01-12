<?php

namespace App\Http\Middleware;


use App\Facades\Authorization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Authenticate
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!in_array($role, ['administrator', 'doctor', 'patient'])) {
            abort(500, 'Undefined value of $role variable:' . $role);
        }


        if (Authorization::check()) {
            $user = Authorization::user();

            $user->invalidTokens()->delete();

            if (Storage::exists('profile_photos/' . Str::plural($role) .'/' . $user->id . '.jpeg')) {
                $profilePhoto = Storage::get('profile_photos/' . Str::plural($role) .'/' . $user->id . '.jpeg');
            } else {
                $profilePhoto = null;
            }

            View::share(compact('profilePhoto'));

            return $next($request);
        } else {
            return redirect('/' . $role . '/login');
        }
    }
}

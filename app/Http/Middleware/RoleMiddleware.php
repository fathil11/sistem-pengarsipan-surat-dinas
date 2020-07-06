<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if (!Auth::check()) {
            // For Testing
            dd('Belum masuk');
            return redirect('masuk');
        }

        foreach ($roles as $role) {
            if (Auth::user()->getRole() == $role) {
                return $next($request);
            }
        }

        dd('Akses tidak sesuai');
        return redirect('masuk');
    }
}

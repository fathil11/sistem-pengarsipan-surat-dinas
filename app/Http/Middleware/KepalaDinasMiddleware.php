<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class KepalaDinasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // For Testing
            dd('Belum Login');
            return redirect('masuk');
        }

        $user = Auth::user();
        $role = $user->position->role;

        if ($role == "Kepala Dinas") {
            return $next($request);
        }

        // For Testing
        dd("Akses tidak sesuai");
        return redirect('masuk');
    }
}

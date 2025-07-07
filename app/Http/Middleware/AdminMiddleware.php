<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login dan rolenya adalah admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, tolak akses
        abort(403, 'Akses ditolak. Anda bukan admin.');
    }
}

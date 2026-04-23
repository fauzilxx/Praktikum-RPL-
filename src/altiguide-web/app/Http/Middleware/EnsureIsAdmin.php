<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Pastikan yang mengakses adalah Admin, bukan User biasa.
     * Middleware ini mencegah User (pendaki) mengakses halaman admin
     * meskipun mereka sudah login di guard 'web'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika tidak login sebagai admin → tolak
        if (! Auth::guard('admin')->check()) {
            // Jika request dari API, return JSON 403
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akses ditolak. Anda bukan admin.',
                ], 403);
            }

            // Jika request dari web, abort 403
            abort(403, 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}

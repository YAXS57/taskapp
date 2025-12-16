<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDosen
{
    public function handle(Request $request, Closure $next): Response
    {
        // CEK APAKAH SUDAH LOGIN?
        if (!session('is_dosen')) {
            // Jika belum, tendang ke halaman login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
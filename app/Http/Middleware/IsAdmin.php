<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
        }

        // 2. Pastikan user memiliki role 'cashier'
        // ASUMSI: Anda memiliki kolom 'role' di tabel users dengan nilai 'cashier'
        if (Auth::user()->role !== 'admin') {
            // Jika user tidak berhak, kita bisa arahkan ke halaman home atau tampilkan error 403
            return redirect('/login')->with('error', 'Akses ditolak. Anda bukan admin.');
            // Atau untuk profesional, kembalikan response 403:
            // abort(403, 'Akses Terlarang.');
        }

        return $next($request);
    }
}

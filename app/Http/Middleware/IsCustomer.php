<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role 'customer'
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request);
        }

        // Jika bukan customer, redirect ke halaman login atau tampilkan error
        return redirect()->route('login')->withErrors([
            'email' => 'Akses ditolak. Anda harus login sebagai customer.',
        ]);
    }
}

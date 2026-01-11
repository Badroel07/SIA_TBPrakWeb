<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // GANTI ISINYA MENJADI KODE DI BAWAH INI
        // Jika permintaan adalah AJAX/API, kembalikan null (tidak redirect)
        if (! $request->expectsJson()) {
            // Jika bukan AJAX, dan Anda TIDAK INGIN MENGGUNAKAN NAMA ROUTE 'login',
            // kembalikan nama route atau path yang Anda inginkan, atau null
            // untuk mematikan redirect.
            return route('login_saya'); // Ganti 'login_saya' dengan route login Anda nanti
        }

        return null;
    }
}

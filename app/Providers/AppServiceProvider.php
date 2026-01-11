<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Import Facade URL
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
// Tambahkan logika ini
    if (config('app.env') !== 'local') { // Atau jika mau paksa di local juga, hapus if-nya
        URL::forceScheme('https');
    }
    
    // Opsi alternatif jika cara di atas kurang pas buat ngrok saat dev:
    // Paksa HTTPS jika request datang dari Ngrok
    if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {
        URL::forceScheme('https');
    }

        Paginator::useTailwind();

        // Anda juga bisa mencoba ini, terutama jika Anda menggunakan Load Balancer/Proxy
        /*
        if ($this->app->environment('production', 'staging')) {
            \URL::forceScheme('https');
        }
        */
    }
}

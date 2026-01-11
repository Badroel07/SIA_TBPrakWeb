<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\IsCashier;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsCustomer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // TAMBAHKAN ALIAS MIDDLEWARE KASIR DI SINI:
            'is_cashier' => IsCashier::class,
            'is_admin' => IsAdmin::class,
            'is_customer' => IsCustomer::class,
        ]);
        
        $middleware->validateCsrfTokens(except: [
            '/midtrans/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

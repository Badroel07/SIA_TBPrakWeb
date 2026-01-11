<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\CustomerOrder;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-cancel orders with pending payment after 24 hours
Schedule::call(function () {
    $expiredOrders = CustomerOrder::where('payment_status', 'pending')
        ->where('created_at', '<', now()->subHours(24))
        ->whereNotIn('status', ['cancelled'])
        ->get();

    foreach ($expiredOrders as $order) {
        $order->update([
            'status' => 'cancelled',
            'notes' => 'Dibatalkan otomatis: pembayaran tidak diterima dalam 24 jam.',
        ]);
    }
})->hourly()->name('auto-cancel-pending-orders');

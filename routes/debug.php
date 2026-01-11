<?php

use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Models\CustomerOrder;
use Carbon\Carbon;

Route::get('/debug-dashboard', function () {
    $today = Carbon::today();
    return response()->json([
        'transactions' => Transaction::whereDate('created_at', $today)->get(['id', 'status', 'created_at']),
        'orders' => CustomerOrder::whereDate('created_at', $today)->get(['id', 'status', 'payment_status', 'created_at']),
    ]);
});

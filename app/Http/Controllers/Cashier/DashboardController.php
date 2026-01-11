<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\CustomerOrder;
use App\Models\Medicine;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Daily Revenue (POS + Online)
        $posRevenue = Transaction::whereDate('created_at', $today)->sum('total_amount');
        $onlineRevenue = CustomerOrder::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        $totalRevenue = $posRevenue + $onlineRevenue;

        // 2. Daily Customers (Unique Transactions)
        $posCustomers = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();
        $onlineCustomers = CustomerOrder::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->count();
        $totalCustomers = $posCustomers;

        // 3. Low Stock Items
        $lowStockItems = Medicine::where('stock', '<=', 5)->count();

        // 4. Pending Orders
        $pendingOrders = CustomerOrder::where('status', 'pending')
                         ->orWhere('status', 'processing')
                         ->count();

        // 5. Recent Transactions (POS) - Limit 5
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('cashier.dashboard.index', compact(
            'totalRevenue',
            'totalCustomers',
            'lowStockItems',
            'pendingOrders',
            'recentTransactions'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menghitung dan menampilkan statistik utama untuk dashboard admin.
     */
    public function index()
    {
        // Data 5 obat dengan stok paling sedikit (peringatan)
        $lowStockMedicines = Medicine::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(5)->get();

        // Real Revenue from Transactions
        $totalRevenue = \App\Models\Transaction::sum('total_amount');
        $totalOrders = \App\Models\Transaction::count();
        $activeUsers = \App\Models\User::where('role', 'customer')->count();

        // Real Recent Orders
        $recentOrders = \App\Models\Transaction::with(['user', 'details.medicine'])
            ->latest()
            ->take(5)
            ->get();

        // Popular Medicines (Ambil dari DB sorted by sales)
        $popularMedicines = Medicine::orderBy('total_sold', 'desc')->take(3)->get();

        // Calculate percentages/formatted strings
        $revenueFormatted = $totalRevenue >= 1000000
            ? number_format($totalRevenue / 1000000, 1, ',', '.') . 'M'
            : number_format($totalRevenue, 0, ',', '.');

        $stats = [
            'totalRevenue' => $revenueFormatted,
            'totalOrders' => number_format($totalOrders, 0, ',', '.'),
            'activeUsers' => number_format($activeUsers, 0, ',', '.'),
        ];

        // Ambil semua kategori unik untuk filter dropdown di Modal Create
        $existingCategories = Medicine::distinct()
            ->pluck('category')
            ->map(fn($c) => trim($c))
            ->filter(fn($c) => !empty($c))
            ->unique()
            ->values()
            ->toArray();

        return view('admin.index', compact('stats', 'lowStockMedicines', 'recentOrders', 'popularMedicines', 'existingCategories'));
    }
}

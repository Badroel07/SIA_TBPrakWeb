@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-gray-500 mt-1">Selamat datang kembali, berikut adalah ringkasan informasi terkini.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Revenue -->
        <div
            class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-purple-50 rounded-lg text-[#6200EA]">
                    <span class="material-icons-round">payments</span>
                </div> 
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ $stats['totalRevenue'] }}</p>
        </div>

        <!-- Orders -->
        <div
            class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <span class="material-icons-round">shopping_bag</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Orders</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['totalOrders'] }}</p>
        </div>

        <!-- Low Stock -->
        <div
            class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <span class="material-icons-round">medication</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Stok Obat Rendah</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ count($lowStockMedicines) }}</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Orders (Left, 2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div
                class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-transparent to-purple-50/50">
                <h3 class="font-bold text-gray-800 text-lg">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-[#6200EA] hover:text-purple-700 text-sm font-semibold flex items-center">
                    Tampilkan Semua <span class="material-icons-round text-sm ml-1">arrow_forward</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-xs uppercase text-gray-500 font-semibold tracking-wide">
                            <th class="px-6 py-4 rounded-tl-lg">ID Pesanan</th>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 rounded-tr-lg">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $order->invoice_number }}</td>
                                <td class="px-6 py-4 text-gray-600 truncate max-w-[150px]">
                                    {{ $order->details->first()?->medicine->name ?? 'Item Pesanan' }}
                                    @if($order->details->count() > 1)
                                        <span class="text-xs text-gray-400"> +{{ $order->details->count() - 1 }} more</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match ($order->status) {
                                            'completed' => 'bg-green-100 text-green-800',
                                            'processing' => 'bg-yellow-100 text-yellow-800',
                                            'shipped' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-gray-100 text-gray-800',
                                            default => 'bg-gray-100 text-gray-800' // Default case
                                        };
                                        // Ensure status is capitalized for display
                                        $displayStatus = ucfirst($order->status);
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side (Popular & Low Stock) -->
        <div class="flex flex-col gap-6">

            <!-- Popular Medicine -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Obat Populer</h3>
                <div class="space-y-4">
                    @forelse($popularMedicines as $medicine)
                        @php
                            $icon = 'medication';
                            if (stripos($medicine->category, 'alat') !== false) $icon = 'medical_services';
                            if (stripos($medicine->category, 'sirup') !== false) $icon = 'liquids';
                            if (stripos($medicine->category, 'tablet') !== false) $icon = 'tablets';
                        @endphp
                        <div
                            class="flex items-center gap-4 p-2 rounded-lg transition-colors group">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                <span
                                    class="material-icons-round text-gray-400">{{ $icon }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-800">{{ $medicine->name }}</h4>
                                <p class="text-xs text-gray-500">{{ ucfirst($medicine->category) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ number_format($medicine->total_sold ?? 0) }}</p>
                                <p class="text-xs text-green-500">Terjual</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <span class="material-icons-round text-gray-300 text-4xl mb-2">sentiment_dissatisfied</span>
                            <p class="text-gray-500 text-sm">Belum ada data penjualan.</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('admin.medicines.index') }}"
                    class="block text-center w-full mt-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 font-medium hover:bg-gray-50 transition-colors">Tampilkan Data Obat</a>
            </div>

            <!-- Low Stock Alert -->
            @php
                $alertBg = count($lowStockMedicines) > 0 ? 'bg-gradient-to-r from-red-600 to-rose-600' : 'bg-gradient-to-r from-[#6200EA] to-[#7C4DFF]';
            @endphp
            <div
                class="{{ $alertBg }} rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-icons-round text-9xl transform rotate-12">local_shipping</span>
                </div>
                <h3 class="font-bold text-lg mb-2 relative z-10">Peringatan Stok Rendah</h3>

                @if(count($lowStockMedicines) > 0)
                    <p class="text-sm text-purple-100 mb-4 relative z-10">
                        Kamu memiliki <span class="font-bold text-white">{{ count($lowStockMedicines) }} obat</span> yang stoknya rendah. Segera restock!
                    </p>
                    <a href="{{ route('admin.medicines.index') }}"
                        class="inline-block bg-white text-[#6200EA] text-sm font-bold py-2 px-4 rounded-lg shadow-sm hover:bg-gray-50 transition-colors relative z-10">
                        Cek Stok
                    </a>
                @else
                    <p class="text-sm text-purple-100 mb-4 relative z-10">
                        Semua stok aman terkendali.
                    </p>
                    <button class="bg-white/20 text-white text-sm font-bold py-2 px-4 rounded-lg cursor-default relative z-10">
                        Stok Aman
                    </button>
                @endif
            </div>

        </div>
    </div>
@endsection
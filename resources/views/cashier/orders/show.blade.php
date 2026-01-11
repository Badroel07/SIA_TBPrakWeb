@extends('cashier.layouts.app', ['activeMenu' => 'orders'])

@section('title', 'Detail Pesanan #' . $order->order_number . ' - ePharma POS')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
    <div class="max-w-6xl mx-auto space-y-6">
        
        <!-- Back Button -->
        <a href="{{ route('cashier.orders.incoming') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors font-medium">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Daftar Pesanan
        </a>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl font-bold text-slate-900">{{ $order->order_number }}</h1>
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 
                               ($order->payment_status == 'refunded' ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-700') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <p class="text-slate-500">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>

                <!-- Status Badge -->
                <div class="flex flex-col items-end gap-2">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold
                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $order->status == 'arrived' ? 'bg-indigo-100 text-indigo-700' : '' }}
                        {{ $order->status == 'received' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $order->status == 'cancel_requested' ? 'bg-orange-100 text-orange-700 animate-pulse' : '' }}
                    ">
                        @php
                            $icons = [
                                'pending' => 'pending',
                                'processing' => 'inventory_2',
                                'shipped' => 'local_shipping',
                                'arrived' => 'package_2',
                                'received' => 'check_circle',
                                'cancelled' => 'cancel',
                                'cancel_requested' => 'warning'
                            ];
                        @endphp
                        <span class="material-symbols-outlined text-[18px]">{{ $icons[$order->status] ?? 'circle' }}</span>
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            <!-- Left Column: Customer & Shipping Info (Combined) -->
            <div class="md:col-span-1 flex flex-col">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-full flex flex-col gap-6">
                    <!-- Customer Info -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <span class="material-symbols-outlined text-lg">person</span>
                            Informasi Pelanggan
                        </h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-500">Nama Penerima</p>
                                <p class="font-bold text-slate-900 text-base">{{ $order->recipient_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Email</p>
                                <p class="font-medium text-slate-900">{{ $order->customer_email ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Nomor Telepon</p>
                                <p class="font-bold text-slate-900">{{ $order->recipient_phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Alamat Pengiriman</p>
                                <p class="font-medium text-slate-700 mt-1 leading-relaxed">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                                </p>
                            </div>
                            
                            @if($order->latitude && $order->longitude)
                            <div class="pt-3">
                                <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" target="_blank" 
                                    class="inline-flex items-center gap-2 w-full justify-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl text-sm font-bold transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                    Lihat di Peta
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <div class="flex-1">
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <span class="material-symbols-outlined text-lg">local_shipping</span>
                            Pengiriman
                        </h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-500">Kurir</p>
                                <p class="font-bold text-slate-900">{{ $order->courier_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Layanan</p>
                                <p class="font-bold text-slate-900">{{ $order->courier_service }}</p>
                            </div>
                            @if($order->tracking_number)
                            <div class="pt-2 border-t border-slate-100 mt-2">
                                <p class="text-xs text-slate-500">Nomor Resi</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="font-mono font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded">{{ $order->tracking_number }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}')" class="text-slate-400 hover:text-blue-600">
                                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Items & Actions (Combined) -->
            <div class="md:col-span-2 flex flex-col">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col">
                    <div class="p-6 border-b border-slate-100 shrink-0">
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">shopping_cart</span>
                            Item Pesanan & Tindakan
                        </h2>
                    </div>
                    
                    <!-- Table Container (Scrollable) -->
                    <div class="overflow-x-auto overflow-y-auto max-h-[350px] flex-1 bg-white">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 bg-slate-50">Produk</th>
                                    <th class="px-6 py-4 bg-slate-50 text-center">Qty</th>
                                    <th class="px-6 py-4 bg-slate-50 text-right">Harga Satuan</th>
                                    <th class="px-6 py-4 bg-slate-50 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->items as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($item->medicine && $item->medicine->image)
                                                <img src="{{ asset('storage/' . $item->medicine->image) }}" alt="" class="w-10 h-10 object-cover rounded-lg bg-slate-100">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <span class="material-symbols-outlined text-xl">medication</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-900">{{ $item->medicine_name }}</p>
                                                <p class="text-xs text-slate-500">{{ $item->medicine ? $item->medicine->category : 'Umum' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right text-slate-500">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary (Sticky Footer) -->
                    <div class="bg-slate-50 border-t border-slate-200 shrink-0">
                        <div class="flex justify-between px-6 py-3 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Subtotal Item</span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between px-6 py-3 border-b border-slate-100">
                            <span class="text-slate-500 font-medium">Ongkos Kirim</span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between px-6 py-4 bg-blue-50/50">
                            <span class="text-lg font-bold text-blue-700">Total Tagihan</span>
                            <span class="text-lg font-bold text-blue-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Actions (Footer) -->
                    <div class="p-6 border-t border-slate-200 bg-slate-50 shrink-0">
                         <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2 justify-end">
                             Tindakan
                         </h2>
                         <div class="flex flex-wrap gap-3 justify-end">
                            @if($order->status == 'pending')
                                @if($order->payment_status == 'paid')
                                    <form action="{{ route('cashier.orders.reject', $order->id) }}" method="POST" onsubmit="return confirm('Tolak pesanan?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition-all">
                                            <span class="material-symbols-outlined">close</span>
                                            Tolak Pesanan
                                        </button>
                                    </form>
                                    <form action="{{ route('cashier.orders.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Proses pesanan ini?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
                                            <span class="material-symbols-outlined">check_box</span>
                                            Proses Pesanan
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full p-4 bg-yellow-50 text-yellow-800 rounded-xl flex items-center gap-3">
                                        <span class="material-symbols-outlined">hourglass_empty</span>
                                        <p class="font-medium">Menunggu pembayaran dari pelanggan.</p>
                                    </div>
                                @endif
                            @elseif($order->status == 'processing')
                                <form action="{{ route('cashier.orders.send', $order->id) }}" method="POST" onsubmit="return confirm('Kirim pesanan ini?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
                                        <span class="material-symbols-outlined">local_shipping</span>
                                        Kirim Pesanan
                                    </button>
                                </form>
                            @elseif($order->status == 'shipped')
                                <form action="{{ route('cashier.orders.arrived', $order->id) }}" method="POST" onsubmit="return confirm('Tandai paket tiba?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all">
                                        <span class="material-symbols-outlined">package_2</span>
                                        Tandai Paket Tiba
                                    </button>
                                </form>
                            @elseif($order->status == 'cancel_requested')
                                <form action="{{ route('cashier.orders.approveCancel', $order->id) }}" method="POST" onsubmit="return confirm('Setujui pembatalan?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/20 transition-all">
                                        <span class="material-symbols-outlined">check</span>
                                        Setujui Pembatalan
                                    </button>
                                </form>
                                <form action="{{ route('cashier.orders.rejectCancel', $order->id) }}" method="POST" onsubmit="return confirm('Tolak pembatalan?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all">
                                        <span class="material-symbols-outlined">close</span>
                                        Tolak Pembatalan
                                    </button>
                                </form>
                            @else
                                <div class="px-6 py-4 bg-slate-100 rounded-xl text-slate-500 font-medium italic">
                                    Tidak ada tindakan tersedia.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

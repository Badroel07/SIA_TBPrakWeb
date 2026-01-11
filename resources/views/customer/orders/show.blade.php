@extends('customer.layouts.app')

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            const payButton = document.getElementById('pay-button');
            if(payButton) {
                payButton.addEventListener('click', function () {
                    @if($order->snap_token)
                        snap.pay('{{ $order->snap_token }}', {
                            onSuccess: function(result){
                                window.location.reload();
                            },
                            onPending: function(result){
                                window.location.reload();
                            },
                            onError: function(result){
                                console.error(result);
                                alert("Pembayaran gagal!");
                            },
                            onClose: function(){}
                        });
                    @else
                        alert('Token pembayaran tidak valid.');
                    @endif
                });
            }
        });
    </script>
@endsection

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Back Button -->
        <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 mb-6 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Riwayat Pesanan
        </a>

        <!-- Order Header -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">No. Pesanan</p>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 break-all">{{ $order->order_number }}</h1>
                    <p class="text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped' => 'bg-purple-100 text-purple-700',
                            'arrived' => 'bg-indigo-100 text-indigo-700',
                            'received' => 'bg-green-100 text-green-700',
                            'delivered' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'arrived' => 'Paket Tiba',
                            'received' => 'Diterima',
                            'cancelled' => 'Dibatalkan',
                        ];
                        $paymentColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'paid' => 'bg-green-100 text-green-700',
                            'failed' => 'bg-red-100 text-red-700',
                            'expired' => 'bg-gray-100 text-gray-700',
                            'refunded' => 'bg-orange-100 text-orange-700',
                        ];
                    @endphp
                    <span class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        @if($order->status == 'pending' && $order->payment_status == 'paid')
                            Status: Menunggu Konfirmasi
                        @else
                            Status: {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                        @endif
                    </span>
                    <span class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-medium {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }}">
                        Pembayaran: {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Shipping Info -->
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 order-1">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    Alamat Pengiriman
                </h2>
                <div class="space-y-2 text-gray-600 text-sm sm:text-base">
                    <p class="font-semibold text-gray-900">{{ $order->recipient_name }}</p>
                    @if($order->customer_email)
                        <p class="text-gray-500"><span class="font-medium">Email:</span> {{ $order->customer_email }}</p>
                    @endif
                    <p>{{ $order->recipient_phone }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
                </div>

                @if($order->courier_name)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-500">Kurir</p>
                    <p class="font-medium text-gray-900">{{ $order->courier_name }} - {{ $order->courier_service }}</p>
                    @if($order->tracking_number)
                        <div class="mt-2">
                             <p class="text-sm text-gray-500">Nomor Resi</p>
                             <div class="flex gap-2 items-center">
                                 <p class="font-bold text-gray-900 break-all">{{ $order->tracking_number }}</p>
                             </div>
                        </div>
                    @endif
                    
                    <!-- Delivery Status based on Order Status -->
                    @if(in_array($order->status, ['shipped', 'arrived']))
                    <div class="mt-4 p-4 rounded-xl {{ $order->status == 'arrived' ? 'bg-green-50 border border-green-200' : 'bg-purple-50 border border-purple-200' }}">
                        <div class="flex items-start sm:items-center gap-3">
                            @if($order->status == 'shipped')
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-purple-700 text-sm sm:text-base">Kurir sedang mengantar paket ke rumah Anda</p>
                                <p class="text-xs sm:text-sm text-purple-600">Harap siap menerima paket Anda</p>
                            </div>
                            @else
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-700 text-sm sm:text-base">Paket telah tiba!</p>
                                <p class="text-xs sm:text-sm text-green-600">Silahkan konfirmasi penerimaan pesanan Anda</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Item Pesanan (Swapped to Right Column) -->
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 order-2 lg:order-2">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Item Pesanan</h2>
                <div class="space-y-4 max-h-[250px] overflow-y-auto pr-2">
                    @foreach($order->items as $item)
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center py-4 border-b last:border-b-0">
                        <div class="flex items-center gap-4 flex-1 w-full">
                            <div class="w-16 h-16 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden">
                                @if($item->medicine && $item->medicine->image)
                                <img src="{{ asset('storage/' . $item->medicine->image) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $item->medicine_name }}</h3>
                                <p class="text-gray-500 text-xs sm:text-sm">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto text-right sm:text-left pl-[5rem] sm:pl-0 mt-[-1rem] sm:mt-0">
                            <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Pembayaran (Swapped to Bottom Full Width) -->
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mt-6 lg:mt-0 order-3 lg:order-3 lg:col-span-2">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Ringkasan Pembayaran
                </h2>
                <div class="space-y-3 text-sm sm:text-base">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ongkos Kirim</span>
                        <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-3">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($order->payment_status === 'pending' && !in_array($order->status, ['cancelled', 'cancel_requested']))
                <button id="pay-button" class="w-full mt-6 py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Bayar Sekarang
                </button>
                @endif
            </div>
        </div>
    </div>
</div>


    <script>
        // ... (any other scripts if needed, but for now removing the tracking logic)
    </script>
@endsection

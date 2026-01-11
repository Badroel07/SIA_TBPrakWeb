@extends('customer.layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Riwayat Pesanan
            </h1>
            <p class="text-gray-500 mt-2">Lihat status dan detail pesanan Anda</p>
        </div>

        @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pesanan</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                Mulai Belanja
            </a>
        </div>
        @else
        <!-- Orders List -->
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">No. Pesanan</p>
                            <p class="font-bold text-gray-900 break-all">{{ $order->order_number }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-between sm:items-center border-t border-gray-100 pt-4 sm:border-0 sm:pt-0">
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <!-- Status Badge -->
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'arrived' => 'bg-indigo-100 text-indigo-700',
                                    'received' => 'bg-green-100 text-green-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancel_requested' => 'bg-orange-100 text-orange-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran',
                                    'processing' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'arrived' => 'Paket Tiba',
                                    'received' => 'Diterima',
                                    'cancel_requested' => 'Minta Batal',
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
                            <span class="px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                @if($order->status == 'pending' && $order->payment_status == 'paid')
                                    Menunggu Konfirmasi
                                @else
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                @endif
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 mt-2 sm:mt-0">
                            <div class="flex justify-between items-center sm:block">
                                <span class="text-sm text-gray-500 sm:hidden">Total:</span>
                                <p class="font-bold text-lg text-blue-600 sm:text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 sm:flex gap-2 w-full sm:w-auto">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="col-span-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center text-sm sm:text-base">
                                    Detail
                                </a>
    
                                @if($order->status == 'pending' || $order->status == 'processing')
                                    <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');" class="col-span-1 block w-full">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-xl transition-colors text-center text-sm sm:text-base">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
    
                                @if($order->status == 'arrived')
                                    <form action="{{ route('customer.orders.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin pesanan sudah diterima?');" class="col-span-1 block w-full">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-xl transition-colors text-center text-sm sm:text-base">
                                            Diterima
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

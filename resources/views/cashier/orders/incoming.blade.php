@extends('cashier.layouts.app', ['activeMenu' => 'orders'])

@section('title', 'Order Masuk - ePharma POS')

@section('content')


    <!-- Main Content -->
    <main class="flex-1 overflow-hidden flex flex-col bg-background-light p-6" 
        x-data="{ activeTab: '{{ request('tab', 'incoming') }}' }"
        x-init="$watch('activeTab', value => {
            const url = new URL(window.location);
            url.searchParams.set('tab', value);
            window.history.pushState({}, '', url);
        })">
        <div class="w-full max-w-7xl mx-auto flex flex-col h-full gap-4">

            <!-- Pill Tabs Navigation -->
            <div class="mx-auto bg-transparent p-2 rounded-2xl shadow-md border border-slate-200">
                <div class="flex flex-wrap gap-2 justify-center">
                    <button @click="activeTab = 'incoming'"
                        :class="activeTab === 'incoming' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30 scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 scale-100'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ease-out transform">
                        <span class="material-symbols-outlined text-[18px]">pending_actions</span>
                        Pesanan Masuk
                        <span data-count-badge="incoming" data-show-zero="true" class="px-2 py-0.5 rounded-full text-xs transition-all duration-300" :class="activeTab === 'incoming' ? 'bg-white/20' : 'bg-blue-100 text-blue-700'">{{ $incomingOrders->total() }}</span>
                    </button>
                    <button @click="activeTab = 'shipped'"
                        :class="activeTab === 'shipped' ? 'bg-green-600 text-white shadow-lg shadow-green-500/30 scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 scale-100'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ease-out transform">
                        <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                        Pesanan Dikirim
                        <span data-count-badge="shipped" data-show-zero="true" class="px-2 py-0.5 rounded-full text-xs transition-all duration-300" :class="activeTab === 'shipped' ? 'bg-white/20' : 'bg-green-100 text-green-700'">{{ $shippedOrders->total() }}</span>
                    </button>
                    <button @click="activeTab = 'completed'"
                        :class="activeTab === 'completed' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30 scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 scale-100'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ease-out transform">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Pesanan Selesai
                        <span data-count-badge="completed" data-show-zero="true" class="px-2 py-0.5 rounded-full text-xs transition-all duration-300" :class="activeTab === 'completed' ? 'bg-white/20' : 'bg-emerald-100 text-emerald-700'">{{ $completedOrders->total() }}</span>
                    </button>
                    <button @click="activeTab = 'cancelled'"
                        :class="activeTab === 'cancelled' ? 'bg-red-600 text-white shadow-lg shadow-red-500/30 scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 scale-100'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ease-out transform">
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                        Pesanan Dibatalkan
                        <span data-count-badge="cancelled" data-show-zero="true" class="px-2 py-0.5 rounded-full text-xs transition-all duration-300" :class="activeTab === 'cancelled' ? 'bg-white/20' : 'bg-red-100 text-red-700'">{{ $cancelledOrders->total() }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content Container -->
            <div class="flex-1 overflow-y-auto scrollbar-hide">

                <!-- Tab 1: Pesanan Masuk -->
                <div x-show="activeTab === 'incoming'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">No. Order</th>
                                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                                        <th class="px-6 py-4 font-bold">Waktu</th>
                                        <th class="px-6 py-4 font-bold">Total</th>
                                        <th class="px-6 py-4 font-bold">Pembayaran</th>
                                        <th class="px-6 py-4 font-bold">Status</th>
                                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="incoming-table-body" class="divide-y divide-slate-100">
                                    @forelse ($incomingOrders as $order)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $order->recipient_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $order->recipient_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->created_at->format('d M H:i') }}<br>
                                                <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-xs font-bold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold {{ $order->status == 'cancel_requested' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }} animate-pulse">
                                                    <span class="material-symbols-outlined text-[14px]">{{ $order->status == 'cancel_requested' ? 'warning' : 'pending' }}</span>
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('cashier.orders.details', $order->id) }}" class="size-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Lihat Detail">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </a>
                                                    @if($order->status == 'processing')
                                                    <form action="{{ route('cashier.orders.send', $order->id) }}" method="POST" onsubmit="return confirm('Kirim pesanan ini?');">
                                                        @csrf
                                                        <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-blue-500 hover:bg-blue-600 shadow-md shadow-blue-500/20 transition-all" title="Kirim Pesanan">
                                                            <span class="material-symbols-outlined">local_shipping</span>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @if($order->status == 'pending')
                                                        @if($order->payment_status == 'paid')
                                                        <form action="{{ route('cashier.orders.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Proses pesanan ini?');">
                                                            @csrf
                                                            <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-green-500 hover:bg-green-600 shadow-md shadow-green-500/20 transition-all" title="Proses">
                                                                <span class="material-symbols-outlined">check_box</span>
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('cashier.orders.reject', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pesanan yang sudah dibayar ini? Stok akan dikembalikan dan order dibatalkan.');">
                                                            @csrf
                                                            <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-red-500 hover:bg-red-600 shadow-md shadow-red-500/20 transition-all" title="Tolak Pesanan">
                                                                <span class="material-symbols-outlined">close</span>
                                                            </button>
                                                        </form>
                                                        @else
                                                        <button disabled class="size-9 rounded-lg flex items-center justify-center text-slate-400 bg-slate-200 cursor-not-allowed" title="Menunggu pembayaran">
                                                            <span class="material-symbols-outlined">hourglass_empty</span>
                                                        </button>
                                                        @endif
                                                    @endif
                                                    @if($order->status == 'cancel_requested')
                                                    <div class="flex gap-1">
                                                        <form action="{{ route('cashier.orders.approveCancel', $order->id) }}" method="POST" onsubmit="return confirm('Setujui pembatalan?');">
                                                            @csrf
                                                            <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-green-500 hover:bg-green-600 shadow-md shadow-green-500/20 transition-all" title="Setuju">
                                                                <span class="material-symbols-outlined">check</span>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('cashier.orders.rejectCancel', $order->id) }}" method="POST" onsubmit="return confirm('Tolak pembatalan?');">
                                                            @csrf
                                                            <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-red-500 hover:bg-red-600 shadow-md shadow-red-500/20 transition-all" title="Tolak">
                                                                <span class="material-symbols-outlined">close</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-12 text-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">inbox</span>
                                                <p>Tidak ada pesanan masuk.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($incomingOrders->hasPages())
                        <div class="p-4 border-t border-slate-200 bg-slate-50">
                            {{ $incomingOrders->appends(['tab' => 'incoming'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tab 2: Pesanan Dikirim -->
                <div x-show="activeTab === 'shipped'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-surface-light rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">No. Order</th>
                                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                                        <th class="px-6 py-4 font-bold">Waktu</th>
                                        <th class="px-6 py-4 font-bold">Total</th>
                                        <th class="px-6 py-4 font-bold">Status</th>
                                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="shipped-table-body" class="divide-y divide-slate-100">
                                    @forelse ($shippedOrders as $order)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-slate-900">{{ $order->recipient_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $order->recipient_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->created_at->format('d M H:i') }}<br>
                                                <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                @if($order->status == 'arrived')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700">
                                                    <span class="material-symbols-outlined text-[14px]">package_2</span>Paket Tiba
                                                </span>
                                                @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                                    <span class="material-symbols-outlined text-[14px]">local_shipping</span>Dikirim
                                                </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('cashier.orders.details', $order->id) }}" class="size-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Lihat Detail">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </a>
                                                    @if($order->status == 'shipped')
                                                    <form action="{{ route('cashier.orders.arrived', $order->id) }}" method="POST" onsubmit="return confirm('Tandai paket tiba?');">
                                                        @csrf
                                                        <button type="submit" class="size-9 rounded-lg flex items-center justify-center text-white bg-indigo-500 hover:bg-indigo-600 shadow-md shadow-indigo-500/20 transition-all" title="Paket Tiba">
                                                            <span class="material-symbols-outlined">package_2</span>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-12 text-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">local_shipping</span>
                                                <p>Belum ada pesanan dikirim.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         @if($shippedOrders->hasPages())
                        <div class="p-4 border-t border-slate-200 bg-slate-50">
                            {{ $shippedOrders->appends(['tab' => 'shipped'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tab 3: Pesanan Selesai -->
                <div x-show="activeTab === 'completed'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-surface-light rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">No. Order</th>
                                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                                        <th class="px-6 py-4 font-bold">Waktu</th>
                                        <th class="px-6 py-4 font-bold">Total</th>
                                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="completed-table-body" class="divide-y divide-slate-100">
                                    @forelse ($completedOrders as $order)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-slate-900">{{ $order->recipient_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $order->recipient_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->created_at->format('d M H:i') }}<br>
                                                <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('cashier.orders.details', $order->id) }}" class="size-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all mx-auto" title="Lihat Detail">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">check_circle</span>
                                                <p>Belum ada pesanan selesai.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($completedOrders->hasPages())
                        <div class="p-4 border-t border-slate-200 bg-slate-50">
                            {{ $completedOrders->appends(['tab' => 'completed'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tab 4: Pesanan Dibatalkan -->
                <div x-show="activeTab === 'cancelled'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="bg-surface-light rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">No. Order</th>
                                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                                        <th class="px-6 py-4 font-bold">Waktu</th>
                                        <th class="px-6 py-4 font-bold">Total</th>
                                        <th class="px-6 py-4 font-bold">Catatan</th>
                                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="cancelled-table-body" class="divide-y divide-slate-100">
                                    @forelse ($cancelledOrders as $order)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-slate-900">{{ $order->recipient_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $order->recipient_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->created_at->format('d M H:i') }}<br>
                                                <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-slate-500 text-xs max-w-[200px] truncate" title="{{ $order->notes }}">
                                                {{ $order->notes ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('cashier.orders.details', $order->id) }}" class="size-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all mx-auto" title="Lihat Detail">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-12 text-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">cancel</span>
                                                <p>Tidak ada pesanan dibatalkan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($cancelledOrders->hasPages())
                        <div class="p-4 border-t border-slate-200 bg-slate-50">
                            {{ $cancelledOrders->appends(['tab' => 'cancelled'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        // Only keep window functions that might be used elsewhere or if needed for button actions
        // But since we are removing local polling, we don't need much here unless for specific page actions.
        
        function refreshOrders() {
             window.location.reload();
        }
    </script>

@endsection


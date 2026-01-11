@extends('customer.layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Keranjang Belanja
            </h1>
            <p class="text-gray-500 mt-2">Kelola item di keranjang belanja Anda</p>
        </div>

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
            {{ session('error') }}
        </div>
        @endif

        @if($cartItems->isEmpty())
        <!-- Empty Cart State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Belum ada item di keranjang belanja Anda</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari Obat
            </a>
        </div>
        @else
        <!-- Cart Items -->
        <div class="space-y-4" x-data="cartPage()">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center cart-item" data-cart-id="{{ $item->id }}" data-price="{{ $item->medicine->price }}">
                <!-- Product Image -->
                <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                    @if($item->medicine->image)
                    <img src="{{ asset('storage/' . $item->medicine->image) }}" alt="{{ $item->medicine->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $item->medicine->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $item->medicine->category ?? 'Obat' }}</p>
                    <p class="text-blue-600 font-bold mt-1">Rp {{ number_format($item->medicine->price, 0, ',', '.') }}</p>
                </div>

                <!-- Quantity Controls -->
                <div class="flex items-center gap-3">
                    <button 
                        @click="decreaseQty($el.closest('.cart-item'))" 
                        class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input 
                        type="number" 
                        min="1" 
                        max="{{ $item->medicine->stock }}"
                        value="{{ $item->quantity }}" 
                        class="w-16 text-center border-2 border-gray-200 rounded-xl py-2 focus:border-blue-500 focus:outline-none item-quantity"
                        @change="updateQty($el.closest('.cart-item'), $el.value)">
                    <button 
                        @click="increaseQty($el.closest('.cart-item'), {{ $item->medicine->stock }})" 
                        class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>

                <!-- Item Subtotal -->
                <div class="text-right item-subtotal-container">
                    <p class="text-sm text-gray-500">Subtotal</p>
                    <p class="text-lg font-bold text-gray-900 item-subtotal">Rp {{ number_format($item->medicine->price * $item->quantity, 0, ',', '.') }}</p>
                </div>

                <!-- Remove Button -->
                <button 
                    @click="removeItem({{ $item->id }})" 
                    class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            @endforeach

            <!-- Summary Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mt-8">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-blue-100">Subtotal</span>
                    <span class="text-xl font-bold cart-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-white/20 pt-4 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home') }}" class="flex-1 py-3 px-6 bg-white/20 hover:bg-white/30 rounded-xl font-semibold text-center transition-colors">
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('customer.checkout.index') }}" class="flex-1 py-3 px-6 bg-white text-blue-600 hover:bg-blue-50 rounded-xl font-bold text-center transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                        Checkout
                    </a>
                </div>
            </div>
        </div>

        <script>
            function cartPage() {
                return {
                    updateQty(itemEl, newQty) {
                        const cartId = itemEl.dataset.cartId;
                        const price = parseInt(itemEl.dataset.price);
                        
                        fetch('{{ route("customer.cart.update") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ cart_id: cartId, quantity: parseInt(newQty) })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                itemEl.querySelector('.item-subtotal').textContent = 'Rp ' + this.formatNumber(data.itemSubtotal);
                                document.querySelector('.cart-subtotal').textContent = 'Rp ' + this.formatNumber(data.subtotal);
                            } else {
                                alert(data.message);
                            }
                        });
                    },
                    decreaseQty(itemEl) {
                        const input = itemEl.querySelector('.item-quantity');
                        if (parseInt(input.value) > 1) {
                            input.value = parseInt(input.value) - 1;
                            this.updateQty(itemEl, input.value);
                        }
                    },
                    increaseQty(itemEl, maxStock) {
                        const input = itemEl.querySelector('.item-quantity');
                        if (parseInt(input.value) < maxStock) {
                            input.value = parseInt(input.value) + 1;
                            this.updateQty(itemEl, input.value);
                        }
                    },
                    removeItem(cartId) {
                        if (!confirm('Hapus item ini dari keranjang?')) return;
                        
                        fetch('{{ route("customer.cart.remove") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ cart_id: cartId })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        });
                    },
                    formatNumber(num) {
                        return new Intl.NumberFormat('id-ID').format(num);
                    }
                }
            }
        </script>
        @endif
    </div>
</div>
@endsection

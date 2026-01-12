@extends('cashier.layouts.app', ['activeMenu' => 'pos'])

@section('title', 'Point of Sale - ePharma POS')

@section('bodyAttributes')
x-data="cashierApp"
@endsection

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endpush

@section('content')
    <!-- Main Content Layout -->
    <div class="flex flex-1 overflow-hidden h-full">
        <!-- Left Column: Product Catalog -->
        <div class="flex-1 flex flex-col min-w-0 min-h-0 bg-background-light relative h-full">
            <!-- Search & Filters Header -->
            <div class="p-6 pb-2 flex flex-col gap-4">
                <!-- Search Bar -->
                <div class="w-full">
                    <label class="flex flex-col w-full h-12">
                        <div
                            class="flex w-full flex-1 items-stretch rounded-full h-full bg-white shadow-sm overflow-hidden border border-slate-200 focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600 transition-all">
                            <div class="text-slate-500 flex items-center justify-center pl-4 pr-2">
                                <span class="material-symbols-outlined">search</span>
                            </div>
                            <input x-model="search"
                                class="flex w-full min-w-0 flex-1 resize-none overflow-hidden bg-transparent text-slate-900 focus:outline-0 border-none h-full placeholder:text-slate-400 px-2 text-base font-normal leading-normal"
                                placeholder="Scan barcode atau cari obat (Nama)..." />
                        </div>
                    </label>
                </div>

                <!-- Categories -->
                <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2">
                    <button @click="category = 'all'"
                        class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-lg pl-3 pr-4 transition-all"
                        :class="category === 'all' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-white border border-slate-200 text-slate-900 hover:border-blue-600/50'">
                        <span class="material-symbols-outlined text-[20px]">pill</span>
                        <p class="text-sm font-bold leading-normal">Semua Item</p>
                    </button>

                    @foreach ($existingCategories as $cat)
                        <button @click="category = '{{ $cat }}'"
                            class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-lg pl-3 pr-4 transition-all"
                            :class="category === '{{ $cat }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'bg-white border border-slate-200 text-slate-900 hover:border-blue-600/50'">
                            <p class="text-sm font-medium leading-normal capitalize">{{ $cat }}</p>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto p-6 pt-2">
                <!-- Search Loading Indicator -->
                <div x-show="isSearching" class="flex flex-col items-center justify-center h-64 text-slate-400" x-cloak>
                    <svg class="animate-spin w-10 h-10 mb-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <p>Mencari obat...</p>
                </div>

                <!-- Empty State -->
                <div x-show="!isSearching && filteredMedicines.length === 0"
                    class="flex flex-col items-center justify-center h-64 text-slate-400" x-cloak>
                    <span class="material-symbols-outlined text-6xl mb-2">sentiment_dissatisfied</span>
                    <p>Tidak ada obat ditemukan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-4"
                    x-show="!isSearching && filteredMedicines.length > 0">
                    <template x-for="medicine in filteredMedicines" :key="medicine.id">
                        <div @click="addToCart(medicine)"
                            x-data="{ infoHover: false }"
                            class="group flex flex-col bg-white rounded-xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-primary/30 transition-all cursor-pointer h-full relative overflow-hidden"
                            :class="{'ring-2 ring-primary ring-offset-2': cart[medicine.id]}">

                            <div
                                class="relative h-40 w-full rounded-t-xl overflow-hidden bg-slate-100">
                                <!-- Badge -->
                                <div class="absolute top-2 left-2 px-2 py-1 rounded-md uppercase tracking-wider text-[10px] font-bold z-10"
                                    :class="medicine.stock > 10 ? 'bg-emerald-100 text-emerald-800' : (medicine.stock > 0 ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')">
                                    <span
                                        x-text="medicine.stock > 0 ? (medicine.stock > 5 ? 'Tersedia' : 'Stok Menipis') : 'Habis'"></span>
                                </div>

                                <!-- Selected Overlay -->
                                <div x-show="cart[medicine.id]"
                                    class="absolute inset-0 bg-primary/20 flex items-center justify-center z-10 transition-opacity">
                                    <div class="bg-blue-500/50 backdrop-brightness-70 backdrop-blur-[2px] text-white rounded-full p-2 shadow-lg animate-slide-up">
                                        <span class="material-symbols-outlined">check</span>
                                    </div>
                                </div>

                                <!-- Image -->
                                <template x-if="medicine.image">
                                    <div class="w-full h-full bg-center bg-cover bg-no-repeat transition-transform duration-500 group-hover:scale-110"
                                        :style="`background-image: url('/storage/${medicine.image}');`"></div>
                                </template>
                                <template x-if="!medicine.image">
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-slate-200">
                                        <span
                                            class="material-symbols-outlined text-4xl text-slate-400">medication</span>
                                    </div>
                                </template>

                                <!-- Info Button -->
                                <button @click.stop="viewDetail(medicine)" 
                                    @mouseenter="infoHover = true"
                                    @mouseleave="infoHover = false"
                                    class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center shadow-lg backdrop-blur-sm transition-all z-20">
                                    <span class="material-symbols-outlined text-[18px]">info</span>
                                </button>
                            </div>

                            <div class="p-4 flex flex-col flex-1 gap-2">
                                <div>
                                    <h3 class="text-slate-900 text-base font-bold leading-tight line-clamp-1"
                                        x-text="medicine.name"></h3>
                                    <p class="text-slate-500 text-xs mt-1">
                                        <span class="capitalize" x-text="medicine.category"></span> • <span
                                            x-text="medicine.stock + ' unit'"></span>
                                    </p>
                                </div>
                                <div class="mt-auto flex items-center justify-between pt-2">
                                    <span class="text-primary text-lg font-bold"
                                        x-text="'Rp ' + formatPrice(medicine.price)"></span>

                                    <!-- Add Button or Qty Control if in cart -->
                                    <button
                                       :class="{ 'group-hover:bg-blue-600 group-hover:text-white': !infoHover }"
                                       class="size-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg transition-colors duration-300">
                                        <span class="material-symbols-outlined text-[20px]">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Infinite Scroll Sentinel -->
                <div x-intersect.margin.200px="loadMore()" class="h-10 mt-6 flex justify-center w-full" 
                     x-show="hasMore && !search && !isSearching">
                    <template x-if="loadingMore">
                        <svg class="animate-spin w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </template>
                </div>

                <!-- Load More Indicator -->
                <div x-show="!hasMore && medicines.length > 20" class="mt-6 text-center text-slate-400 text-sm">
                    <span x-text="`Menampilkan semua ${medicines.length} obat`"></span>
                </div>
            </div>
        </div>

        <!-- Right Column: Transaction Cart -->
        <aside
            class="w-[400px] flex-shrink-0 bg-white border-l border-slate-200 flex flex-col shadow-2xl shadow-slate-200 z-10">
            <!-- Customer Selection -->
            <div class="p-4 border-b border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-slate-900">Pesanan Saat Ini</h3>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-3">
                <template x-for="item in cartItems" :key="item.id">
                    <div
                        class="flex gap-3 items-start p-3 rounded-xl hover:bg-slate-50 transition-colors group border border-transparent hover:border-slate-200">
                        <!-- Item Image -->
                        <div class="size-16 rounded-lg bg-slate-100 bg-center bg-cover flex-shrink-0 border border-slate-200"
                            :style="item.image ? `background-image: url('/storage/${item.image}')` : ''">
                            <div x-show="!item.image"
                                class="w-full h-full flex items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined">medication</span>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 flex flex-col justify-between h-16">
                            <div class="flex justify-between items-start">
                                <div class="pr-2">
                                    <h4 class="text-sm font-bold text-slate-900 truncate"
                                        x-text="item.name"></h4>
                                    <p class="text-xs text-slate-500"
                                        x-text="'Rp ' + formatPrice(item.price) + ' / unit'"></p>
                                </div>
                                <button @click="removeFromCart(item.id)"
                                    class="text-slate-300 hover:text-red-500 transition-colors" title="Remove">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                            <div class="flex justify-between items-end mt-auto">
                                <div class="flex items-center gap-2 bg-slate-100 rounded-lg p-0.5">
                                    <button @click="updateQty(item.id, -1)"
                                        class="size-5 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">remove</span>
                                    </button>
                                    <span class="text-xs font-bold w-4 text-center" x-text="item.quantity"></span>
                                    <button @click="updateQty(item.id, 1)"
                                        class="size-5 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">add</span>
                                    </button>
                                </div>
                                <span class="text-sm font-bold text-slate-900"
                                    x-text="'Rp ' + formatPrice(item.subtotal)"></span>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="cartCount === 0" class="flex flex-col items-center justify-center h-full text-slate-400"
                    x-cloak>
                    <span class="material-symbols-outlined text-4xl mb-2">shopping_basket</span>
                    <p class="text-sm">Keranjang kosong</p>
                </div>
            </div>

            <!-- Summary & Actions -->
            <div class="p-5 border-t border-slate-200 bg-slate-50">
                <!-- Calculations -->
                <div class="space-y-3 mb-6">
                    <!-- Total Box -->
                    <div class="flex justify-between items-center p-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/20">
                        <span class="font-medium text-white/90">Total Bayar</span>
                        <span class="text-lg font-bold tracking-tight" x-text="'Rp ' + formatPrice(total)"></span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button @click="clearCart()"
                        class="flex-1 flex items-center justify-center h-12 rounded-xl bg-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-300 transition-colors">
                        Reset
                    </button>
                    <button @click="prepareCheckout()" :disabled="cartCount === 0"
                        class="flex-[3] flex items-center justify-center gap-2 h-12 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base shadow-lg shadow-blue-600/25 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                        <span>Bayar</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </aside>
    </div>

    <!-- Payment Modal -->
    <div x-show="showPaymentModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50"
        :class="{'hidden': !showPaymentModal, 'flex': showPaymentModal}" x-cloak>
        <div @click.away="showPaymentModal = false"
            class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-slide-up">

            <div class="bg-blue-600 p-6 text-white text-center">
                <span class="material-symbols-outlined text-5xl mb-2">receipt_long</span>
                <h3 class="text-xl font-bold">Konfirmasi Pembayaran</h3>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Faktur</span>
                    <span class="font-bold" x-text="invoiceNumber"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Tanggal</span>
                    <span class="font-bold" x-text="todayDate"></span>
                </div>
                <div class="flex justify-between py-4">
                    <span class="text-lg font-bold text-slate-700">Total Tagihan</span>
                    <span class="text-2xl font-bold text-blue-600" x-text="'Rp ' + formatPrice(total)"></span>
                </div>

                <form action="{{ route('cashier.transaction.processPayment') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="invoice_number" :value="invoiceNumber">
                    <input type="hidden" name="total_amount" :value="total">
                    <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                    <input type="hidden" name="cash_received" :value="cashReceived">

                    <!-- Cash Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Uang Tunai Diterima</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                            <input type="text" x-model="cashReceivedInput" @input="parseCashInput($event.target.value)"
                                class="w-full h-12 pl-12 pr-4 text-right text-xl font-bold border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0">
                        </div>
                    </div>

                    <!-- Change Display -->
                    <div class="flex justify-between items-center p-4 rounded-xl" :class="change >= 0 ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'">
                        <span class="font-medium" :class="change >= 0 ? 'text-green-700' : 'text-red-700'">Kembalian</span>
                        <span class="text-xl font-bold" :class="change >= 0 ? 'text-green-600' : 'text-red-600'" x-text="'Rp ' + formatPrice(Math.abs(change))"></span>
                    </div>

                    <button type="submit" :disabled="cashReceived < total || cartCount === 0"
                        class="w-full h-12 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Konfirmasi & Cetak
                    </button>
                    <button type="button" @click="showPaymentModal = false; cashReceived = 0; cashReceivedInput = '';"
                        class="w-full h-12 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Detail Modal -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 overflow-hidden" x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="showDetailModal" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-slate-900/75 bg-opacity-75 transition-opacity" @click="showDetailModal = false"></div>

            <div x-show="showDetailModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-5xl flex flex-col max-h-[90vh] text-left transition-all transform bg-white shadow-xl rounded-2xl overflow-hidden mt-12">
                
                <!-- Fixed Header -->
                <div class="bg-blue-600 p-4 flex items-center justify-between flex-shrink-0 rounded-t-2xl">
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">medication</span>
                        Detail Obat
                    </h3>
                    <button @click="showDetailModal = false" class="text-white/70 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <template x-if="selectedMedicine">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column: Image & Basic Info -->
                            <div class="space-y-6">
                                <div class="aspect-square bg-white rounded-2xl border border-slate-100 p-4 flex items-center justify-center relative overflow-hidden shadow-sm">
                                    <template x-if="selectedMedicine.image">
                                        <img :src="'/storage/' + selectedMedicine.image" class="w-full h-full object-contain">
                                    </template>
                                    <template x-if="!selectedMedicine.image">
                                        <span class="material-symbols-outlined text-6xl text-slate-200">medication</span>
                                    </template>
                                </div>

                                <div class="text-center">
                                    <h2 class="text-2xl font-bold text-slate-900 mb-2" x-text="selectedMedicine.name"></h2>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold uppercase tracking-wider" x-text="selectedMedicine.category"></span>
                                </div>

                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-3">
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                                        <span class="text-slate-500 font-medium flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            Harga
                                        </span>
                                        <span class="font-bold text-slate-900 text-lg" x-text="'Rp ' + formatPrice(selectedMedicine.price)"></span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                                        <span class="text-slate-500 font-medium flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">inventory_2</span>
                                            Stok
                                        </span>
                                        <span class="font-bold text-slate-900" x-text="selectedMedicine.stock + ' Unit'"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500 font-medium flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">shopping_bag</span>
                                            Terjual
                                        </span>
                                        <span class="font-bold text-purple-600" x-text="selectedMedicine.total_sold + ' Unit'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Details -->
                            <div class="lg:col-span-2 space-y-4">
                                
                                <!-- Description -->
                                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                    <h4 class="flex items-center gap-2 font-bold text-slate-900 mb-3">
                                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">info</span>
                                        </span>
                                        Deskripsi
                                    </h4>
                                    <p class="text-slate-600 text-sm leading-relaxed" x-text="selectedMedicine.description || '-'"></p>
                                </div>

                                <!-- Indications -->
                                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                    <h4 class="flex items-center gap-2 font-bold text-slate-900 mb-3">
                                        <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                        </span>
                                        Indikasi & Manfaat
                                    </h4>
                                    <p class="text-slate-600 text-sm leading-relaxed" x-text="selectedMedicine.full_indication || '-'"></p>
                                </div>

                                <!-- Usage & Dosage -->
                                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                    <h4 class="flex items-center gap-2 font-bold text-slate-900 mb-3">
                                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">medical_services</span>
                                        </span>
                                        Penggunaan & Dosis
                                    </h4>
                                    <p class="text-slate-600 text-sm leading-relaxed" x-text="selectedMedicine.usage_detail || '-'"></p>
                                </div>

                                <!-- Side Effects -->
                                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                                    <h4 class="flex items-center gap-2 font-bold text-slate-900 mb-3">
                                        <span class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">warning</span>
                                        </span>
                                        Efek Samping
                                    </h4>
                                    <p class="text-slate-600 text-sm leading-relaxed" x-text="selectedMedicine.side_effects || '-'"></p>
                                </div>

                            </div>
                        </div>
                    </template>
                </div>

                <!-- Fixed Footer -->
                <div class="p-6 border-t border-slate-100 bg-white flex justify-end flex-shrink-0 rounded-b-2xl">
                    <template x-if="selectedMedicine">
                        <button @click="addToCart(selectedMedicine); showDetailModal = false" 
                            :disabled="selectedMedicine.stock <= 0"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="material-symbols-outlined">add_shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                    </template>
                </div>
            </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cashierApp', () => ({
                medicines: @json($initialMedicines),
                cart: {},
                search: '',
                category: 'all',
                showPaymentModal: false,
                invoiceNumber: '',
                todayDate: '',
                cashReceived: 0,
                cashReceivedInput: '',
                // Pagination state
                currentPage: 1,
                hasMore: @json($hasMoreMedicines),
                loadingMore: false,
                // Search state
                isSearching: false,
                searchResults: null,
                // Detail Modal state
                showDetailModal: false,
                selectedMedicine: null,



                init() {
                    // Initialize cart from localStorage or Session
                    const sessionSuccess = @json(session('success') ? true : false);
                    if (sessionSuccess) {
                        localStorage.removeItem('pos_cart');
                        this.cart = {};
                    } else {
                        const storedCart = localStorage.getItem('pos_cart');
                        if (storedCart) {
                            try { this.cart = JSON.parse(storedCart); } catch (e) { this.cart = {}; }
                        } else {
                            const sessionCart = @json(session('cart', []));
                            if (Object.keys(sessionCart).length > 0) this.cart = sessionCart;
                        }
                    }

                    this.$watch('cart', (val) => {
                        localStorage.setItem('pos_cart', JSON.stringify(val));
                    });

                    // Watch category for server-side filtering
                    this.$watch('category', (val) => {
                        // Jika ada search aktif, re-search dengan kategori baru
                        if (this.search.length >= 2) {
                            this.searchFromServer(this.search);
                        } else {
                            // Kalau tidak ada search, fetch medicines by category
                            this.fetchByCategory(val);
                        }
                    });

                    // Watch search input with debounce for server-side search
                    let searchTimeout = null;
                    this.$watch('search', (val) => {
                        clearTimeout(searchTimeout);
                        if (val.length >= 2) {
                            searchTimeout = setTimeout(() => {
                                this.searchFromServer(val);
                            }, 300);
                        } else {
                            // Reset search results when search is cleared or less than 2 chars
                            this.searchResults = null;
                            if (val.length === 0) {
                                // Fetch current category instead of resetting to 'all'
                                this.fetchByCategory(this.category);
                            }
                        }
                    });
                },

                async searchFromServer(searchTerm) {
                    this.isSearching = true;
                    try {
                        const response = await fetch(`{{ route('cashier.transaction.index') }}?search=${encodeURIComponent(searchTerm)}&category=${encodeURIComponent(this.category)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await response.json();
                        
                        // Replace medicines with search results
                        this.searchResults = data.medicines;
                        this.hasMore = false; // Disable load more during search
                    } catch (error) {
                        console.error('Search failed:', error);
                    } finally {
                        this.isSearching = false;
                    }
                },



                async fetchByCategory(category) {
                    this.isSearching = true;
                    this.currentPage = 1;
                    this.searchResults = null; // Reset search results
                    
                    try {
                        const response = await fetch(`{{ route('cashier.transaction.index') }}?page=1&category=${encodeURIComponent(category)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await response.json();
                        
                        this.medicines = data.medicines;
                        this.hasMore = data.hasMore;
                        this.currentPage = 1;
                    } catch (error) {
                        console.error('Category filter failed:', error);
                    } finally {
                        this.isSearching = false;
                    }
                },

                async resetToInitial() {
                    this.category = 'all'; // Reset category too
                    // logic is same as fetching all
                    this.fetchByCategory('all');
                },

                async loadMore() {
                    if (this.loadingMore || !this.hasMore) return;
                    
                    this.loadingMore = true;
                    try {
                        const response = await fetch(`{{ route('cashier.transaction.index') }}?page=${this.currentPage + 1}&category=${encodeURIComponent(this.category)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await response.json();
                        
                        // Append new medicines
                        this.medicines = [...this.medicines, ...data.medicines];
                        this.hasMore = data.hasMore;
                        this.currentPage = data.nextPage - 1;
                    } catch (error) {
                        console.error('Failed to load more medicines:', error);
                    } finally {
                        this.loadingMore = false;
                    }
                },

                get filteredMedicines() {
                    // Update: Client side filtering is removed in favor of Server Side
                    // If we have search results from server, use those
                    if (this.searchResults !== null) {
                        return this.searchResults;
                    }
                    
                    return this.medicines;
                },

                get cartItems() {
                    return Object.values(this.cart);
                },

                get cartCount() {
                    return this.cartItems.length;
                },

                get subtotal() {
                    return this.cartItems.reduce((sum, item) => sum + item.subtotal, 0);
                },

                get total() {
                    return this.subtotal;
                },

                get change() {
                    return this.cashReceived - this.total;
                },

                parseCashInput(value) {
                    const numericValue = value.replace(/[^0-9]/g, '');
                    this.cashReceived = parseInt(numericValue) || 0;
                    this.cashReceivedInput = this.formatPrice(this.cashReceived);
                },

                addToCart(medicine) {
                    if (medicine.stock <= 0) return;

                    if (this.cart[medicine.id]) {
                        if (this.cart[medicine.id].quantity + 1 <= medicine.stock) {
                            this.cart[medicine.id].quantity++;
                            this.cart[medicine.id].subtotal = this.cart[medicine.id].price * this.cart[medicine.id].quantity;
                        }
                    } else {
                        this.cart[medicine.id] = {
                            id: medicine.id,
                            name: medicine.name,
                            price: medicine.price,
                            quantity: 1,
                            subtotal: medicine.price,
                            image: medicine.image // Add image to cart item
                        };
                    }
                },

                updateQty(id, change) {
                    if (!this.cart[id]) return;

                    const medicine = this.medicines.find(m => m.id === id);
                    const newQty = this.cart[id].quantity + change;

                    if (newQty <= 0) {
                        this.removeFromCart(id);
                        return;
                    }

                    if (medicine && newQty > medicine.stock) return; // Prevent exceeding stock

                    this.cart[id].quantity = newQty;
                    this.cart[id].subtotal = this.cart[id].price * newQty;
                },

                removeFromCart(id) {
                    delete this.cart[id];
                },

                clearCart() {
                    if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                        this.cart = {};
                    }
                },

                generateInvoiceNumber() {
                    // Determine invoice number (just visualization)
                    // In real app, maybe bind to sticky value
                    return "INV-" + new Date().getTime().toString().slice(-6);
                },

                prepareCheckout() {
                    if (this.cartCount === 0) return;

                    const today = new Date();
                    const dateStr = today.getFullYear().toString() +
                        (today.getMonth() + 1).toString().padStart(2, '0') +
                        today.getDate().toString().padStart(2, '0');
                    const uniqueCode = today.getTime().toString().slice(-5);

                    this.invoiceNumber = 'INV-' + dateStr + '-' + uniqueCode;
                    this.todayDate = today.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

                    this.showPaymentModal = true;
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                },

                viewDetail(medicine) {
                    this.selectedMedicine = medicine;
                    this.showDetailModal = true;
                }
            }));
        });
    </script>
@endpush
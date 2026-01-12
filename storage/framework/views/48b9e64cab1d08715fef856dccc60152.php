<?php echo $__env->make('components.cart.confirmDelete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div x-show="showCart"
    x-transition:enter="transition ease-out duration-250"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-250"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[70] flex justify-end items-stretch"
    style="background-color: rgba(15, 23, 42, 0.3);"
    x-cloak>

    
    <div class="absolute inset-0" @click="showCart = false"></div>

    
    <div
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="relative w-full max-w-md bg-white shadow-2xl h-full flex flex-col border-l border-gray-200 z-10">

        
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 p-6 flex-shrink-0">
            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-indigo-500/30 blur-xl"></div>

            <div class="relative z-10 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20  rounded-2xl flex items-center justify-center shadow-lg border border-white/10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">Keranjang</h2>
                        <p class="text-blue-100 text-sm font-medium flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <span x-text="displayCart.length + ' Item ditambahkan'"></span>
                        </p>
                    </div>
                </div>
                <button @click="showCart = false" class="group p-2 rounded-xl hover:bg-white/20 transition-all duration-300">
                    <svg class="w-6 h-6 text-white group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 scroll-smooth">
            <template x-if="displayCart.length > 0">
                <ul class="space-y-4 pb-20">
                    <template x-for="(item, index) in displayCart" :key="item.id">
                        <li class="group bg-white rounded-3xl p-4 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            :style="`transition-delay: ${index * 50}ms`">

                            <!-- Left Border Accent -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-blue-400 to-indigo-600 rounded-l-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                            <div class="flex gap-4">
                                <!-- Image Placeholder / Icon -->
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center flex-shrink-0 border border-gray-50 group-hover:scale-105 transition-transform duration-500">
                                    <template x-if="item.image">
                                        <img :src="'/storage/' + item.image" class="w-full h-full object-cover rounded-2xl">
                                    </template>
                                    <template x-if="!item.image">
                                        <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </template>
                                </div>

                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-1" x-text="item.name"></h3>
                                        <p class="text-xs text-gray-500 mt-1">Harga Satuan: Rp <span x-text="new Intl.NumberFormat('id-ID').format(item.price)"></span></p>
                                    </div>

                                    <div class="flex justify-between items-end mt-2">
                                        <!-- Qty Control -->
                                        <div class="flex items-center bg-gray-100 rounded-xl p-1 shadow-inner">
                                            <button @click="updateQty(item.id, -1)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white shadow-sm text-gray-600 hover:text-red-500 hover:bg-red-50 transition-all active:scale-90">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" x-model="item.qty" class="w-8 text-center bg-transparent text-sm font-bold text-gray-800 appearance-none border-none p-0 focus:ring-0" readonly>
                                            <button @click="updateQty(item.id, 1)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white shadow-sm text-gray-600 hover:text-green-500 hover:bg-green-50 transition-all active:scale-90">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Subtotal -->
                                        <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(item.price * item.qty)"></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </template>

            
            <template x-if="displayCart.length === 0">
                <div class="h-full flex flex-col items-center justify-center text-center opacity-0 animate-scale-in">
                    <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center mb-6 animate-float">
                        <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Keranjang Kosong</h3>
                    <p class="text-gray-500 mt-2 max-w-xs mx-auto">Sepertinya Anda belum memilih obat apapun. Yuk, cari obat yang Anda butuhkan!</p>
                    <button @click="showCart = false; document.getElementById('katalog').scrollIntoView({behavior: 'smooth'})"
                        class="mt-8 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/30 hover:scale-105 transition-transform">
                        Belanja Sekarang
                    </button>
                </div>
            </template>
        </div>

        
        <template x-if="displayCart.length > 0">
            <div class="p-6 bg-white border-t border-gray-100 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] relative z-20">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-500 font-medium">Total Pembayaran</span>
                    <span class="text-2xl font-black text-gray-900" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(cartTotal)"></span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button @click="confirmClear()"
                        class="py-4 bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-500 font-bold rounded-2xl transition-colors duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->isCustomer()): ?>
                            <a href="<?php echo e(route('customer.checkout.index')); ?>"
                                class="relative overflow-hidden py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/30 flex items-center justify-center gap-2 group hover:scale-[1.02] transition-transform duration-300">
                                
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                Checkout
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        <?php elseif(Auth::user()->isCashier() || Auth::user()->isAdmin()): ?>
                            
                            <div class="py-4 bg-gray-200 text-gray-500 font-medium rounded-2xl flex items-center justify-center gap-2 cursor-not-allowed text-sm text-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m9.364-5.364l-1.414 1.414M12 4v2m6.364 10.364l-1.414-1.414M20 12h-2M4 12H2m5.636 5.636l-1.414 1.414M5.636 5.636l1.414 1.414"></path>
                                </svg>
                                Checkout tidak tersedia untuk staff
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                            class="relative overflow-hidden py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/30 flex items-center justify-center gap-2 group hover:scale-[1.02] transition-transform duration-300">
                            
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            Login untuk Checkout
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </template>
    </div>
</div><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/components/cart/cartModal.blade.php ENDPATH**/ ?>
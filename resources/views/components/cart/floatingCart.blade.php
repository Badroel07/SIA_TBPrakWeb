{{-- FLOATING CART MODERN --}}
<div class="fixed bottom-10 right-10 z-[60]" x-data="{ 
        showFloating: false,
        observer: null,
        init() {
            const katalogEl = document.getElementById('katalog');
            if (!katalogEl) {
                this.showFloating = true;
                return;
            };
            
            // IntersectionObserver: lebih efisien dari scroll listener
            // threshold: 0 = trigger saat bagian apapun dari elemen visible
            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        this.showFloating = entry.isIntersecting;
                    });
                },
                { 
                    root: null, // viewport sebagai root
                    rootMargin: '0px',
                    threshold: 0 // trigger segera saat mulai visible
                }
            );
            
            this.observer.observe(katalogEl);
        },
        destroy() {
            if (this.observer) {
                this.observer.disconnect();
            }
        }
    }" x-init="init()" @beforeunmount.window="destroy()" x-cloak x-show="isCustomer && showFloating"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-10">
    <div class="relative group">
        <!-- Pulse Ring -->
        <div class="absolute inset-0 rounded-full bg-blue-500 opacity-20 group-hover:animate-ping"></div>

        <button @click="showCart = true"
            class="relative w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full shadow-2xl shadow-blue-500/40 flex items-center justify-center transform transition-all duration-300 hover:scale-110 hover:rotate-12 group-hover:shadow-blue-500/60 text-white z-10">

            <!-- Icon -->
            <svg class="w-7 h-7 transform transition-transform duration-300 group-hover:-rotate-12" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>

            <!-- Badge -->
            <span x-text="cartTotalQty"
                class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full border-2 border-white shadow-sm transform transition-transform duration-300 scale-100 group-hover:scale-110"
                :class="{'scale-0': cartTotalQty === 0}">
            </span>
        </button>

        <!-- Tooltip Label -->
        <span
            class="absolute right-full top-1/2 -translate-y-1/2 mr-4 px-3 py-1 bg-white text-gray-700 text-sm font-bold rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
            Keranjang
        </span>
    </div>
</div>
{{-- MODAL KONFIRMASI KOSONGKAN KERANJANG - Ultra Modern --}}
<div x-show="showConfirmClear"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-900/60  z-[80] flex items-center justify-center p-4"
    x-cloak>

    <div @click.outside="showConfirmClear = false"
        class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden transform transition-all"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100">

        {{-- Icon Header --}}
        <div class="bg-gradient-to-r from-red-500 to-rose-600 p-6 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Kosongkan Keranjang?</h3>
            <p class="text-gray-500 mb-6">Semua item di keranjang akan dihapus. Aksi ini tidak dapat dibatalkan.</p>

            <div class="flex gap-3">
                <button @click="showConfirmClear = false"
                    class="flex-1 px-4 py-3 text-gray-700 font-bold bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-300">
                    Batal
                </button>
                <button @click="clearCartConfirmed()"
                    class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
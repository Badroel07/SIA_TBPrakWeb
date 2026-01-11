{{-- Modal Pembayaran - Ultra Modern --}}
<div id="payment-modal" class="fixed inset-0 bg-gray-900/70  z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <style>
        @keyframes modalSlideUp {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .payment-modal-animate {
            animation: modalSlideUp 0.4s ease-out forwards;
        }
    </style>

    <div class="flex items-center justify-center min-h-screen p-4">
        {{-- Modal Content --}}
        <div class="payment-modal-animate bg-white rounded-3xl overflow-hidden shadow-2xl w-full max-w-lg">

            {{-- Header dengan Gradient --}}
            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-8 w-16 h-16 bg-white/10 rounded-full translate-y-1/2"></div>

                <div class="flex justify-between items-center relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20  rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-credit-card text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white" id="modal-title">Pembayaran</h3>
                            <p class="text-green-100 text-sm" id="invoice-number-display">{{ $invoiceNumber }}</p>
                        </div>
                    </div>
                    <button onclick="closePaymentModal()" class="w-10 h-10 bg-white/20 hover:bg-white/30  rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:rotate-90">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6" id="payment-form">

                {{-- Item List --}}
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <i class="fas fa-list text-gray-400"></i> Ringkasan Item
                    </h4>
                    <div class="space-y-2 max-h-40 overflow-y-auto bg-gray-50 rounded-2xl p-4">
                        @foreach ($cartItems as $item)
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-pills text-green-600 text-xs"></i>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $item['name'] }} <span class="text-gray-400">({{ $item['quantity'] }}x)</span></span>
                            </div>
                            <span class="font-bold text-gray-800">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total Display --}}
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200 mb-6">
                    <span class="text-gray-700 font-bold">TOTAL AKHIR</span>
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Payment Form --}}
                <form action="{{ route('cashier.transaction.complete') }}" method="POST" id="complete-transaction-form">
                    @csrf
                    <input type="hidden" name="cart_items" value="{{ json_encode($cartItems) }}">
                    <input type="hidden" name="total_amount" value="{{ $total }}">
                    <input type="hidden" name="invoice_number" value="{{ $invoiceNumber }}">
                    <input type="hidden" name="amount_paid" id="hidden_amount_paid">

                    {{-- Amount Paid Input --}}
                    <div class="mb-4">
                        <label for="amount_paid" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave text-green-500"></i> Uang Bayar
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                            <input type="number" id="amount_paid" name="amount_paid_display"
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 rounded-2xl border-2 border-gray-200 text-2xl font-bold text-center focus:border-green-500 focus:ring-4 focus:ring-green-500/20 focus:outline-none transition-all"
                                placeholder="0" required min="{{ $total }}">
                        </div>
                    </div>

                    {{-- Change Display --}}
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 mb-6">
                        <span class="text-gray-700 font-bold flex items-center gap-2">
                            <i class="fas fa-exchange-alt text-blue-500"></i> Kembalian
                        </span>
                        <span id="change-display" class="text-2xl font-extrabold text-blue-600">Rp 0</span>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="confirm-payment-button" disabled
                        class="w-full py-4 rounded-2xl text-lg font-bold transition-all duration-300 flex items-center justify-center gap-2
                        disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed
                        enabled:bg-gradient-to-r enabled:from-green-600 enabled:to-emerald-600 enabled:text-white enabled:shadow-lg enabled:shadow-green-500/30 enabled:hover:shadow-green-500/50 enabled:hover:scale-[1.02]">
                        <i class="fas fa-check-circle"></i>
                        KONFIRMASI PEMBAYARAN
                    </button>
                </form>
            </div>

            {{-- Loading State --}}
            <div id="loading-message" class="hidden p-8">
                <div class="flex flex-col items-center justify-center">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 border-4 border-green-200 rounded-full"></div>
                        <div class="w-20 h-20 border-4 border-green-600 rounded-full border-t-transparent animate-spin absolute top-0 left-0"></div>
                    </div>
                    <p class="text-xl font-bold text-gray-800">Memproses Pembayaran...</p>
                    <p class="text-gray-500 text-sm mt-2">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>
    </div>
</div>
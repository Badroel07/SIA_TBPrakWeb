{{-- TOAST NOTIFICATION STACK - Ultra Modern --}}
<div class="fixed bottom-24 left-1/2 transform -translate-x-1/2 z-[100] flex flex-col gap-3 items-center pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
            x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="opacity-0 translate-y-8 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="pointer-events-auto">

            <div class="px-5 py-4 rounded-2xl shadow-2xl text-white font-semibold flex items-center gap-4 min-w-[320px] "
                :class="{
                    'bg-gradient-to-r from-green-500 to-emerald-600 shadow-green-500/30': toast.type === 'success',
                    'bg-gradient-to-r from-red-500 to-rose-600 shadow-red-500/30': toast.type === 'error',
                    'bg-gradient-to-r from-amber-500 to-orange-600 shadow-amber-500/30': toast.type === 'warning',
                    'bg-gradient-to-r from-blue-500 to-indigo-600 shadow-blue-500/30': toast.type === 'info',
                }">

                {{-- Icon Container --}}
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    :class="{
                        'bg-white/20': true
                    }">
                    <template x-if="toast.type === 'success'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'warning'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'info'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                </div>

                {{-- Message --}}
                <span x-text="toast.message" class="flex-1 text-sm"></span>

                {{-- Close Button --}}
                <button @click="removeToast(toast.id)" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>
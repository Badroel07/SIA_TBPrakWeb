<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kasir - ePharma')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Parkinsans:wght@300..800&display=swap"
        rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .font-display { font-family: 'Parkinsans', sans-serif; }
        body { font-family: 'Parkinsans', sans-serif; }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-100 font-sans text-slate-900 h-screen overflow-hidden flex" @yield('bodyAttributes')>

    <!-- Flash Messages handled globally below -->

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white m-4 rounded-3xl shadow-xl flex flex-col shrink-0 relative overflow-hidden">
        
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-xl shadow-blue-200 shadow-lg">
                <span class="material-symbols-outlined text-2xl">local_pharmacy</span>
            </div>
            <div>
                <h1 class="font-display font-bold text-xl leading-none tracking-tight">ePharma</h1>
                <span class="text-xs text-slate-400 font-medium tracking-wider">POS SYSTEM</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-3 overflow-y-auto py-4">
            @php $activeMenu = $activeMenu ?? ''; @endphp

            <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2 font-display">Menu Utama</p>

            <a href="{{ route('cashier.dashboard') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ $activeMenu === 'dashboard' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">grid_view</span>
                <span class="font-bold tracking-wide text-sm">Dashboard</span>
            </a>

            <a href="{{ route('cashier.transaction.index') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ $activeMenu === 'pos' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">point_of_sale</span>
                <span class="font-bold tracking-wide text-sm">Point of Sale</span>
            </a>

            <a href="{{ route('cashier.orders.incoming') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ $activeMenu === 'orders' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:translate-x-1' }}">
                <div class="relative">
                    <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">receipt_long</span>
                    <span data-count-badge="incoming" data-show-zero="false" class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-orange-500 text-white text-[9px] font-bold flex items-center justify-center rounded-full opacity-0 transition-opacity ring-2 ring-white"></span>
                </div>
                <span class="font-bold tracking-wide text-sm">Pesanan</span>
            </a>

            <a href="{{ route('cashier.transaction.history') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ $activeMenu === 'history' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">history_edu</span>
                <span class="font-bold tracking-wide text-sm">Riwayat</span>
            </a>
        </nav>

        <!-- User Profile -->
        <div class="p-4 mt-auto">
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate font-display">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 truncate font-display tracking-wide uppercase">Cashier</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-slate-400 hover:text-red-500 transition-colors" title="Logout">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 m-4 ml-0 bg-white rounded-3xl shadow-xl overflow-hidden relative flex flex-col border border-slate-100/50">
        @yield('content')
    </main>

    @stack('modals')
    @stack('scripts')

    <!-- Flash Messages (Top Right) -->
    <div class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-slide-in-right pointer-events-auto">
                <div class="p-2 bg-white/20 rounded-full">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <h4 class="font-bold font-display text-sm">Berhasil!</h4>
                    <p class="text-xs text-green-100">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="ml-2 opacity-70 hover:opacity-100"><span class="material-symbols-outlined text-sm">close</span></button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 animate-slide-in-right pointer-events-auto">
                <div class="p-2 bg-white/20 rounded-full">
                    <span class="material-symbols-outlined">error</span>
                </div>
                <div>
                    <h4 class="font-bold font-display text-sm">Gagal!</h4>
                    <p class="text-xs text-red-100">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="ml-2 opacity-70 hover:opacity-100"><span class="material-symbols-outlined text-sm">close</span></button>
            </div>
        @endif
    </div>

    <!-- DYNAMIC GLOBAL NOTIFICATION TOAST -->
    <div id="dynamicToast" 
        class="fixed bottom-10 right-10 z-[9999] flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl transition-all duration-500 ease-out border overflow-hidden bg-blue-500 border-blue-400 shadow-blue-500/20 text-white"
        style="transform: translateY(150%); opacity: 0; pointer-events: none;">
        
        <div id="toastIconContainer" class="w-12 h-12 flex items-center justify-center rounded-full shrink-0 bg-white/20 text-white">
            <span id="toastIcon" class="material-symbols-outlined text-2xl animate-bounce">notifications_active</span>
        </div>
        
        <div class="flex-1 min-w-[200px]">
            <p id="toastTitle" class="font-bold text-lg leading-tight mb-0.5 font-display text-white">Notifikasi</p>
            <p id="toastMessage" class="text-sm text-white/90">Pesan notifikasi.</p>
        </div>
        
        <div class="flex gap-2 ml-4">
            <a href="{{ route('cashier.orders.incoming') }}" class="px-4 py-2 bg-white font-bold rounded-xl transition-colors flex items-center gap-1 shadow-lg shadow-black/5" style="pointer-events: auto;">
                <span id="toastBtnText" class="text-slate-900">Lihat</span>
            </a>
            <button onclick="hideToast()" class="p-2 hover:bg-white/10 rounded-xl transition-colors text-white/70 hover:text-white" style="pointer-events: auto;">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>

    <!-- GLOBAL POLLING SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let lastCounts = null; // Will be initialized on first fetch
            let isProcessing = false;

            // Audio Setup
            let audioCtx = null;
            const audioBuffers = {};
            const soundUrls = {
                'new_order': '/sounds/new_order.wav',
                'payment': '/sounds/payment_received.wav',
                'cancel': '/sounds/order_cancelled.wav',
                'default': '/sounds/new_order.wav'
            };

            function initAudio() {
                if (!audioCtx) {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    if (AudioContext) {
                        audioCtx = new AudioContext();
                        preloadSounds();
                    }
                }
                if (audioCtx && audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
            }

            async function preloadSounds() {
                for (const [key, url] of Object.entries(soundUrls)) {
                    try {
                        const response = await fetch(url);
                        if (response.ok) {
                            const arrayBuffer = await response.arrayBuffer();
                            audioBuffers[key] = await audioCtx.decodeAudioData(arrayBuffer);
                        }
                    } catch (e) {
                        console.warn(`Failed to preload ${key} sound.`);
                    }
                }
            }

            // User Interaction to unlock Audio
            const unlockAudio = () => {
                if (!audioCtx) {
                    initAudio();
                }
                if (audioCtx && audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
            };
            
            // Try to unlock on any interaction (persistent)
            document.addEventListener('click', unlockAudio);
            document.addEventListener('keydown', unlockAudio);
            document.addEventListener('touchstart', unlockAudio);

            // Play Sound
            function playNotificationSound(type = 'default') {
                return new Promise(async (resolve) => {
                    // Method 1: Web Audio API (Preferred)
                    try {
                        if (!audioCtx) initAudio();
                        if (audioCtx && audioCtx.state === 'suspended') {
                            await audioCtx.resume();
                            console.log('AudioContext resumed');
                        }

                        const buffer = audioBuffers[type] || audioBuffers['default'];
                        if (buffer && audioCtx) {
                            const source = audioCtx.createBufferSource();
                            source.buffer = buffer;
                            source.connect(audioCtx.destination);
                            source.onended = resolve;
                            source.start(0);
                            console.log(`Playing sound (${type}) via Web Audio API`);
                            return; // Success, exit
                        }
                    } catch (e) {
                        console.warn('Web Audio API failed, trying fallback:', e);
                    }

                    // Method 2: HTML5 Audio Fallback (Robustness)
                    try {
                        const url = soundUrls[type] || soundUrls['default'];
                        const audio = new Audio(url);
                        await audio.play();
                        console.log(`Playing sound (${type}) via HTML5 Audio`);
                        resolve();
                    } catch (e) {
                        console.error('All audio methods failed:', e);
                        resolve();
                    }
                });
            }

            // Notification Logic
            async function handleNotification(type, diff = 0) {
                const toast = document.getElementById('dynamicToast');
                if (!toast) return;

                // Reset Styling
                toast.style.pointerEvents = 'auto';

                // Elements
                const titleEl = toast.querySelector('#toastTitle');
                const msgEl = toast.querySelector('#toastMessage');
                const iconContainer = toast.querySelector('#toastIconContainer');
                const icon = toast.querySelector('#toastIcon');
                
                // Defaults
                let title = 'Notifikasi';
                let msg = 'Ada pembaruan.';
                let colorClass = 'bg-blue-500 border-blue-400 shadow-blue-500/20 text-white';
                let iconName = 'notifications';

                if (type === 'cancel') {
                    title = 'Permintaan Pembatalan!';
                    msg = 'Seorang pelanggan mengajukan <span class="font-bold text-white">pembatalan</span>';
                    colorClass = 'bg-red-500 border-red-400 shadow-red-500/20 text-white';
                    iconName = 'cancel';
                } else if (type === 'payment') {
                    title = 'Pembayaran Masuk!';
                    msg = 'Ada pelanggan yang sudah <span class="font-bold text-white">membayar</span>';
                    colorClass = 'bg-green-500 border-green-400 shadow-green-500/20 text-white';
                    iconName = 'payments';
                } else if (type === 'new_order') {
                    title = 'Pesanan Baru!';
                    msg = `Ada <span class="font-bold text-white">${diff}</span> pesanan baru masuk`;
                    colorClass = 'bg-blue-500 border-blue-400 shadow-blue-500/20 text-white';
                    iconName = 'receipt_long';
                }

                // Apply Content
                titleEl.textContent = title;
                msgEl.innerHTML = msg;
                icon.innerText = iconName;

                // Reset Class List
                toast.className = `fixed bottom-10 right-10 z-[9999] flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl transition-all duration-500 ease-out border overflow-hidden ${colorClass}`;
                
                // Show
                toast.style.transform = 'translateY(0)';
                toast.style.opacity = '1';

                playNotificationSound(type);

                // Auto hide after 5s
                setTimeout(() => {
                    hideToast();
                }, 5000);
            }

            window.hideToast = function() {
                const toast = document.getElementById('dynamicToast');
                if (toast) {
                    toast.style.transform = 'translateY(150%)';
                    toast.style.opacity = '0';
                    toast.style.pointerEvents = 'none';
                }
            };

            // Polling Function
            async function pollOrderCounts() {
                if (isProcessing) return;

                try {
                    const res = await fetch('{{ route("cashier.orders.counts") }}');
                    if (!res.ok) throw new Error('Network response was not ok');
                    
                    const data = await res.json();

                    // Initial Load
                    if (lastCounts === null) {
                        lastCounts = data;
                        updateBadges(data);
                        return;
                    }

                    // Check Differences
                    let notified = false;

                    // 1. Cancel Requests
                    if (data.cancel_requested > lastCounts.cancel_requested) {
                        handleNotification('cancel');
                        notified = true;
                    }
                    // 2. New Orders
                    else if (data.incoming > lastCounts.incoming) {
                        const diff = data.incoming - lastCounts.incoming;
                        handleNotification('new_order', diff);
                        notified = true;
                    }
                    // 3. Payments
                    else if (data.paid_pending > lastCounts.paid_pending) {
                        handleNotification('payment');
                        notified = true;
                    }

                    // If any count changed (even if decreased), update badges and refresh content if on orders page
                    if (JSON.stringify(data) !== JSON.stringify(lastCounts)) {
                        updateBadges(data);
                        
                        // If we are on the orders page, refresh the table content
                        if (window.location.href.includes('/cashier/orders')) {
                             refreshTableContent();
                        }
                    }

                    lastCounts = data;

                } catch (error) {
                    console.error('Polling error:', error);
                } finally {
                    setTimeout(pollOrderCounts, 1000); // Poll every 1 second
                }
            }

            async function refreshTableContent() {
                try {
                    const response = await fetch(window.location.href);
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update Table Bodies
                    const tables = ['incoming', 'shipped', 'completed', 'cancelled'];
                    tables.forEach(type => {
                        const newBody = doc.getElementById(`${type}-table-body`);
                        const currentBody = document.getElementById(`${type}-table-body`);
                        if (newBody && currentBody) {
                            currentBody.innerHTML = newBody.innerHTML;
                        }
                    });
                } catch (e) {
                    console.error('Failed to refresh table content', e);
                }
            }

            function updateBadges(data) {
                const badges = document.querySelectorAll('[data-count-badge]');
                badges.forEach(badge => {
                    const type = badge.dataset.countBadge;
                    if (data[type] !== undefined) {
                        // Check if we should show zero
                        const showZero = badge.dataset.showZero === 'true';
                        
                        if (data[type] > 0 || showZero) {
                            badge.innerText = data[type];
                            badge.classList.remove('opacity-0');
                        } else {
                            badge.classList.add('opacity-0');
                        }
                    }
                });
            }

            // Start Polling
            pollOrderCounts();
        });
    </script>
</body>

</html>

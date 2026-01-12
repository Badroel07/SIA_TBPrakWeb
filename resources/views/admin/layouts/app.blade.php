<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dasbor Admin') - ePharma</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Parkinsans:wght@300..800&display=swap"
        rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .font-display { font-family: 'Parkinsans', sans-serif; }
        body { 
            font-family: 'Parkinsans', sans-serif; 
            zoom: 90%; 
            height: 111.1vh;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-100 font-sans text-slate-900 h-screen overflow-hidden flex" @yield('bodyAttributes')>

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white m-4 rounded-3xl shadow-xl flex flex-col shrink-0 relative overflow-hidden">
        
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center bg-purple-600 text-white rounded-xl shadow-purple-200 shadow-lg">
                <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="font-display font-bold text-xl leading-none tracking-tight">ePharma</h1>
                <span class="text-xs text-slate-400 font-medium tracking-wider">ADMIN PANEL</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-3 overflow-y-auto py-4">
            <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2 font-display">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-purple-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">dashboard</span>
                <span class="font-bold tracking-wide text-sm">Dasbor</span>
            </a>

            <a href="{{ route('admin.medicines.index') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ request()->routeIs('admin.medicines.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-purple-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">inventory_2</span>
                <span class="font-bold tracking-wide text-sm">Inventaris</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ request()->routeIs('admin.orders.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-purple-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">shopping_cart</span>
                <span class="font-bold tracking-wide text-sm">Pesanan</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 group font-display {{ request()->routeIs('admin.users.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30 translate-x-1' : 'text-slate-500 hover:bg-slate-50 hover:text-purple-600 hover:translate-x-1' }}">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">people</span>
                <span class="font-bold tracking-wide text-sm">Pengguna</span>
            </a>
        </nav>

        <!-- User Profile -->
        <div class="p-4 mt-auto">
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate font-display">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 truncate font-display tracking-wide uppercase">Super Admin</p>
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
        <div class="flex-1 overflow-y-auto p-6 lg:p-10 relative">
            <div class="relative max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </div>
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

</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dasbor Admin'); ?> - ePharma</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <!-- Fonts -->
    <?php echo $__env->make('components.fonts.parkin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .material-icons-round {
            font-size: 24px;
        }

        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(98, 0, 234, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
        }

        .sidebar-link.active {
            border-left-color: #6200EA;
            color: #6200EA;
        }

        .sidebar-link:hover {
            color: #6200EA;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#F3F4F6] text-slate-800 antialiased overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- HEADER -->
    <header
        class="fixed w-full z-30 flex items-center justify-between h-16 px-4 md:px-6 bg-[#6200EA] shadow-lg shadow-purple-900/10">
        <div class="flex items-center gap-3 w-64">
            <button @click="sidebarOpen = !sidebarOpen" class="p-1 mr-2 text-white/80 hover:text-white lg:hidden">
                <span class="material-icons-round text-2xl">menu</span>
            </button>
            <div class="flex items-center gap-2">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="ePharma Logo" class="w-8 h-8 object-contain bg-white rounded-lg p-1">
                <h1 class="text-xl font-bold tracking-tight text-white">ePharma <span class="italic">Admin</span></h1>
            </div>
        </div>

        <div class="flex-1 flex justify-between items-center pl-4 lg:pl-10">
            <!-- Search Bar (Hidden on mobile) -->


            <!-- Right Actions -->
            <div class="flex items-center gap-3 sm:gap-4 ml-auto">

                <div class="flex items-center gap-3 pl-3 sm:pl-4 border-l border-white/20">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-white leading-tight">
                            <?php echo e(Auth::user()->name ?? 'Admin User'); ?></p>
                        <p class="text-xs text-white/70">Super Admin</p>
                    </div>
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-tr from-yellow-400 to-orange-500 p-[2px] shadow-sm cursor-pointer">
                        <div
                            class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                            <span class="font-bold text-[#6200EA]"><?php echo e(substr(Auth::user()->name ?? 'A', 0, 1)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 w-64 bg-white border-r border-gray-200 shadow-sm z-20 transition-transform duration-300 pt-16 lg:pt-0 pb-1 flex flex-col">

            <div class="flex flex-col flex-1 overflow-y-auto py-6 space-y-1">
                <p class="px-6 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-600'); ?>">
                    <span
                        class="material-icons-round <?php echo e(request()->routeIs('admin.dashboard') ? '' : 'text-gray-400'); ?>">dashboard</span>
                    Dasbor
                </a>

                <a href="<?php echo e(route('admin.medicines.index')); ?>"
                    class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium <?php echo e(request()->routeIs('admin.medicines.*') ? 'active' : 'text-gray-600'); ?>">
                    <span
                        class="material-icons-round <?php echo e(request()->routeIs('admin.medicines.*') ? '' : 'text-gray-400'); ?>">inventory_2</span>
                    Inventaris
                </a>

                <a href="<?php echo e(route('admin.orders.index')); ?>"
                    class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : 'text-gray-600'); ?>">
                    <span class="material-icons-round <?php echo e(request()->routeIs('admin.orders.*') ? '' : 'text-gray-400'); ?>">shopping_cart</span>
                    Pesanan
                </a>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium <?php echo e(request()->routeIs('admin.users.*') ? 'active' : 'text-gray-600'); ?>">
                    <span
                        class="material-icons-round <?php echo e(request()->routeIs('admin.users.*') ? '' : 'text-gray-400'); ?>">people</span>
                    Pengguna
                </a>
            </div>

            <div class="p-4 border-t border-gray-100">
                <!-- Help Card -->
                <!-- <div
                    class="bg-gradient-to-br from-[#6200EA] to-[#7C4DFF] rounded-xl p-4 text-white shadow-lg shadow-purple-500/20 relative overflow-hidden group mb-4">
                    <div
                        class="absolute -right-4 -top-4 w-16 h-16 bg-white/20 rounded-full blur-lg group-hover:bg-white/30 transition-all">
                    </div>
                    <div class="relative z-10">
                        <p class="font-bold text-sm mb-1">Need Help?</p>
                        <p class="text-xs text-white/80 mb-3">Check our docs</p>
                        <button
                            class="w-full py-1.5 bg-white text-[#6200EA] text-xs font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-sm">Documentation</button>
                    </div>
                </div> -->

                <!-- Logout -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="flex items-center gap-3 px-2 py-2 text-sm font-medium text-red-500 hover:text-red-600 w-full hover:bg-red-50 rounded-lg transition-colors">
                        <span class="material-icons-round">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 bg-gray-900/50 z-10 lg:hidden" x-cloak></div>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto bg-[#F3F4F6] p-6 lg:p-10 relative">
            <div
                class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-purple-100/50 to-transparent pointer-events-none">
            </div>

            <div class="relative max-w-7xl mx-auto space-y-6">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <script>
        function showToast(type, message) {
            const container = document.getElementById('toast-container');
            const id = 'toast-' + Date.now();
            
            const colors = type === 'success' 
                ? 'bg-white border-l-4 border-green-500 text-gray-800' 
                : 'bg-white border-l-4 border-red-500 text-gray-800';
            
            const icon = type === 'success' ? 'check_circle' : 'error';
            const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';

            const toast = document.createElement('div');
            toast.id = id;
            toast.className = `${colors} shadow-lg rounded-lg p-4 flex items-center gap-3 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto min-w-[300px] max-w-md`;
            
            toast.innerHTML = `
                <span class="material-icons-round ${iconColor}">${icon}</span>
                <p class="text-sm font-medium flex-1">${message}</p>
                <button onclick="document.getElementById('${id}').remove()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-icons-round text-lg">close</span>
                </button>
            `;

            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            });

            // Auto dismiss
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        <?php if(session('success')): ?>
            document.addEventListener('DOMContentLoaded', () => showToast('success', "<?php echo e(session('success')); ?>"));
        <?php endif; ?>
        <?php if(session('error')): ?>
            document.addEventListener('DOMContentLoaded', () => showToast('error', "<?php echo e(session('error')); ?>"));
        <?php endif; ?>
    </script>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>
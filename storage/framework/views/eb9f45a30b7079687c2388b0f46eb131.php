<?php $__env->startSection('content'); ?>

    <style>
        @keyframes floatUp {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-40px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(59, 130, 246, 0.5);
            }
        }

        @keyframes rotate-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-float {
            animation: floatUp 4s ease-in-out infinite;
        }

        .animate-slide-up {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .animate-slide-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200% 100%;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-rotate-slow {
            animation: rotate-slow 30s linear infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .hover-lift {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }
    </style>

    <!-- Background Decorations -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full blur-3xl animate-float">
        </div>
        <div class="absolute top-1/3 -left-40 w-[400px] h-[400px] bg-gradient-to-tr from-purple-400/15 to-pink-400/15 rounded-full blur-3xl animate-float"
            style="animation-delay: 1.5s;"></div>
        <div class="absolute -bottom-40 right-1/4 w-[350px] h-[350px] bg-gradient-to-tl from-cyan-400/15 to-blue-400/15 rounded-full blur-3xl animate-float"
            style="animation-delay: 3s;"></div>

        <!-- Geometric decorations -->
        <div class="absolute top-40 right-20 w-64 h-64 border border-blue-200/20 rounded-full animate-rotate-slow"></div>
        <div class="absolute bottom-40 left-20 w-48 h-48 border border-indigo-200/15 rounded-full animate-rotate-slow"
            style="animation-direction: reverse;"></div>
    </div>

    <!-- 1. HERO SECTION - Epic Modern -->
    <section class="relative pt-20 md:pt-32 pb-24 overflow-hidden">
        <!-- Background image with overlay -->
        <div class="absolute inset-0 -z-20">
            <img src="<?php echo e(asset('img/pharmacy.jpg')); ?>" alt="Pharmacy Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/95 to-white/70"></div>
        </div>

        <div class="w-full px-6 md:px-12 lg:px-20 relative z-10">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 md:pr-10">
                    <!-- Badge with glow -->
                    <div
                        class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full text-sm font-bold mb-6 shadow-lg shadow-blue-500/30 animate-slide-up animate-pulse-glow">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Apotek Digital Terpercaya #1
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-extrabold text-gray-900 leading-tight mb-6 animate-slide-up"
                        style="animation-delay: 0.1s;">
                        Makes Your Health Better Will Makes Us <span
                            class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Better</span>
                    </h1>

                    <p class="text-gray-600 text-lg md:text-xl mb-8 max-w-md leading-relaxed animate-slide-up"
                        style="animation-delay: 0.2s;">
                        ePharma menyediakan obat-obatan primer dan layanan kesehatan terbaik setiap hari untuk Anda dan
                        keluarga.
                    </p>

                    <!-- CTA Button Epic -->
                    <a href="#katalog"
                        @click.prevent="document.getElementById('katalog').scrollIntoView({ behavior: 'smooth' })"
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl text-lg font-bold shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 animate-slide-up"
                        style="animation-delay: 0.3s;">
                        <div
                            class="w-12 h-12 bg-white/20  rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        Cari Obat Sekarang
                        <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>

                    <!-- Trust badges -->
                    <div class="flex flex-wrap gap-6 mt-10 animate-slide-up" style="animation-delay: 0.4s;">
                        <div class="flex items-center gap-2 text-gray-600">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-medium">100% Original</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-medium">Pengiriman Cepat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SEARCH & CATALOG SECTION - Enhanced -->
    <div id="katalog" class="w-full px-6 md:px-12 lg:px-20 py-16">
        <!-- Section Header -->
        <div class="text-center mb-12 animate-slide-up">
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 font-bold text-sm rounded-full mb-4">Katalog
                Produk</span>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 mb-4">
                Temukan <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Obat</span>
                Anda
            </h2>
            <p class="text-gray-500 max-w-lg mx-auto">Cari dari berbagai macam obat-obatan berkualitas dengan harga
                terjangkau</p>
            <div class="h-1.5 w-24 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 mx-auto mt-6 rounded-full">
            </div>
        </div>

        <!-- Search & Filter - Glass Card -->
        <div
            class="glass-card p-6 md:p-8 rounded-3xl shadow-2xl border border-white/50 mb-12 mx-auto relative z-20 animate-scale-in">
            <!-- Decorative -->
            <div class="absolute inset-0 rounded-3xl overflow-hidden pointer-events-none z-0">
                <div
                    class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full">
                </div>
            </div>

            <form action="<?php echo e(route('home')); ?>" method="GET"
                class="flex flex-col md:flex-row gap-4 items-center relative z-10" x-data="{
                    searchTimeout: null,
                    loading: false,
                    performSearch() {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.loading = true;
                            const formData = new FormData($el);
                            const params = new URLSearchParams(formData);

                            fetch('<?php echo e(route('home')); ?>?' + params.toString(), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                            })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newResults = doc.querySelector('#medicine-results');
                                const currentResults = document.querySelector('#medicine-results');
                                if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }


                                const newUrl = window.location.pathname + '?' + params.toString();
                                window.history.pushState({path: newUrl}, '', newUrl);

                                this.loading = false;
                            })
                            .catch(error => { console.error('Search error:', error); this.loading = false; });
                        }, 400);
                    }
                }">

                <!-- Search Input -->
                <div class="max-w-6xl w-full relative group">
                    <div
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-xl bg-blue-50 group-focus-within:bg-blue-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama obat..."
                        @input="performSearch()"
                        class="w-full pl-20 pr-4 py-4 border-2 border-gray-200 rounded-2xl text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 bg-gray-50/50 focus:bg-white text-lg">
                </div>

                <!-- Category Dropdown -->
                <div class="flex-grow w-full md:w-72 relative"
                    x-data="{ open: false, selectedLabel: '<?php echo e(request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori')); ?>', selectedValue: '<?php echo e(request('category') ?: 'all'); ?>' }"
                    @click.outside="open = false">

                    <input type="hidden" name="category" x-model="selectedValue" @change="performSearch()">

                    <button type="button" @click="open = !open"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-2xl text-gray-700 flex justify-between items-center cursor-pointer bg-gray-50/50 hover:bg-white hover:border-blue-300 transition-all duration-300">
                        <span class="truncate font-medium" x-text="selectedLabel"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 w-full mt-2 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden max-h-60 overflow-y-auto">

                        <a href="#"
                            class="group block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-600 hover:text-white transition-all duration-300"
                            @click.prevent="selectedLabel = 'Semua Kategori'; selectedValue = 'all'; open = false; performSearch()">
                            <span class="font-medium">Semua Kategori</span>
                        </a>

                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#"
                                class="group block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-600 hover:text-white transition-all duration-300"
                                @click.prevent="selectedLabel = '<?php echo e($cat); ?>'; selectedValue = '<?php echo e($cat); ?>'; open = false; performSearch()">
                                <span class="font-medium"><?php echo e($cat); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Search Button -->
                <button type="submit"
                    class="group w-full md:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl font-bold flex items-center justify-center gap-3 shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" x-show="!loading">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Cari
                </button>
            </form>
        </div>

        <!-- Results Container -->
        <div id="medicine-results">
            <?php if($medicines->count() > 0): ?>
                <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card group glass-card rounded-3xl overflow-hidden shadow-lg border border-gray-100 hover-lift animate-slide-up"
                            style="animation-delay: <?php echo e(($index % 8) * 0.1); ?>s;">
                            <!-- Image Container -->
                            <div class="product-image relative bg-gradient-to-br from-blue-50 to-indigo-50 h-56 overflow-hidden">
                                <!-- Category Badge -->
                                <span
                                    class="absolute top-4 left-4 z-10 px-4 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    <?php echo e($item->category); ?>

                                </span>

                                <?php if($item->image): ?>
                                    <img src="<?php echo e(Storage::disk('public')->url($item->image)); ?>" alt="<?php echo e($item->name); ?>"
                                        class="w-full h-full object-cover transition-transform duration-700">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-blue-400/20 rounded-full blur-xl animate-pulse"></div>
                                            <svg class="w-20 h-20 text-blue-300 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Hover Overlay -->
                                <div
                                    class="product-overlay absolute inset-0 bg-gradient-to-t from-blue-900/80 via-transparent to-transparent opacity-0 transition-opacity duration-300 flex items-end justify-center pb-4">
                                    <a href="<?php echo e(route('show', $item->id)); ?>"
                                        class="px-6 py-2 bg-white/20  text-white font-bold rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-300">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <h3
                                    class="font-heading font-bold text-lg text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-1">
                                    <?php echo e($item->name); ?></h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2 h-12 leading-relaxed"><?php echo e($item->description); ?></p>

                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="text-xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                        Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                    </span>
                                    <?php if($item->stock > 0): ?>
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-full flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                            Tersedia
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">
                                            Stok Habis
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex gap-2">
                                    <?php if($item->stock > 0): ?>
                                        <button type="button"
                                            @click="addToCart({ id: <?php echo e($item->id); ?>, name: '<?php echo e($item->name); ?>', price: <?php echo e($item->price); ?>, image: '<?php echo e($item->image); ?>' })"
                                            class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-[1.02]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    <?php else: ?>
                                        <button type="button" disabled
                                            class="flex-1 py-3 bg-gray-200 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                            Stok Kosong
                                        </button>
                                    <?php endif; ?>


                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <?php echo e($medicines->links()); ?>

                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-20 glass-card rounded-3xl border border-gray-100 animate-scale-in">
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-xl font-bold mb-2">Tidak ada obat yang cocok</p>
                    <p class="text-gray-400">Coba kata kunci atau kategori lain</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('modals'); ?>
        <?php echo $__env->make('components.cart.floatingCart', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.cart.cartModal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.cart.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('components.cart.confirmDelete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopPush(); ?>

    <?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            // Check if page, search, or category params exist
            if (urlParams.has('page') || urlParams.has('search') || urlParams.has('category')) {
                const katalogSection = document.getElementById('katalog');
                if (katalogSection) {
                    // Small delay to ensure rendering
                    setTimeout(() => {
                        const offsetTop = katalogSection.getBoundingClientRect().top + window.pageYOffset - 100;
                        window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                    }, 100);
                }
            }
        });
    </script>
    <?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/customer/index.blade.php ENDPATH**/ ?>
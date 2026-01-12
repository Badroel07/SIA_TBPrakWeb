@extends('customer.layouts.app')

@section('content')

    <style>
        /* Custom Animations for Medicine Detail Page */
        @keyframes floatUp {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
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

        @keyframes scaleIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(59, 130, 246, 0.6);
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
            animation: floatUp 3s ease-in-out infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideInRight 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideInUp 0.5s ease-out forwards;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.98);
        }

        .gradient-border {
            position: relative;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 2px;
            border-radius: inherit;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .hover-3d {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .hover-3d:hover {
            transform: perspective(1000px) rotateX(5deg) rotateY(-5deg) translateZ(20px);
        }
    </style>

    <!-- Hero Background with Decorative Elements -->
    <div class="relative min-h-screen overflow-hidden">
        <!-- Background Elements -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-100/50 to-indigo-100/50 rounded-full"></div>
            <div class="absolute top-1/2 -left-40 w-80 h-80 bg-gradient-to-tr from-purple-100/40 to-pink-100/40 rounded-full"></div>
            <div class="absolute -bottom-40 right-1/3 w-72 h-72 bg-gradient-to-tl from-cyan-100/40 to-blue-100/40 rounded-full"></div>
        </div>

        <!-- Back Button - Floating Style -->
        <div class="container mx-auto px-4 pt-8 relative z-10">
            <a href="javascript:history.back()"
                class="group inline-flex items-center gap-3 px-5 py-3 bg-white/80  rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-x-2 border border-gray-100">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">Kembali ke
                    Katalog</span>
            </a>
        </div>

        <!-- Main Content -->
        <section class="container mx-auto px-4 py-8 md:py-12 relative z-10">

            <!-- Product Card - Glass Morphism -->
            <div
                class="glass-card rounded-3xl shadow-2xl p-6 md:p-10 border border-white/50 relative overflow-hidden animate-scale-in">

                <!-- Decorative corner elements -->
                <div
                    class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-indigo-500/10 to-transparent rounded-tr-full">
                </div>

                <div class="flex flex-col lg:flex-row gap-10 relative z-10">

                    <!-- Left: Product Image with Stunning Effects -->
                    <div class="lg:w-2/5 flex-shrink-0 animate-slide-up" style="animation-delay: 0.1s;">
                        <div class="relative group">
                            <!-- Glowing background -->
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 rounded-3xl opacity-50">
                            </div>

                            <!-- Image container -->
                            <div
                                class="relative gradient-border rounded-3xl overflow-hidden bg-gradient-to-br from-gray-50 to-blue-50 p-8">
                                <!-- Shimmer overlay on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent opacity-0 group-hover:opacity-100 group-hover:animate-shimmer transition-opacity duration-300">
                                </div>

                                @if($medicine->image)
                                    <img src="{{ Storage::disk('public')->url($medicine->image) }}" alt="{{ $medicine->name }}"
                                        class="w-full h-80 object-contain rounded-2xl transform group-hover:scale-110 transition-transform duration-700 ease-out drop-shadow-2xl">
                                @else
                                    <div class="w-full h-80 flex items-center justify-center">
                                        <div class="relative">
                                            <svg class="w-40 h-40 text-blue-400 relative z-10" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif

                                <!-- Category badge floating -->
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-bold rounded-full shadow-lg uppercase tracking-wider animate-pulse">
                                        {{ $medicine->category }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Product Details -->
                    <div class="lg:w-3/5 space-y-6 animate-slide-right" style="animation-delay: 0.2s;">

                        <!-- Product Name with Gradient -->
                        <div>
                            <h1
                                class="text-4xl md:text-5xl font-heading font-extrabold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent leading-tight">
                                {{ $medicine->name }}
                            </h1>
                            <div
                                class="h-1.5 w-24 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 rounded-full mt-4">
                            </div>
                        </div>

                        <!-- Price & Stock - Modern Cards -->
                        <div class="flex flex-wrap items-center gap-4">
                            <!-- Price Card -->
                            <div
                                class="group relative px-6 py-4 bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 rounded-2xl shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                                <div
                                    class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                                <p class="text-3xl font-extrabold text-white relative z-10">
                                    Rp {{ number_format($medicine->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Stock Badge -->
                            @if($medicine->stock > 0)
                                <div
                                    class="flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-emerald-500 to-green-500 rounded-2xl shadow-lg shadow-green-500/30 text-white">
                                    <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                                    <span class="font-bold">Stok: {{ $medicine->stock }} tersedia</span>
                                </div>
                            @else
                                <div
                                    class="flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-red-500 to-rose-500 rounded-2xl shadow-lg shadow-red-500/30 text-white">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                    <span class="font-bold">Stok Habis</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description Card -->
                        <div
                            class="relative p-6 bg-gradient-to-br from-gray-50 to-blue-50/50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors group">
                            <div
                                class="absolute top-4 right-4 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $medicine->description }}</p>
                        </div>

                        <!-- Add to Cart Button - Epic Style -->
                        @if($medicine->stock > 0)
                            <button type="button"
                                @click="addToCart({ id: {{ $medicine->id }}, name: '{{ $medicine->name }}', price: {{ $medicine->price }}, image: '{{ $medicine->image }}' })"
                                class="group relative w-full md:w-auto overflow-hidden px-10 py-5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-bold text-lg rounded-2xl shadow-2xl shadow-blue-500/40 hover:shadow-blue-500/60 transition-all duration-500 hover:scale-105 transform">

                                <!-- Animated background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>

                                <!-- Shine effect -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                                </div>

                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6 group-hover:animate-bounce" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Tambah ke Keranjang
                                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </button>
                        @else
                            <button disabled
                                class="w-full md:w-auto px-10 py-5 bg-gray-300 text-gray-500 font-bold text-lg rounded-2xl cursor-not-allowed">
                                <span class="flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg>
                                    Stok Kosong
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Information Section - Stunning Cards -->
            <div class="mt-16 animate-slide-up" style="animation-delay: 0.4s;">

                <!-- Section Title -->
                <div class="text-center mb-12">
                    <h2
                        class="text-3xl md:text-4xl font-heading font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-gray-900 bg-clip-text text-transparent">
                        Informasi Produk Detail
                    </h2>
                    <p class="text-gray-500 mt-2">Semua yang perlu Anda ketahui tentang produk ini</p>
                    <div
                        class="h-1 w-32 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-full mx-auto mt-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Card 1: Indikasi & Dosis -->
                    <div
                        class="group hover-3d glass-card p-8 rounded-3xl border border-blue-100 hover:border-blue-300 shadow-xl hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                        <!-- Gradient overlay on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Floating icon -->
                        <div
                            class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full opacity-50">
                        </div>

                        <div class="relative z-10">
                            <!-- Header -->
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <i class="fas fa-prescription-bottle-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Indikasi & Dosis</h3>
                                    <p class="text-sm text-gray-500">Panduan penggunaan obat</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="space-y-5">
                                <div class="p-4 bg-blue-50/50 rounded-xl border-l-4 border-blue-500">
                                    <p class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-2">Indikasi Utama
                                    </p>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $medicine->full_indication }}</p>
                                </div>

                                <div class="p-4 bg-indigo-50/50 rounded-xl border-l-4 border-indigo-500">
                                    <p class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-2">Cara
                                        Penggunaan</p>
                                    <p class="text-gray-700 whitespace-pre-line">
                                        @if(isset($medicine->usage_detail))
                                            {{ $medicine->usage_detail }}
                                        @else
                                            Konsultasikan dengan apoteker atau dokter Anda.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Efek Samping & Kontraindikasi -->
                    <div
                        class="group hover-3d glass-card p-8 rounded-3xl border border-red-100 hover:border-red-300 shadow-xl hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                        <!-- Gradient overlay on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-orange-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Floating icon -->
                        <div
                            class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-red-100 to-orange-100 rounded-full opacity-50">
                        </div>

                        <div class="relative z-10">
                            <!-- Header -->
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-300">
                                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Peringatan & Efek Samping</h3>
                                    <p class="text-sm text-gray-500">Informasi keamanan penting</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="space-y-5">
                                <div class="p-4 bg-orange-50/50 rounded-xl border-l-4 border-orange-500">
                                    <p class="text-sm font-bold text-orange-600 uppercase tracking-wider mb-2">Efek Samping
                                    </p>
                                    <p class="text-gray-700 whitespace-pre-line">
                                        @if(isset($medicine->side_effects))
                                            {{ $medicine->side_effects }}
                                        @else
                                            Belum ada data efek samping yang dicatat.
                                        @endif
                                    </p>
                                </div>

                                <div class="p-4 bg-red-50/50 rounded-xl border-l-4 border-red-500">
                                    <p class="text-sm font-bold text-red-600 uppercase tracking-wider mb-2">Kontraindikasi
                                        (Larangan)</p>
                                    <p class="text-gray-700 whitespace-pre-line">
                                        @if(isset($medicine->contraindications))
                                            {{ $medicine->contraindications }}
                                        @else
                                            Hati-hati pada pasien dengan gangguan fungsi ginjal/hati.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Trust Badges -->
                <div class="mt-12 flex flex-wrap justify-center gap-6 animate-slide-up" style="animation-delay: 0.6s;">
                    <div
                        class="flex items-center gap-3 px-6 py-3 bg-white/80  rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-700">100% Original</span>
                    </div>


                </div>
            </div>

        </section>
    </div>

    @push('modals')
        @include('components.cart.floatingCart')
        @include('components.cart.cartModal')
        @include('components.cart.toast')
        @include('components.cart.confirmDelete')
    @endpush

@endsection
@extends('customer.layouts.app')

@section('content')

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

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
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
            transform: translateY(40px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
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

    @keyframes pulseGlow {

        0%,
        100% {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.4);
        }

        50% {
            box-shadow: 0 0 60px rgba(59, 130, 246, 0.8);
        }
    }

    @keyframes rotateSlow {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes countUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-float {
        animation: floatUp 4s ease-in-out infinite;
    }

    .animate-slide-left {
        animation: slideInLeft 0.8s ease-out forwards;
    }

    .animate-slide-right {
        animation: slideInRight 0.8s ease-out forwards;
    }

    .animate-slide-up {
        animation: slideInUp 0.6s ease-out forwards;
    }

    .animate-scale-in {
        animation: scaleIn 0.5s ease-out forwards;
    }

    .animate-pulse-glow {
        animation: pulseGlow 3s ease-in-out infinite;
    }

    .animate-rotate-slow {
        animation: rotateSlow 30s linear infinite;
    }

    .animate-count {
        animation: countUp 0.8s ease-out forwards;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.98);
    }

    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .team-card:hover .team-overlay {
        opacity: 1;
    }

    .team-card:hover img {
        transform: scale(1.1);
    }
</style>

<!-- Background -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-gradient-to-br from-blue-100/50 to-indigo-100/50 rounded-full"></div>
    <div class="absolute top-1/3 -left-40 w-[400px] h-[400px] bg-gradient-to-tr from-purple-100/40 to-pink-100/40 rounded-full"></div>
    <div class="absolute -bottom-40 right-1/4 w-[350px] h-[350px] bg-gradient-to-tl from-cyan-100/40 to-blue-100/40 rounded-full"></div>
</div>

<!-- 1. HERO SECTION - Epic Modern -->
<section class="relative py-24 md:py-36 overflow-hidden">
    <!-- Hero Background with Gradient Overlay -->
    <div class="absolute inset-0 -z-20">
        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1920&auto=format&fit=crop"
            alt="Medical Team"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-900/80 via-gray-900/70 to-gray-900/90"></div>
    </div>

    <!-- Animated particles -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-20 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-float opacity-60"></div>
        <div class="absolute top-40 right-1/3 w-3 h-3 bg-indigo-400 rounded-full animate-float opacity-40" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-20 left-1/3 w-2 h-2 bg-cyan-400 rounded-full animate-float opacity-50" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 text-center relative z-10">
        <div class="animate-slide-up">
            <span class="inline-flex items-center gap-2 px-6 py-2 bg-blue-500/20  border border-blue-400/30 text-blue-300 font-bold tracking-wider uppercase text-sm mb-6 rounded-full animate-pulse-glow">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Who We Are
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl font-heading font-extrabold text-white mb-6 animate-slide-up" style="animation-delay: 0.1s;">
            Tentang <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-indigo-400 bg-clip-text text-transparent">ePharma</span>
        </h1>

        <p class="text-blue-100 text-xl max-w-3xl mx-auto leading-relaxed animate-slide-up" style="animation-delay: 0.2s;">
            Dedikasi kami untuk memberikan layanan kesehatan terbaik dan obat-obatan berkualitas bagi masyarakat Indonesia.
        </p>

        <!-- Scroll indicator -->
        <div class="mt-16 animate-bounce">
            <svg class="w-8 h-8 mx-auto text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </div>
</section>

<!-- 2. OUR STORY SECTION - Modern Cards -->
<section class="py-24 relative">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-16">

            <!-- Image Side with Floating Effects -->
            <div class="lg:w-1/2 relative animate-slide-left">
                <!-- Decorative elements -->
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl -z-10 animate-float"></div>
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gradient-to-tr from-cyan-500 to-blue-500 rounded-2xl -z-10 animate-float" style="animation-delay: 1s;"></div>

                <!-- Glowing border -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 rounded-3xl opacity-50"></div>

                <div class="relative glass-card p-3 rounded-3xl shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?q=80&w=1000&auto=format&fit=crop"
                        alt="Pharmacy Interior"
                        class="rounded-2xl w-full h-[450px] object-cover">
                </div>
            </div>

            <!-- Text Side -->
            <div class="lg:w-1/2 animate-slide-right">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 font-bold text-sm rounded-full mb-4">Cerita Kami</span>

                <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 mb-6 leading-tight">
                    Melayani Kesehatan Keluarga Sejak <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">2015</span>
                </h2>

                <div class="space-y-4 text-gray-600 text-lg leading-relaxed mb-8">
                    <p>
                        ePharma bermula dari sebuah apotek kecil di pusat kota Garut. Dengan visi untuk mempermudah akses obat-obatan berkualitas, kami kini telah berkembang menjadi sistem informasi apotek digital yang terintegrasi.
                    </p>
                    <p>
                        Kami percaya bahwa kesehatan adalah aset paling berharga. Oleh karena itu, seluruh produk yang kami sediakan dijamin 100% asli, tersertifikasi BPOM, dan ditangani langsung oleh Apoteker profesional.
                    </p>
                </div>

                <!-- Feature badges -->
                <div class="flex flex-wrap gap-4">
                    <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-2xl shadow-lg border border-gray-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">100% Asli</h4>
                            <p class="text-sm text-gray-500">Produk Terjamin BPOM</p>
                        </div>
                    </div>

                    <div class="group flex items-center gap-3 px-5 py-3 bg-white rounded-2xl shadow-lg border border-gray-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">24/7 Support</h4>
                            <p class="text-sm text-gray-500">Layanan Cepat Tanggap</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. STATS COUNTER - Epic Gradient -->
<section class="py-20 relative overflow-hidden">
    <!-- Background gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700"></div>

    <!-- Animated shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-10 w-40 h-40 border border-white/10 rounded-full animate-rotate-slow"></div>
        <div class="absolute bottom-10 right-10 w-60 h-60 border border-white/10 rounded-full animate-rotate-slow" style="animation-direction: reverse;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="text-center group animate-count" style="animation-delay: 0.1s;">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10  rounded-2xl mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                    <svg class="w-10 h-10 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-5xl font-heading font-extrabold text-white mb-2">10+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wider font-medium">Tahun Pengalaman</p>
            </div>

            <!-- Stat 2 -->
            <div class="text-center group animate-count" style="animation-delay: 0.2s;">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10  rounded-2xl mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                    <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-5xl font-heading font-extrabold text-white mb-2">5k+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wider font-medium">Pelanggan Puas</p>
            </div>

            <!-- Stat 3 -->
            <div class="text-center group animate-count" style="animation-delay: 0.3s;">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10  rounded-2xl mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                    <svg class="w-10 h-10 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div class="text-5xl font-heading font-extrabold text-white mb-2">500+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wider font-medium">Jenis Obat</p>
            </div>

            <!-- Stat 4 -->
            <div class="text-center group animate-count" style="animation-delay: 0.4s;">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10  rounded-2xl mb-4 group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                    <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="text-5xl font-heading font-extrabold text-white mb-2">20+</div>
                <p class="text-blue-200 text-sm uppercase tracking-wider font-medium">Ahli Medis</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. TEAM SECTION - Modern Cards -->
<section class="py-24 relative">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16 animate-slide-up">
            <span class="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-600 font-bold text-sm rounded-full mb-4">Our Team</span>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 mb-4">
                Meet Our <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Expert</span> Team
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Tim profesional kami yang berdedikasi untuk kesehatan Anda</p>
            <div class="h-1.5 w-24 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 rounded-full mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="team-card group glass-card rounded-3xl shadow-xl overflow-hidden hover-lift animate-slide-up" style="animation-delay: 0.1s;">
                <div class="h-96 overflow-hidden relative">
                    <img src="{{ asset('img/kami/restu.jpeg')}}"
                        alt="Ketua"
                        class="w-full h-full object-cover transition-transform duration-700">
                    <div class="team-overlay absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/50 to-transparent opacity-0 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-xl mb-1">Restu Sulton</h3>
                    <p class="text-blue-600 font-medium">Ketua</p>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="team-card group glass-card rounded-3xl shadow-xl overflow-hidden hover-lift animate-slide-up" style="animation-delay: 0.2s;">
                <div class="h-96 overflow-hidden relative">
                    <img src="{{ asset('img/kami/ruby.jpeg')}}"
                        alt="Doctor"
                        class="w-full h-full object-cover transition-transform duration-700">
                    <div class="team-overlay absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/50 to-transparent opacity-0 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-xl mb-1">Ruby Ardha Apriadi</h3>
                    <p class="text-blue-600 font-medium">Anggota</p>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="team-card group glass-card rounded-3xl shadow-xl overflow-hidden hover-lift animate-slide-up" style="animation-delay: 0.3s;">
                <div class="h-96 overflow-hidden relative">
                    <img src="{{ asset('img/kami/chikal.png')}}"
                        alt="Doctor"
                        class="w-full h-full object-cover transition-transform duration-700">
                    <div class="team-overlay absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/50 to-transparent opacity-0 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-xl mb-1">Muhamad Chikal Ubaidillah Nurhasan</h3>
                    <p class="text-blue-600 font-medium">Anggota</p>
                </div>
            </div>

            <!-- Team Member 4
            <div class="team-card group glass-card rounded-3xl shadow-xl overflow-hidden hover-lift animate-slide-up" style="animation-delay: 0.4s;">
                <div class="h-72 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=800&auto=format&fit=crop"
                        alt="Doctor"
                        class="w-full h-full object-cover transition-transform duration-700">
                    <div class="team-overlay absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/50 to-transparent opacity-0 transition-opacity duration-500 flex items-end justify-center pb-8">
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/20  rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-blue-600 transition-all">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <h3 class="font-bold text-gray-900 text-xl mb-1">Apt. Rian Hidayat</h3>
                    <p class="text-blue-600 font-medium">Manajer Operasional</p>
                </div>
            </div> -->
        </div>
    </div>
</section>

@endsection
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - ePharma</title>
    @vite('resources/css/app.css')
    @include('components.fonts.parkin')
    @include('components.fonts.fontAwesome')

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes slide-up {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
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
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-ring {
            animation: pulse-ring 2s ease-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scale-in 0.6s ease-out forwards;
        }

        .animate-rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), 0 0 30px rgba(59, 130, 246, 0.1);
        }

        .btn-shine {
            position: relative;
            overflow: hidden;
        }

        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-shine:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 animate-gradient">

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Floating orbs -->
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>

        <!-- Geometric decorations -->
        <div class="absolute top-10 right-10 w-40 h-40 border border-white/10 rounded-full animate-rotate-slow"></div>
        <div class="absolute bottom-10 left-10 w-60 h-60 border border-white/5 rounded-full animate-rotate-slow" style="animation-direction: reverse;"></div>
        <div class="absolute top-1/3 right-1/4 w-20 h-20 border border-blue-400/20 rounded-xl rotate-45 animate-float"></div>

        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    <div class="w-full max-w-2xl relative z-10">

        <!-- Glowing ring behind card -->
        <div class="absolute inset-0 -m-4">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 rounded-[2rem] blur-xl opacity-30 animate-pulse"></div>
        </div>

        <!-- Main Card -->
        <div class="glass-card p-10 rounded-3xl shadow-2xl border border-white/20 relative animate-scale-in">

            <!-- Decorative corner elements -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500/20 to-transparent rounded-bl-3xl"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-emerald-500/20 to-transparent rounded-tr-3xl"></div>

            <!-- Logo with pulse ring -->
            <div class="flex justify-center mb-8 animate-slide-up">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-500 rounded-2xl animate-pulse-ring opacity-30"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl flex items-center justify-center shadow-lg shadow-slate-300/50 border border-slate-200/50 transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma" class="w-16 h-16">
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-8 animate-slide-up" style="animation-delay: 0.1s;">
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent mb-2">
                    Daftar Akun Baru
                </h1>
                <p class="text-gray-500">Bergabunglah dengan ePharma untuk kemudahan belanja obat</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div class="space-y-2 animate-slide-up" style="animation-delay: 0.2s;">
                    <label for="name" class="block text-sm font-semibold text-gray-700">
                        Nama Lengkap
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-green-50 group-focus-within:bg-green-100 flex items-center justify-center transition-colors">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="input-glow block w-full pl-16 pr-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 transition-all duration-300 text-gray-900 bg-gray-50/50 focus:bg-white"
                            placeholder="Nama lengkap Anda">
                    </div>
                    @error('name')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="space-y-2 animate-slide-up" style="animation-delay: 0.25s;">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-green-50 group-focus-within:bg-green-100 flex items-center justify-center transition-colors">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="input-glow block w-full pl-16 pr-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 transition-all duration-300 text-gray-900 bg-gray-50/50 focus:bg-white"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2 animate-slide-up" style="animation-delay: 0.3s;">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-green-50 group-focus-within:bg-green-100 flex items-center justify-center transition-colors">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="input-glow block w-full pl-16 pr-12 py-4 border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 transition-all duration-300 text-gray-900 bg-gray-50/50 focus:bg-white"
                            placeholder="Minimal 8 karakter">
                        <!-- Toggle Password Visibility -->
                        <button type="button" onclick="togglePassword('password', 'eyeIconRegister')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-green-500 transition-colors">
                            <svg id="eyeIconRegister" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2 animate-slide-up" style="animation-delay: 0.35s;">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                        Konfirmasi Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <div class="w-10 h-10 rounded-xl bg-green-50 group-focus-within:bg-green-100 flex items-center justify-center transition-colors">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="input-glow block w-full pl-16 pr-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-green-500 transition-all duration-300 text-gray-900 bg-gray-50/50 focus:bg-white"
                            placeholder="Ulangi password Anda">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="animate-slide-up btn-shine w-full py-4 px-6 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 text-white font-bold text-lg rounded-2xl shadow-xl shadow-green-500/30 hover:shadow-green-500/50 transform hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-500/30" style="animation-delay: 0.4s;">
                    <span class="flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Daftar Sekarang
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center animate-slide-up" style="animation-delay: 0.45s;">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span class="px-4 text-sm text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Footer -->
            <div class="text-center animate-slide-up" style="animation-delay: 0.5s;">
                <p class="text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-emerald-700 font-semibold transition-colors ml-1 hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 text-center animate-slide-up" style="animation-delay: 0.55s;">
            <p class="text-white/60 text-sm flex items-center justify-center gap-2">
                <span>© 2025</span>
                <span class="font-semibold text-white/80">ePharma</span>
                <span>•</span>
                <span>All Rights Reserved</span>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>

</body>

</html>

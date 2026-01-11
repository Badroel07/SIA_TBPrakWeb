<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // 1. Tampilkan form login
    public function loginForm()
    {
        // Jika user sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    // 2. Proses otentikasi (login)
    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba proses login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek Role: Terima admin, cashier, dan customer
            if ($user->role === 'admin') {
                // Redirect ke dashboard admin
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'cashier') {
                // Redirect ke dashboard kasir
                return redirect()->intended(route('cashier.dashboard'));
            } elseif ($user->role === 'customer') {
                // Redirect ke home page untuk customer
                return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali!');
            } else {
                // Role tidak diizinkan
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akses ditolak. Role Anda tidak memiliki izin untuk masuk.',
                ])->onlyInput('email');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak sesuai.',
        ])->onlyInput('email');
    }

    // 3. Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect ke halaman utama/login
    }

    // 4. Helper method untuk redirect berdasarkan role
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'cashier') {
            return redirect()->route('cashier.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('home');
        }

        // Default fallback
        Auth::logout();
        return redirect('/login');
    }

    // 5. Tampilkan form registrasi customer
    public function registerForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.register');
    }

    // 6. Proses registrasi customer
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}

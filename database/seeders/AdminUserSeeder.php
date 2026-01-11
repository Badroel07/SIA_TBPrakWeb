<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Impor DB facade
use Illuminate\Support\Facades\Hash; // Impor Hash facade
use App\Models\User; // Impor model User

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // 1. Cek apakah user admin sudah ada berdasarkan email
        $adminEmail = 'admin@epharma';

        if (User::where('email', $adminEmail)->exists()) {
            $this->command->info('Akun Admin sudah ada!');
            return; // Hentikan eksekusi jika sudah ada
        }

        // 2. Buat akun admin baru
        User::create([
            'name' => 'Administrator',
            'email' => $adminEmail,
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' => Hash::make('password123'), // Ganti dengan password yang kuat
            // Kamu bisa menambahkan kolom lain di sini, misalnya 'is_admin' => true, jika kamu memilikinya.
        ]);

        $this->command->info('Akun Admin berhasil dibuat!');
    }
}

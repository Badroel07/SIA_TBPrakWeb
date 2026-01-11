<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Tambahkan pemanggilan DrugSeeder di sini.
        // $this->call([
        //     MedicineSeeder::class, // Panggil seeder obat kita
        //     // Jika ada seeder lain, tambahkan di bawah
        // ]);

        $this->call([
            AdminUserSeeder::class, // Panggil seeder obat kita
            // Jika ada seeder lain, tambahkan di bawah
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker bahasa Indonesia

        // 1. Disable foreign key checks dan kosongkan tabel medicines
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('medicines')->truncate();

        // Daftar Kategori yang akan diacak
        $categories = [
            'Analgesik & Antipiretik',
            'Antibiotik (Penisilin)',
            'Anti-inflamasi Non-steroid (OAINS)',
            'Antihistamin',
            'Bronkodilator',
            'Suplemen Vitamin',
            'Antasida',
            'Obat Batuk & Flu',
            'Antidiabetik',
            'Antijamur',
            'Antivirus',
            'Diuretik',
            'Antidepresan',
            'Antikoagulan',
            'Kortikosteroid'
        ];

        // Daftar nama obat yang lebih realistis
        $medicineNames = [
            'Paracetamol',
            'Amoxicillin',
            'Ibuprofen',
            'Cetirizine',
            'Salbutamol',
            'Vitamin C',
            'Antasida',
            'Dextromethorphan',
            'Metformin',
            'Aspirin',
            'Omeprazole',
            'Loratadine',
            'Simvastatin',
            'Amlodipine',
            'Ciprofloxacin',
            'Prednisone',
            'Insulin',
            'Furosemide',
            'Warfarin',
            'Sertraline',
            'Allopurinol',
            'Gabapentin',
            'Losartan',
            'Metoprolol',
            'Pantoprazole',
            'Azithromycin',
            'Diphenhydramine',
            'Hydrochlorothiazide',
            'Atorvastatin',
            'Tramadol',
            'Levothyroxine',
            'Lisinopril',
            'Gabapentin',
            'Metoclopramide',
            'Ranitidine',
            'Clonazepam',
            'Tamsulosin',
            'Citalopram',
            'Nifedipine',
            'Fluoxetine',
            'Glipizide',
            'Montelukast',
            'Tizanidine',
            'Hydroxyzine',
            'Ropinirole',
            'Bupropion',
            'Ondansetron',
            'Zolpidem',
            'Carvedilol',
            'Terbinafine',
            'Sumatriptan',
            'Esomeprazole',
            'Venlafaxine',
            'Risperidone',
            'Pioglitazone',
            'Methylprednisolone',
            'Promethazine',
            'Mirtazapine',
            'Clopidogrel',
            'Albuterol',
            'Oxycodone',
            'Methotrexate',
            'Fexofenadine',
            'Duloxetine',
            'Tamsulosin',
            'Dicyclomine',
            'Clonidine',
            'Propranolol',
            'Amitriptyline',
            'Hydrocodone',
            'Baclofen',
            'Naproxen',
            'Meloxicam',
            'Cyclobenzaprine',
            'Mupirocin',
            'Triamcinolone',
            'Benadryl',
            'Zyrtec',
            'Advair',
            'Nexium',
            'Lipitor',
            'Plavix',
            'Abilify',
            'Seroquel',
            'Singulair',
            'Celebrex',
            'Actos',
            'Effexor',
            'Wellbutrin',
            'Cymbalta',
            'Vytorin',
            'Lyrica',
            'Spiriva',
            'Januvia',
            'Novolog',
            'Lantus',
            'Humalog',
            'Novorapid',
            'Tresiba',
            'Victoza',
            'Trulicity',
            'Ozempic',
            'Rybelsus',
            'Farxiga',
            'Jardiance',
            'Invokana',
            'Steglatro',
            'Synjardy',
            'Xigduo',
            'Glyxambi'
        ];

        $medicines = [];
        $usedNames = [];

        for ($i = 1; $i <= 100; $i++) {
            // Pilih nama obat secara acak, pastikan tidak ada duplikasi
            do {
                $nameIndex = array_rand($medicineNames);
                $name = $medicineNames[$nameIndex];
            } while (in_array($name, $usedNames));

            $usedNames[] = $name;

            // Tambahkan variasi pada nama (dosis, merek, dll)
            $nameVariations = ['', 'Forte', 'SR', 'XR', 'Retard', 'Depot', 'Long Acting'];
            $name .= ' ' . $faker->randomElement($nameVariations);

            // Tambahkan dosis acak
            $doses = [100, 250, 500, 1000, 2000, 50, 75, 150, 300, 600, 5, 10, 20, 40, 80];
            $name .= ' ' . $faker->randomElement($doses) . 'mg';

            $category = $faker->randomElement($categories);
            $stock = rand(0, 100); // Diperluas rentang stok
            $price = rand(5000, 500000); // Diperluas rentang harga

            // Simulasikan beberapa obat sudah terjual
            $totalSold = rand(0, 200);

            // Gambar tidak disertakan di seeder
            // Upload gambar secara manual melalui Admin Panel
            $image = null;

            // Buat deskripsi yang lebih realistis
            $descriptions = [
                'Obat ini digunakan untuk mengobati berbagai kondisi medis.',
                'Efektif untuk mengurangi gejala yang terkait dengan kondisi tertentu.',
                'Direkomendasan untuk penggunaan jangka pendek atau panjang tergantung kondisi.',
                'Harus digunakan sesuai petunjuk dokter atau apoteker.',
                'Dapat menyebabkan efek samping tertentu pada beberapa pengguna.',
                'Konsumsi dengan makanan dapat mengurangi risiko sakit perut.',
                'Tidak boleh dikonsumsi bersama dengan alkohol.',
                'Hindari mengemudi atau mengoperasikan mesin setelah mengonsumsi obat ini.'
            ];

            $indications = [
                'Digunakan untuk mengobati infeksi bakteri ringan hingga sedang.',
                'Meringankan nyeri ringan hingga sedang.',
                'Mengurangi peradangan dan demam.',
                'Mengobati reaksi alergi.',
                'Membantu mengendalikan kadar gula darah.',
                'Menurunkan tekanan darah tinggi.',
                'Mengobati depresi dan kecemasan.',
                'Mengontrol asam lambung dan tukak lambung.'
            ];

            $sideEffects = [
                'Mual, muntah, dan sakit perut.',
                'Pusing, mengantuk, dan kelelahan.',
                'Ruam kulit dan gatal-gatal.',
                'Peningkatan berat badan.',
                'Perubahan nafsu makan.',
                'Mulut kering dan penglihatan kabur.',
                'Sulit tidur atau insomnia.',
                'Tidak ada efek samping signifikan jika digunakan sesuai dosis.'
            ];

            $medicines[] = [
                'name' => $name,
                'slug' => Str::slug($name . '-' . $i),
                'category' => $category,
                'price' => $price,
                'stock' => $stock,
                'total_sold' => $totalSold,
                'image' => $image,

                // Detail Informasi (Lebih realistis)
                'description' => $faker->randomElement($descriptions),
                'full_indication' => $faker->randomElement($indications) . ' ' . $faker->sentence(5),
                'usage_detail' => 'Dosis: ' . rand(1, 3) . " kali sehari " . $faker->randomElement(['sebelum makan', 'sesudah makan', 'bersama makan']) . ". " . $faker->sentence(3),
                'side_effects' => $faker->randomElement($sideEffects),
                'contraindications' => $faker->randomElement([
                    'Hipersensitivitas terhadap kandungan obat.',
                    'Tidak boleh digunakan pada pasien dengan gangguan hati berat.',
                    'Kontraindikasi pada pasien dengan gangguan ginjal.',
                    'Tidak direkomendasikan untuk ibu hamil dan menyusui.',
                    'Hati-hati penggunaan pada penderita penyakit jantung.'
                ]),

                'created_at' => Carbon::now()->subDays(rand(1, 365)), // Tanggal pembuatan acak dalam setahun terakhir
                'updated_at' => Carbon::now()->subDays(rand(0, 30)), // Tanggal update acak dalam 30 hari terakhir
            ];
        }

        // 2. Masukkan 100 data ke tabel 'medicines'
        DB::table('medicines')->insert($medicines);

        // 3. Enable kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Berhasil membuat 100 data obat!');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PopularMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder berisi 10 jenis obat paling populer di Indonesia beserta merek-merek populernya.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks dan kosongkan tabel medicines
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('medicines')->truncate();

        $medicines = [];
        $id = 1;

        // 1. Paracetamol (Pereda Demam & Nyeri)
        $paracetamols = [
            ['name' => 'Panadol 500mg', 'price' => 15000],
            ['name' => 'Panadol Extra 500mg', 'price' => 18000],
            ['name' => 'Sanmol 500mg', 'price' => 8000],
            ['name' => 'Sanmol Sirup 60ml', 'price' => 25000],
            ['name' => 'Bodrex 500mg', 'price' => 5000],
            ['name' => 'Bodrex Extra 500mg', 'price' => 7500],
            ['name' => 'Biogesic 500mg', 'price' => 12000],
            ['name' => 'Paramex 500mg', 'price' => 6000],
        ];
        foreach ($paracetamols as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Analgesik & Antipiretik', $med['price'],
                'Obat pereda demam dan nyeri ringan hingga sedang. Aman untuk dewasa dan anak-anak dengan dosis yang tepat.',
                'Digunakan untuk meredakan demam, sakit kepala, sakit gigi, nyeri otot, dan nyeri ringan lainnya. Efektif sebagai antipiretik dan analgesik.',
                'Dewasa: 500-1000mg setiap 4-6 jam (maksimal 4g/hari). Anak: sesuai berat badan. Dapat diminum sebelum atau sesudah makan.',
                'Jarang terjadi jika dosis tepat. Pada dosis tinggi: kerusakan hati, mual, muntah, reaksi alergi kulit.',
                'Hipersensitivitas terhadap paracetamol. Gangguan hati berat. Penggunaan bersamaan dengan alkohol.'
            );
        }

        // 2. Antasida (Obat Maag/Lambung)
        $antasidas = [
            ['name' => 'Promag Tablet', 'price' => 8000],
            ['name' => 'Promag Double Action', 'price' => 15000],
            ['name' => 'Mylanta Sirup 150ml', 'price' => 35000],
            ['name' => 'Mylanta Tablet Kunyah', 'price' => 12000],
            ['name' => 'Polysilane Suspensi 100ml', 'price' => 30000],
            ['name' => 'Polysilane Tablet', 'price' => 10000],
            ['name' => 'Gastrul 200mcg', 'price' => 25000],
        ];
        foreach ($antasidas as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Antasida', $med['price'],
                'Obat untuk meredakan gejala maag, kembung, dan gangguan lambung dengan menetralkan asam lambung.',
                'Mengatasi gejala dispepsia, heartburn, perut kembung, mual akibat kelebihan asam lambung, dan tukak lambung ringan.',
                'Tablet kunyah: 1-2 tablet setelah makan dan sebelum tidur. Sirup: 1-2 sendok takar. Kocok dulu sebelum diminum.',
                'Sembelit atau diare, mual, kram perut. Penggunaan jangka panjang: ketidakseimbangan elektrolit.',
                'Gagal ginjal berat, hipersensitivitas terhadap kandungan. Hati-hati pada penderita gagal jantung.'
            );
        }

        // 3. Obat Flu Kombinasi
        $fluMeds = [
            ['name' => 'Mixagrip Flu & Batuk', 'price' => 8000],
            ['name' => 'Mixagrip Kaplet', 'price' => 5000],
            ['name' => 'Decolgen Forte', 'price' => 6500],
            ['name' => 'Decolgen PE', 'price' => 7000],
            ['name' => 'Ultraflu Kaplet', 'price' => 5500],
            ['name' => 'Procold Flu & Batuk', 'price' => 6000],
            ['name' => 'Neozep Forte', 'price' => 7500],
            ['name' => 'Rhinos SR', 'price' => 12000],
        ];
        foreach ($fluMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Obat Batuk & Flu', $med['price'],
                'Obat flu kombinasi untuk meredakan gejala flu, pilek, hidung tersumbat, bersin, dan sakit kepala.',
                'Meredakan gejala flu seperti demam, sakit kepala, hidung tersumbat, bersin-bersin, dan badan pegal. Mengandung kombinasi antipiretik, dekongestan, dan antihistamin.',
                'Dewasa: 1 kaplet 3 kali sehari sesudah makan. Anak-anak: sesuai petunjuk dokter. Tidak boleh melebihi dosis yang dianjurkan.',
                'Mengantuk, mulut kering, pusing, susah tidur, jantung berdebar. Hindari mengemudi setelah minum obat ini.',
                'Hipersensitivitas, hipertensi berat, penyakit jantung koroner, glaukoma. Tidak untuk anak di bawah 6 tahun tanpa resep dokter.'
            );
        }

        // 4. Obat Batuk (Sirup & Sachet)
        $batukMeds = [
            ['name' => 'Komix Herbal', 'price' => 3000],
            ['name' => 'Komix OBH', 'price' => 3500],
            ['name' => 'OBH Combi Batuk Berdahak 100ml', 'price' => 25000],
            ['name' => 'OBH Combi Plus Flu 100ml', 'price' => 28000],
            ['name' => 'Vicks Formula 44 Dewasa 100ml', 'price' => 35000],
            ['name' => 'Vicks Formula 44 Anak 100ml', 'price' => 32000],
            ['name' => 'Bisolvon Tablet 8mg', 'price' => 15000],
            ['name' => 'Bisolvon Sirup 100ml', 'price' => 45000],
            ['name' => 'Woods Peppermint 100ml', 'price' => 20000],
        ];
        foreach ($batukMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Obat Batuk & Flu', $med['price'],
                'Obat batuk untuk meredakan batuk berdahak atau batuk kering. Tersedia dalam bentuk sirup dan sachet.',
                'Meredakan batuk berdahak dengan mengencerkan dahak (ekspektoran) atau menekan refleks batuk (antitusif). Membantu membersihkan saluran pernapasan.',
                'Sirup: 3-4 kali sehari sesuai takaran. Sachet: sobek dan minum langsung. Sebaiknya diminum sesudah makan.',
                'Mual, gangguan pencernaan, pusing. Pada penggunaan berlebihan: mengantuk berlebihan.',
                'Hipersensitivitas terhadap kandungan. Hati-hati pada penderita asma, diabetes (untuk sirup manis), dan ibu hamil trimester pertama.'
            );
        }

        // 5. Obat Masuk Angin (Herbal)
        $herbalMeds = [
            ['name' => 'Tolak Angin Cair', 'price' => 5000],
            ['name' => 'Tolak Angin Anak', 'price' => 4500],
            ['name' => 'Tolak Angin Flu', 'price' => 6000],
            ['name' => 'Antangin Cair', 'price' => 4500],
            ['name' => 'Antangin JRG', 'price' => 5000],
            ['name' => 'Bejo Jahe Merah', 'price' => 3500],
            ['name' => 'Bintang Toedjoe Masuk Angin', 'price' => 3000],
        ];
        foreach ($herbalMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Obat Herbal', $med['price'],
                'Obat herbal untuk meredakan gejala masuk angin seperti pegal, mual, kembung, dan kedinginan.',
                'Meredakan gejala masuk angin, perut kembung, mual, pegal linu, dan meriang. Menghangatkan tubuh dan membantu melancarkan pencernaan.',
                'Dewasa: 1 sachet 2-3 kali sehari. Dapat diminum langsung atau dicampur dengan air hangat.',
                'Umumnya aman karena berbahan herbal. Pada beberapa orang: rasa panas di perut, alergi terhadap kandungan herbal.',
                'Hipersensitivitas terhadap jahe atau kandungan herbal lainnya. Hati-hati pada penderita tukak lambung aktif.'
            );
        }

        // 6. Obat Diare
        $diareMeds = [
            ['name' => 'Diapet NR Kapsul', 'price' => 8000],
            ['name' => 'Diapet Sirup 60ml', 'price' => 18000],
            ['name' => 'Neo Entrostop Tablet', 'price' => 10000],
            ['name' => 'Neo Entrostop Herbal', 'price' => 12000],
            ['name' => 'New Diatabs 600mg', 'price' => 9000],
            ['name' => 'Oralit Sachet', 'price' => 2500],
            ['name' => 'Entrostop Anak', 'price' => 15000],
        ];
        foreach ($diareMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Obat Diare', $med['price'],
                'Obat untuk menghentikan diare dan mengganti cairan tubuh yang hilang. Tersedia dalam bentuk tablet, kapsul, dan sirup.',
                'Mengatasi diare akut dan kronis, menyerap racun dalam usus, menormalkan gerakan usus, dan mencegah dehidrasi.',
                'Dewasa: 2 tablet/kapsul setelah buang air besar, maksimal 8 tablet/hari. Oralit: larutkan 1 sachet dalam 200ml air matang.',
                'Sembelit jika dosis berlebihan, perut kembung, mual. Tidak menghentikan diare yang disebabkan oleh infeksi bakteri.',
                'Diare berdarah, demam tinggi, atau diare lebih dari 2 hari. Konsultasikan ke dokter jika gejala tidak membaik.'
            );
        }

        // 7. Amoxicillin (Antibiotik)
        $antibiotikMeds = [
            ['name' => 'Amoxicillin 500mg Generik', 'price' => 5000],
            ['name' => 'Amoxicillin 250mg Generik', 'price' => 3500],
            ['name' => 'Amoxsan 500mg', 'price' => 12000],
            ['name' => 'Amoxsan Sirup 60ml', 'price' => 35000],
            ['name' => 'Kimoxil 500mg', 'price' => 8000],
            ['name' => 'Ospamox 500mg', 'price' => 15000],
            ['name' => 'Kalmoxillin 500mg', 'price' => 7500],
        ];
        foreach ($antibiotikMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Antibiotik', $med['price'],
                'Antibiotik golongan penisilin untuk mengobati infeksi bakteri. HARUS dengan resep dokter.',
                'Mengobati infeksi saluran pernapasan atas dan bawah, infeksi saluran kemih, infeksi kulit, infeksi telinga, dan infeksi gigi. Membunuh bakteri penyebab infeksi.',
                'Dewasa: 250-500mg setiap 8 jam selama 7-10 hari. WAJIB dihabiskan sesuai resep dokter untuk mencegah resistensi antibiotik.',
                'Diare, mual, ruam kulit, reaksi alergi. Pada kasus serius: syok anafilaksis (segera ke IGD).',
                'Alergi terhadap penisilin atau antibiotik beta-laktam. Riwayat reaksi anafilaksis. Konsultasikan dengan dokter sebelum menggunakan.'
            );
        }

        // 8. Multivitamin & Suplemen Imunitas
        $vitaminMeds = [
            ['name' => 'Enervon-C Tablet', 'price' => 15000],
            ['name' => 'Enervon-C Effervescent', 'price' => 25000],
            ['name' => 'Imboost Force Tablet', 'price' => 45000],
            ['name' => 'Imboost Kids Sirup 60ml', 'price' => 55000],
            ['name' => 'Redoxon Triple Action', 'price' => 85000],
            ['name' => 'Redoxon Vitamin C 1000mg', 'price' => 65000],
            ['name' => 'Becom-C Kaplet', 'price' => 20000],
            ['name' => 'Hemaviton C1000 Botol', 'price' => 8000],
            ['name' => 'You C 1000 Vitamin C', 'price' => 7500],
        ];
        foreach ($vitaminMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Suplemen Vitamin', $med['price'],
                'Suplemen vitamin dan mineral untuk meningkatkan daya tahan tubuh dan menjaga kesehatan secara keseluruhan.',
                'Membantu meningkatkan sistem imun, mencegah kekurangan vitamin C dan B kompleks, membantu pemulihan setelah sakit, dan menjaga stamina.',
                'Tablet: 1 tablet 1 kali sehari. Effervescent: larutkan 1 tablet dalam segelas air. Sebaiknya diminum pagi hari.',
                'Umumnya aman. Dosis berlebihan vitamin C: gangguan pencernaan, diare. Urin berwarna kuning pekat (normal).',
                'Hipersensitivitas terhadap kandungan. Pasien dengan batu ginjal (untuk vitamin C dosis tinggi). Konsultasikan dengan dokter jika sedang mengonsumsi obat lain.'
            );
        }

        // 9. CTM & Cetirizine (Obat Alergi)
        $alergiMeds = [
            ['name' => 'CTM 4mg Generik', 'price' => 2000],
            ['name' => 'Cetirizine 10mg Generik', 'price' => 5000],
            ['name' => 'Incidal-OD 10mg', 'price' => 35000],
            ['name' => 'Ryzen 10mg', 'price' => 25000],
            ['name' => 'Loratadine 10mg Generik', 'price' => 8000],
            ['name' => 'Claritin 10mg', 'price' => 45000],
            ['name' => 'Alergine 4mg', 'price' => 12000],
        ];
        foreach ($alergiMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Antihistamin', $med['price'],
                'Obat antihistamin untuk mengatasi reaksi alergi seperti gatal, biduran, bersin, dan hidung tersumbat akibat alergi.',
                'Meredakan gejala alergi seperti gatal-gatal, biduran, rhinitis alergi, bersin-bersin, mata berair, dan reaksi alergi kulit.',
                'CTM: 1 tablet 3-4 kali sehari (menyebabkan kantuk). Cetirizine/Loratadine: 1 tablet 1 kali sehari (kurang mengantuk).',
                'CTM: sangat mengantuk, mulut kering, penglihatan kabur. Cetirizine: sedikit mengantuk, sakit kepala, mulut kering.',
                'Hipersensitivitas. Hati-hati pada glaukoma, pembesaran prostat, retensi urin. Hindari mengemudi setelah minum CTM.'
            );
        }

        // 10. Asam Mefenamat (Pereda Nyeri Kuat)
        $nyeriMeds = [
            ['name' => 'Ponstan 500mg', 'price' => 8000],
            ['name' => 'Mefinal 500mg', 'price' => 6000],
            ['name' => 'Asam Mefenamat 500mg Generik', 'price' => 3500],
            ['name' => 'Opistan 500mg', 'price' => 5500],
            ['name' => 'Mefinter 500mg', 'price' => 4500],
            ['name' => 'Dentacid 500mg', 'price' => 7000],
            ['name' => 'Nichostan 500mg', 'price' => 5000],
        ];
        foreach ($nyeriMeds as $med) {
            $medicines[] = $this->createMedicine($id++, $med['name'], 'Analgesik & Antipiretik', $med['price'],
                'Obat anti-inflamasi non-steroid (OAINS) untuk meredakan nyeri sedang hingga berat seperti sakit gigi dan nyeri haid.',
                'Meredakan nyeri ringan hingga sedang seperti sakit gigi, sakit kepala, nyeri haid (dismenore), nyeri pasca operasi, dan nyeri otot.',
                'Dewasa: 500mg 3 kali sehari sesudah makan. Jangan digunakan lebih dari 7 hari tanpa pengawasan dokter.',
                'Gangguan pencernaan, mual, diare, pusing, ruam kulit. Penggunaan jangka panjang: risiko tukak lambung dan perdarahan saluran cerna.',
                'Tukak lambung aktif, perdarahan saluran cerna, gangguan ginjal atau hati berat, alergi terhadap OAINS atau aspirin, kehamilan trimester ketiga.'
            );
        }

        // Insert semua data ke database
        DB::table('medicines')->insert($medicines);

        // Enable kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Berhasil membuat ' . count($medicines) . ' data obat populer Indonesia!');
    }

    /**
     * Helper function untuk membuat array medicine
     */
    private function createMedicine($id, $name, $category, $price, $description, $fullIndication, $usageDetail, $sideEffects, $contraindications)
    {
        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . $id),
            'category' => $category,
            'price' => $price,
            'stock' => rand(20, 150),
            'total_sold' => rand(10, 500),
            'image' => null,
            'description' => $description,
            'full_indication' => $fullIndication,
            'usage_detail' => $usageDetail,
            'side_effects' => $sideEffects,
            'contraindications' => $contraindications,
            'created_at' => Carbon::now()->subDays(rand(30, 365)),
            'updated_at' => Carbon::now()->subDays(rand(0, 30)),
        ];
    }
}

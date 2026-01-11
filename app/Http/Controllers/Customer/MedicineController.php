<?php

namespace App\Http\Controllers\Customer; // Perhatikan namespace baru Anda

use App\Http\Controllers\Controller;
use App\Models\Medicine; // Menggunakan Model Drug yang sudah kita buat
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Menampilkan daftar obat, termasuk fungsi pencarian dan filter.
     * Diasumsikan ini digunakan untuk halaman utama (index/home).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori unik dari database untuk dropdown filter
        // TELAH DIKOREKSI: Menggunakan Model Drug::
        $categories = Medicine::select('category')
            ->distinct()
            ->pluck('category')
            ->filter() // Hapus nilai null jika ada
            ->toArray();

        // 2. Query dasar: Ambil semua data obat
        $query = Medicine::query();

        // 3. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('indication', 'LIKE', '%' . $searchTerm . '%');
        }

        // 4. Logika Filter Kategori
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        // 5. Ambil data obat yang sudah difilter dan paginasi (15 item per halaman)
        $medicines = $query->paginate(15)->withQueryString();

        // Karena view Anda menggunakan $item->slug dan $item->description,
        // kita perlu memodifikasi koleksi untuk menambahkan kolom ini
        // (atau Anda bisa menambahkannya ke Migration/Seeder yang lebih disarankan).
        $medicines->getCollection()->transform(function ($item) {
            $item->description = $item->indication; // Menggunakan 'indication' sebagai 'description'
            $item->slug = strtolower(str_replace(' ', '-', $item->name)); // Membuat slug sederhana

            // Jika Anda memiliki kolom 'image' di seeder, ini akan berfungsi
            // $item->image = 'placeholder.jpg'; // Hapus ini jika Anda punya gambar asli

            return $item;
        });

        // 6. WAJIB: Mengembalikan view dengan data yang diperlukan
        return view('customer.index', compact('medicines', 'categories'));
    }
}

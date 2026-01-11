<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori unik dari database untuk dropdown filter
        $categories = Medicine::select('category')
            ->distinct()
            ->pluck('category')
            ->map(fn($c) => trim($c))
            ->filter(fn($c) => !empty($c))
            ->unique()
            ->values()
            ->toArray();

        // 2. Query dasar: Ambil semua data obat
        $query = Medicine::query();

        // 3. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // 4. Logika Filter Kategori
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        // 5. Ambil data obat yang sudah difilter dan paginasi (15 item per halaman)
        $medicines = $query->paginate(15)->withQueryString();

        // KARENA DATA SUDAH ADA DI KOLOM 'description', HANYA PERLU MENAMBAH SLUG
        $medicines->getCollection()->transform(function ($item) {
            // Tambahkan slug
            $item->slug = strtolower(str_replace(' ', '-', $item->name));

            return $item;
        });

        // 6. WAJIB: Mengembalikan view dengan data yang diperlukan
        return view('customer.index', compact('medicines', 'categories'));
    }

    /**
     * Menampilkan halaman detail obat berdasarkan slug.
     */
    public function show($id)
    {
        // Cari obat berdasarkan slug, jika tidak ditemukan, tampilkan 404
        $medicine = Medicine::where('id', $id)->firstOrFail();

        // Di sini kita bisa menambahkan logika untuk mengisi informasi detail yang lebih lengkap
        // (Contoh: cara penggunaan, efek samping, dll) yang mungkin tidak ada di kolom description.
        // Karena di seeder kita tidak punya kolom spesifik untuk 'cara_penggunaan',
        // kita buat mock data sederhana. Jika Anda punya kolom di DB, gunakan kolom itu.
        return view('customer.show', compact('medicine'));
    }

    public function about()
    {
        return view('customer.about');
    }

    public function services()
    {
        return view('customer.services');
    }
}

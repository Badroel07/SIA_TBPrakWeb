<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrudMedicineController extends Controller
{
    /**
     * Menampilkan daftar semua obat dengan fitur pencarian dan filter (INDEX).
     * Dipanggil oleh route admin.medicines.index atau admin.dashboard
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Medicine::query();

        // Logika Filter Kategori (HARUS SEBELUM SEARCH)
        if ($request->filled('category')) {
            $categoryFilter = $request->input('category');

            // Hanya terapkan filter jika nilainya BUKAN 'all'
            if ($categoryFilter !== 'all') {
                $query->where('category', $categoryFilter);
            }
        }

        // Logika Pencarian (setelah kategori)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        // --- AKHIR PERUBAHAN ---

        // Logika Sorting
        $sortBy = $request->input('sort_by', 'created_at'); // Default: created_at (Latest)
        $sortOrder = $request->input('sort_order', 'desc'); // Default: desc

        $validSortFields = ['name', 'stock', 'created_at', 'price'];
        $validSortOrders = ['asc', 'desc'];

        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortOrder, $validSortOrders)) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        // Ambil data (15 item per halaman)
        $medicines = $query->paginate(15)->withQueryString();

        // Ambil semua kategori unik untuk filter dropdown
        $categories = Medicine::select('category')
            ->distinct()
            ->pluck('category')
            ->map(fn($c) => trim($c))
            ->filter(fn($c) => !empty($c))
            ->unique()
            ->values();

        $existingCategories = Medicine::select('category')
            ->distinct()
            ->pluck('category')
            ->map(fn($c) => trim($c))
            ->filter(fn($c) => !empty($c))
            ->unique()
            ->values()
            ->toArray();

        // Pastikan view CRUD index dipanggil
        return view('admin.medicine.index', compact('medicines', 'categories', 'existingCategories'));
    }

    public function create()
    {
        // Ambil semua kategori unik, sama seperti di index
        $existingCategories = Medicine::distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        // Render view create.blade.php dengan variabel yang dibutuhkan
        return view('admin.medicine.create', compact('existingCategories'));
    }

    /**
     * Menampilkan formulir untuk membuat data obat baru (CREATE).
     * Dipanggil oleh route admin.medicines.create
     */

    /**
     * Menyimpan data obat baru (termasuk upload gambar) (STORE).
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (tetap sama)
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:medicines,name',
            'category' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'full_indication' => 'required|string',
            'usage_detail' => 'required|string',
            'side_effects' => 'required|string',
            'contraindications' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
        }

        $slug = Str::slug($request->name);

        $medicine = Medicine::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'full_indication' => $request->full_indication,
            'usage_detail' => $request->usage_detail,
            'side_effects' => $request->side_effects,
            'contraindications' => $request->contraindications,
            'image' => $imagePath,
            'total_sold' => 0,
        ]);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil ditambahkan!',
                'data' => $medicine
            ]);
        }

        // PERBAIKAN: Menggunakan route admin.medicines.index
        return redirect()->route('admin.medicines.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    /**
     * Memperbarui data obat dan stok (UPDATE).
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:medicines,name,' . $medicine->id,
            'category' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'stock_adjustment' => 'nullable|integer', // Kolom untuk menambah/mengurangi stok
            'description' => 'required|string',
            'full_indication' => 'required|string',
            'usage_detail' => 'required|string',
            'side_effects' => 'required|string',
            'contraindications' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'stock_adjustment', 'image', 'stock_reason']);
        $originalStock = $medicine->stock;

        if ($request->filled('stock_adjustment')) {
            $adjustment = (int) $request->stock_adjustment;
            $data['stock'] = $originalStock + $adjustment;



            if ($data['stock'] < 0) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok yang dikurangi melebihi stok tersedia!'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Stok yang dikurangi melebihi stok tersedia!');
            }
        } elseif ($request->filled('stock_manual')) {
            // FITUR BARU: Update Initial Stock / Set Stok Manual
            $data['stock'] = (int) $request->stock_manual;
        }

        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil diperbarui!',
                'data' => $medicine->fresh()
            ]);
        }

        return redirect()->route('admin.medicines.index')->with('success', 'Data obat berhasil diperbarui!');
    }
    /**
     * Menghapus data obat (DELETE).
     */
    public function destroy(Request $request, Medicine $medicine)
    {
        // Hapus file gambar lama jika ada
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil dihapus!'
            ]);
        }

        // PERBAIKAN: Menggunakan route admin.medicines.index
        return redirect()->back()->with('success', 'Data obat berhasil dihapus!');
    }

    public function detail($id)
    {
        $medicine = Medicine::findOrFail($id);

        // 1. Hitung URL di sisi server (PHP)
        $imageUrl = $medicine->image
            ? Storage::disk('public')->url($medicine->image)
            : null;

        return response()->json([
            'id' => $medicine->id,
            'name' => $medicine->name,
            'category' => $medicine->category,
            'price' => $medicine->price,
            'stock' => $medicine->stock,
            'total_sold' => $medicine->total_sold ?? 0,
            'image' => $imageUrl,
            // 'image' => $medicine->image,
            'description' => $medicine->description,
            'full_indication' => $medicine->full_indication,
            'usage_detail' => $medicine->usage_detail,
            'side_effects' => $medicine->side_effects,
            'contraindications' => $medicine->contraindications,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan model User diimport
use Illuminate\Support\Facades\Hash; // <-- Untuk hashing password
// use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query dasar untuk mengambil data User
        $query = User::query();

        // 2. Logika Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
        }

        // 3. Logika Filter Role
        if ($request->filled('role')) {
            $roleFilter = $request->input('role');
            $query->where('role', $roleFilter);
        }

        // 4. Ambil data User dengan pagination (10 item per halaman)
        // Gunakan withQueryString() untuk mempertahankan parameter URL saat pagination
        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // 5. Ambil daftar role unik dari tabel users
        // Menggunakan select('role')->distinct() untuk mendapatkan nilai role unik saja.
        // pluck('role') mengubah hasil menjadi array sederhana.
        $roles = User::select('role')
            ->distinct()
            ->pluck('role');

        // 6. Lewatkan $users DAN $roles ke view
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        // Ambil daftar role yang tersedia dari Model User
        $availableRoles = User::getAvailableRoles();

        return view('admin.users.create', compact('availableRoles'));
    }

    public function store(Request $request)
    {
        $availableRoles = ['admin', 'cashier', 'customer'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', $availableRoles),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', "Pengguna **{$user->name}** berhasil ditambahkan!");
    }

    public function edit(User $user)
    {
        $availableRoles = User::getAvailableRoles();
        return view('admin.users.edit', compact('user', 'availableRoles'));
    }

    public function update(Request $request, User $user)
    {
        $availableRoles = ['admin', 'cashier', 'customer'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', $availableRoles),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', "User **{$user->name}** updated successfully!");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "User **{$user->name}** deleted successfully!");
    }
}

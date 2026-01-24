<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // =========================================================================
    // MANAJEMEN USER
    // =========================================================================
    public function index(Request $request) {
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,konsultan,keuangan,klien',
            'no_telepon' => 'nullable|string'
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,konsultan,keuangan,klien',
            'no_telepon' => 'nullable'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Data user diperbarui.');
    }

    public function destroy(User $user) {
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }

    // =========================================================================
    // MANAJEMEN PAKET (HARGA)
    // =========================================================================
    public function paketIndex() {
        $pakets = Paket::all();
        return view('admin.paket.index', compact('pakets'));
    }

    public function paketUpdate(Request $request, $id) {
        $paket = Paket::findOrFail($id);
        $data = $request->validate([
            'nama_paket' => 'required|string',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        $paket->update($data);
        return back()->with('success', 'Harga paket berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Hanya menampilkan Admin dan Kepsek, karena Guru dan Siswa punya menu sendiri
        $users = User::whereIn('role', ['admin', 'kepsek'])->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,kepsek'
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        
        ActivityLog::log('create', 'user', "Menambahkan user baru: {$user->username} (Role: {$user->role})");

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Cegah edit user role lain lewat form ini (guru/siswa)
        if (!in_array($user->role, ['admin', 'kepsek'])) {
            return redirect()->route('admin.user.index')->with('error', 'User guru atau siswa harus diedit melalui menu master masing-masing.');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!in_array($user->role, ['admin', 'kepsek'])) {
            return redirect()->route('admin.user.index')->with('error', 'User guru atau siswa harus diedit melalui menu master masing-masing.');
        }

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'role' => 'required|in:admin,kepsek'
        ]);

        $oldUsername = $user->username;

        $updateData = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'role' => $request->role
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
            ActivityLog::log('update', 'user', "Reset password untuk user: {$request->username}");
        }

        $user->update($updateData);

        if ($oldUsername !== $user->username) {
            ActivityLog::log('update', 'user', "Mengubah username dari {$oldUsername} menjadi {$user->username}");
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah hapus admin terakhir atau user sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        if (!in_array($user->role, ['admin', 'kepsek'])) {
            return redirect()->route('admin.user.index')->with('error', 'User guru atau siswa harus dihapus melalui menu master masing-masing.');
        }

        try {
            $username = $user->username;
            $user->delete();
            ActivityLog::log('delete', 'user', "Menghapus user: {$username}");
            return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Gagal menghapus user.');
        }
    }
}

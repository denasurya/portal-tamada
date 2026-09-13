<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\ActivityLog;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('admin.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jurusans,nama'
        ]);

        $jurusan = Jurusan::create($request->all());
        
        ActivityLog::log('create', 'jurusan', "Menambahkan jurusan baru: {$jurusan->nama}");

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:jurusans,nama,' . $jurusan->id
        ]);

        $oldName = $jurusan->nama;
        $jurusan->update($request->all());

        ActivityLog::log('update', 'jurusan', "Mengubah jurusan {$oldName} menjadi {$jurusan->nama}");

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        try {
            $name = $jurusan->nama;
            $jurusan->delete();
            ActivityLog::log('delete', 'jurusan', "Menghapus jurusan: {$name}");
            return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.jurusan.index')->with('error', 'Gagal menghapus jurusan. Pastikan tidak ada rombel yang terikat dengan jurusan ini.');
        }
    }
}

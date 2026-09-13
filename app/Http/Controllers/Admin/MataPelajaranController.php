<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\ActivityLog;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::all();
        return view('admin.mapel.index', compact('mapels'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:mata_pelajarans,kode',
            'nama' => 'required|string|max:255'
        ]);

        $mapel = MataPelajaran::create($request->all());
        
        ActivityLog::log('create', 'mapel', "Menambahkan mata pelajaran baru: [{$mapel->kode}] {$mapel->nama}");

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mapel)
    {
        return view('admin.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:mata_pelajarans,kode,' . $mapel->id,
            'nama' => 'required|string|max:255'
        ]);

        $oldName = $mapel->nama;
        $mapel->update($request->all());

        ActivityLog::log('update', 'mapel', "Mengubah mata pelajaran {$oldName} menjadi {$mapel->nama}");

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mapel)
    {
        try {
            $name = $mapel->nama;
            $mapel->delete();
            ActivityLog::log('delete', 'mapel', "Menghapus mata pelajaran: {$name}");
            return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.mapel.index')->with('error', 'Gagal menghapus Mata Pelajaran. Pastikan tidak ada penugasan guru yang terkait.');
        }
    }
}

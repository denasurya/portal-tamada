<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\ActivityLog;

class RombelController extends Controller
{
    public function index()
    {
        $rombels = Rombel::with('jurusan')->get();
        return view('admin.rombel.index', compact('rombels'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.rombel.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:rombels,nama',
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $rombel = Rombel::create($request->all());
        
        ActivityLog::log('create', 'rombel', "Menambahkan rombel baru: {$rombel->nama}");

        return redirect()->route('admin.rombel.index')->with('success', 'Rombel berhasil ditambahkan.');
    }

    public function edit(Rombel $rombel)
    {
        $jurusans = Jurusan::all();
        return view('admin.rombel.edit', compact('rombel', 'jurusans'));
    }

    public function update(Request $request, Rombel $rombel)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:rombels,nama,' . $rombel->id,
            'jurusan_id' => 'required|exists:jurusans,id'
        ]);

        $oldName = $rombel->nama;
        $rombel->update($request->all());

        ActivityLog::log('update', 'rombel', "Mengubah rombel {$oldName} menjadi {$rombel->nama}");

        return redirect()->route('admin.rombel.index')->with('success', 'Rombel berhasil diperbarui.');
    }

    public function destroy(Rombel $rombel)
    {
        try {
            $name = $rombel->nama;
            $rombel->delete();
            ActivityLog::log('delete', 'rombel', "Menghapus rombel: {$name}");
            return redirect()->route('admin.rombel.index')->with('success', 'Rombel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.rombel.index')->with('error', 'Gagal menghapus rombel. Pastikan tidak ada data siswa atau penugasan yang terkait.');
        }
    }
}

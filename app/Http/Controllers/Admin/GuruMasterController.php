<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use App\Models\GuruMapel;
use App\Models\PenugasanRombel;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruMasterController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user', 'guru_mapels.mata_pelajaran', 'guru_mapels.penugasan_rombels.rombel')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_guru' => 'required|string|max:20|unique:gurus,kode_guru',
            'nama_guru' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6'
        ]);

        DB::transaction(function () use ($request) {
            // Create user
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'guru'
            ]);

            // Create guru
            $guru = Guru::create([
                'user_id' => $user->id,
                'kode_guru' => $request->kode_guru,
                'nama_guru' => $request->nama_guru,
            ]);

            ActivityLog::log('create', 'guru', "Menambahkan guru baru: {$guru->nama_guru}");
        });

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        // For assigning mapel and rombel
        $guru->load('guru_mapels.mata_pelajaran', 'guru_mapels.penugasan_rombels.rombel');
        $mapels = MataPelajaran::all();
        $rombels = Rombel::with('jurusan')->get();
        
        return view('admin.guru.show', compact('guru', 'mapels', 'rombels'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'kode_guru' => 'required|string|max:20|unique:gurus,kode_guru,' . $guru->id,
            'nama_guru' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $guru->user_id,
        ]);

        DB::transaction(function () use ($request, $guru) {
            $guru->user->update([
                'username' => $request->username,
            ]);

            if ($request->filled('password')) {
                $guru->user->update(['password' => Hash::make($request->password)]);
                ActivityLog::log('update', 'guru', "Admin reset password guru {$guru->nama_guru}");
            }

            $guru->update([
                'kode_guru' => $request->kode_guru,
                'nama_guru' => $request->nama_guru,
            ]);

            ActivityLog::log('update', 'guru', "Update data biodata guru {$guru->nama_guru}");
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        try {
            DB::transaction(function () use ($guru) {
                $name = $guru->nama_guru;
                $user = $guru->user;
                $guru->delete();
                if ($user) $user->delete();
                ActivityLog::log('delete', 'guru', "Menghapus guru: {$name}");
            });
            return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')->with('error', 'Gagal menghapus guru. Pastikan tidak ada sesi les yang terkait.');
        }
    }

    // Penugasan Mapel & Rombel
    public function assignMapel(Request $request, Guru $guru)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id'
        ]);

        GuruMapel::firstOrCreate([
            'guru_id' => $guru->id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id
        ]);

        ActivityLog::log('assign', 'guru', "Assign mapel ID {$request->mata_pelajaran_id} ke guru {$guru->nama_guru}");

        return redirect()->route('admin.guru.show', $guru->id)->with('success', 'Mata Pelajaran berhasil ditugaskan.');
    }

    public function removeMapel(Guru $guru, GuruMapel $guruMapel)
    {
        if ($guruMapel->guru_id === $guru->id) {
            $guruMapel->delete();
            ActivityLog::log('remove_assign', 'guru', "Remove mapel ID {$guruMapel->mata_pelajaran_id} dari guru {$guru->nama_guru}");
        }
        return redirect()->route('admin.guru.show', $guru->id)->with('success', 'Tugas Mapel berhasil dihapus.');
    }

    public function assignRombel(Request $request, Guru $guru, GuruMapel $guruMapel)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id'
        ]);

        if ($guruMapel->guru_id === $guru->id) {
            PenugasanRombel::firstOrCreate([
                'guru_mapel_id' => $guruMapel->id,
                'rombel_id' => $request->rombel_id
            ]);
            ActivityLog::log('assign', 'guru', "Assign rombel ID {$request->rombel_id} ke guru {$guru->nama_guru} untuk mapel ID {$guruMapel->mata_pelajaran_id}");
        }

        return redirect()->route('admin.guru.show', $guru->id)->with('success', 'Rombel berhasil ditugaskan.');
    }

    public function removeRombel(Guru $guru, GuruMapel $guruMapel, PenugasanRombel $penugasanRombel)
    {
        if ($penugasanRombel->guru_mapel_id === $guruMapel->id && $guruMapel->guru_id === $guru->id) {
            $penugasanRombel->delete();
            ActivityLog::log('remove_assign', 'guru', "Remove rombel ID {$penugasanRombel->rombel_id} dari guru {$guru->nama_guru}");
        }
        return redirect()->route('admin.guru.show', $guru->id)->with('success', 'Tugas Rombel berhasil dihapus.');
    }
}

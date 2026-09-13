<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Rombel;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        // Add pagination since there could be hundreds of students
        $siswas = Siswa::with('user', 'rombel.jurusan')->paginate(50);
        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $rombels = Rombel::all();
        return view('admin.siswa.create', compact('rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:siswas,nisn',
            'nama' => 'required|string|max:255',
            'rombel_id' => 'required|exists:rombels,id',
            'password' => 'required|string|min:6'
        ]);

        DB::transaction(function () use ($request) {
            // Create user
            $user = User::create([
                'username' => $request->nisn, // NISN is used as username for students
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);

            // Create siswa
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'rombel_id' => $request->rombel_id,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
            ]);

            ActivityLog::log('create', 'siswa', "Menambahkan siswa baru: {$siswa->nama} ({$siswa->nisn})");
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $rombels = Rombel::all();
        return view('admin.siswa.edit', compact('siswa', 'rombels'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'rombel_id' => 'required|exists:rombels,id'
        ]);

        DB::transaction(function () use ($request, $siswa) {
            // Update User username if NISN changed
            if ($request->nisn !== $siswa->nisn) {
                $siswa->user->update(['username' => $request->nisn]);
            }

            if ($request->filled('password')) {
                $siswa->user->update(['password' => Hash::make($request->password)]);
                ActivityLog::log('update', 'siswa', "Admin reset password siswa {$siswa->nama}");
            }

            $siswa->update([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'rombel_id' => $request->rombel_id,
            ]);

            ActivityLog::log('update', 'siswa', "Update data biodata siswa {$siswa->nama}");
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        try {
            DB::transaction(function () use ($siswa) {
                $name = $siswa->nama;
                $user = $siswa->user;
                $siswa->delete();
                if ($user) $user->delete();
                ActivityLog::log('delete', 'siswa', "Menghapus siswa: {$name}");
            });
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal menghapus siswa. Pastikan tidak ada data kehadiran terkait.');
        }
    }

    // ============================================
    // FITUR IMPORT CSV
    // ============================================
    public function showImportForm()
    {
        return view('admin.siswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048',
            'default_password' => 'required|string|min:6'
        ]);

        $file = $request->file('file_csv');
        
        $handle = fopen($file->getPathname(), "r");
        $header = fgetcsv($handle, 1000, ",");
        
        // Cek header dasar
        if (!$header || count($header) < 3) {
            return back()->with('error', 'Format CSV tidak valid. Harus ada NISN, Nama, dan Kelas.');
        }

        $imported = 0;
        $failed = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Skip baris kosong
                if (!isset($data[0]) || empty($data[0])) continue;

                $nisn = trim($data[0]);
                $nama = trim($data[1]);
                $kelasName = trim($data[2]);

                // Cari rombel
                $rombel = Rombel::where('nama', $kelasName)->first();
                if (!$rombel) {
                    $failed++;
                    $errors[] = "Baris NISN {$nisn}: Kelas '{$kelasName}' tidak ditemukan di database.";
                    continue;
                }

                // Cek existing
                if (Siswa::where('nisn', $nisn)->exists()) {
                    $failed++;
                    $errors[] = "Baris NISN {$nisn}: Sudah ada di database.";
                    continue;
                }

                // Create user & siswa
                $user = User::create([
                    'username' => $nisn,
                    'password' => Hash::make($request->default_password),
                    'role' => 'siswa'
                ]);

                Siswa::create([
                    'user_id' => $user->id,
                    'rombel_id' => $rombel->id,
                    'nisn' => $nisn,
                    'nama' => $nama,
                ]);

                $imported++;
            }
            DB::commit();
            
            ActivityLog::log('import', 'siswa', "Mengimport {$imported} siswa baru.");
            
            if ($failed > 0) {
                return redirect()->route('admin.siswa.index')->with('success', "Import selesai: {$imported} berhasil, {$failed} gagal. Detail: " . implode(', ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? '...' : ''));
            }

            return redirect()->route('admin.siswa.index')->with('success', "Berhasil mengimport {$imported} siswa.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}

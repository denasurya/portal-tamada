<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiLes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SesiController extends Controller
{
    /**
     * Tampilkan daftar semua sesi.
     */
    public function index(Request $request)
    {
        $query = SesiLes::with(['guru', 'mata_pelajaran', 'sesi_les_rombels.rombel']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Cari berdasarkan nama mapel atau nama guru
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mata_pelajaran', function($qMapel) use ($search) {
                    $qMapel->where('nama', 'like', "%{$search}%");
                })->orWhereHas('guru', function($qGuru) use ($search) {
                    $qGuru->where('nama_guru', 'like', "%{$search}%");
                });
            });
        }

        $sesis = $query->orderBy('created_at', 'desc')->paginate(15)->appends(request()->query());

        return view('admin.sesi.index', compact('sesis'));
    }

    /**
     * Hapus sebuah sesi beserta relasinya (dan file bukti jika ada).
     */
    public function destroy($id)
    {
        $sesi = SesiLes::findOrFail($id);

        try {
            DB::beginTransaction();

            // 1. Hapus file foto bukti pelaksanaan jika ada
            if ($sesi->bukti_path && Storage::disk('public')->exists($sesi->bukti_path)) {
                Storage::disk('public')->delete($sesi->bukti_path);
            }

            // 2. Hapus data sesi
            $sesi->sesi_les_rombels()->delete();
            $sesi->absensi_siswas()->delete();
            $sesi->delete();

            DB::commit();

            return redirect()->route('admin.sesi.index')->with('success', 'Histori sesi percobaan berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.sesi.index')->with('error', 'Gagal menghapus sesi: ' . $e->getMessage());
        }
    }
}

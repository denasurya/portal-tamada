<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiLes;
use App\Models\AbsensiSiswa;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // =========================================================
    // DASHBOARD SISWA
    // =========================================================

    public function dashboard()
    {
        $siswa    = Auth::user()->siswa;
        $rombel_id = $siswa->rombel_id;

        // Hanya tampilkan sesi yang ditujukan ke rombel siswa ini
        $sesi_aktif = SesiLes::where('status', 'berjalan')
            ->whereHas('sesi_les_rombels', function ($q) use ($rombel_id) {
                $q->where('rombel_id', $rombel_id);
            })
            ->with([
                'guru',
                'mata_pelajaran',
                'sesi_les_rombels.rombel',
                'absensi_siswas' => function ($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                },
            ])
            ->get();

        // Histori sesi yang sudah selesai
        $histori = SesiLes::where('status', 'selesai')
            ->whereHas('sesi_les_rombels', function ($q) use ($rombel_id) {
                $q->where('rombel_id', $rombel_id);
            })
            ->with([
                'guru',
                'mata_pelajaran',
                'absensi_siswas' => function ($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                },
            ])
            ->orderBy('waktu_mulai', 'desc')
            ->limit(10)
            ->get();

        return view('siswa.dashboard', compact('siswa', 'sesi_aktif', 'histori'));
    }

    // =========================================================
    // KONFIRMASI KEHADIRAN SISWA
    // =========================================================

    /**
     * Siswa mengonfirmasi kehadirannya setelah guru mencatatnya.
     * Semua validasi dilakukan di BACKEND — tidak bisa dimanipulasi dari frontend.
     */
    public function konfirmasi(Request $request, $sesiId)
    {
        $siswa = Auth::user()->siswa;

        // 1. Validasi: sesi ada dan masih berjalan
        $sesi = SesiLes::where('id', $sesiId)
            ->where('status', 'berjalan')
            ->with('sesi_les_rombels')
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak ditemukan atau sudah selesai.',
            ], 403);
        }

        // 2. Validasi: siswa ini memang bagian dari rombel target sesi
        $rombelIds = $sesi->sesi_les_rombels->pluck('rombel_id');
        if (!$rombelIds->contains($siswa->rombel_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak termasuk dalam rombel target sesi ini.',
            ], 403);
        }

        // 3. Cek record absensi — guru harus sudah mencatat dulu
        $absensi = AbsensiSiswa::where('sesi_les_id', $sesiId)
            ->where('siswa_id', $siswa->id)
            ->first();

        if (!$absensi || $absensi->status !== 'menunggu_konfirmasi') {
            $message = 'Guru belum mencatat kehadiran Anda.';
            if ($absensi && $absensi->status === 'hadir_valid') {
                $message = 'Anda sudah melakukan konfirmasi kehadiran.';
            }
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        // 4. Validasi: belum pernah konfirmasi (double-check)
        if ($absensi->confirmed_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan konfirmasi kehadiran.',
            ], 403);
        }

        // 5. Semua valid → update ke HADIR VALID
        $absensi->update([
            'status'       => 'hadir_valid',
            'confirmed_at' => now(),
        ]);

        // Ambil stats terbaru untuk response
        $sesi->load('sesi_les_rombels.rombel.siswas', 'absensi_siswas');
        $stats = $sesi->getAbsensiStats();

        return response()->json([
            'success'  => true,
            'message'  => '✓ Kehadiran berhasil dikonfirmasi!',
            'status'   => 'hadir_valid',
            'stats'    => $stats,
        ]);
    }

    /**
     * AJAX: Ambil status absensi siswa saat ini untuk polling
     */
    public function getStatus(Request $request, $sesiId)
    {
        $siswa = Auth::user()->siswa;

        // Validasi sesi ada untuk rombel siswa ini
        $sesi = SesiLes::where('id', $sesiId)
            ->whereHas('sesi_les_rombels', function ($q) use ($siswa) {
                $q->where('rombel_id', $siswa->rombel_id);
            })
            ->first();

        if (!$sesi) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak ditemukan.'], 404);
        }

        $absensi = AbsensiSiswa::where('sesi_les_id', $sesiId)
            ->where('siswa_id', $siswa->id)
            ->first();

        return response()->json([
            'success'      => true,
            'status'       => $absensi ? $absensi->status : 'belum_diabsen',
            'sesi_status'  => $sesi->status,
            'confirmed_at' => $absensi?->confirmed_at?->format('H:i'),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiLes;
use App\Models\GuruMapel;
use App\Models\PenugasanRombel;
use App\Models\SesiLesRombel;
use App\Models\AbsensiSiswa;
use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SesiLesController extends Controller
{
    // =========================================================
    // DASHBOARD GURU
    // =========================================================

    public function dashboard()
    {
        $guru = Auth::user()->guru;
        $sesi_aktif = SesiLes::where('guru_id', $guru->id)
            ->where('status', 'berjalan')
            ->with([
                'mata_pelajaran',
                'sesi_les_rombels.rombel.siswas',
                'absensi_siswas.siswa'
            ])
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        // Hitung statistik per sesi
        foreach ($sesi_aktif as $sesi) {
            $sesi->stats = $sesi->getAbsensiStats();

            // Build daftar siswa per rombel dengan status absensi
            $sesi->daftar_rombel = $this->buildDaftarSiswaPerRombel($sesi);
        }

        $histori = SesiLes::where('guru_id', $guru->id)
            ->where('status', 'selesai')
            ->with(['mata_pelajaran', 'sesi_les_rombels.rombel'])
            ->orderBy('waktu_mulai', 'desc')
            ->limit(10)
            ->get();
            
        // Stats for Dashboard UI
        $total_sesi_bulan_ini = SesiLes::where('guru_id', $guru->id)
            ->whereMonth('waktu_mulai', date('m'))
            ->whereYear('waktu_mulai', date('Y'))
            ->count();
            
        $total_siswa = \App\Models\Siswa::whereHas('rombel.penugasans.guru_mapel', function($q) use($guru) {
            $q->where('guru_id', $guru->id);
        })->count();
        
        $total_sesi_selesai = SesiLes::where('guru_id', $guru->id)->where('status', 'selesai')->count();
        $total_semua_sesi = SesiLes::where('guru_id', $guru->id)->count();
        $persentase_selesai = $total_semua_sesi > 0 ? round(($total_sesi_selesai / $total_semua_sesi) * 100) : 0;
        
        $total_sesi_berjalan = $sesi_aktif->count();

        return view('guru.dashboard', compact(
            'guru', 'sesi_aktif', 'histori', 
            'total_sesi_bulan_ini', 'total_siswa', 
            'total_sesi_selesai', 'persentase_selesai', 'total_sesi_berjalan'
        ));
    }

    /**
     * Build daftar siswa per rombel dengan status absensi mereka
     */
    private function buildDaftarSiswaPerRombel(SesiLes $sesi): array
    {
        $absensi_map = $sesi->absensi_siswas->keyBy('siswa_id');
        $daftar = [];

        foreach ($sesi->sesi_les_rombels as $slr) {
            $rombel = $slr->rombel;
            $siswa_list = [];

            foreach ($rombel->siswas as $siswa) {
                $absensi = $absensi_map->get($siswa->id);
                $siswa_list[] = [
                    'id'     => $siswa->id,
                    'nama'   => $siswa->nama,
                    'status' => $absensi ? $absensi->status : 'belum_diabsen',
                ];
            }

            $daftar[] = [
                'rombel_id'   => $rombel->id,
                'rombel_nama' => $rombel->nama,
                'siswa'       => $siswa_list,
            ];
        }

        return $daftar;
    }

    // =========================================================
    // BUAT SESI
    // =========================================================

    public function create()
    {
        $guru  = Auth::user()->guru;
        $mapels = $guru->guru_mapels()->with('mata_pelajaran')->get();
        return view('guru.sesi_les.create', compact('mapels', 'guru'));
    }

    public function getRombel(Request $request)
    {
        $guruMapel = GuruMapel::where('guru_id', Auth::user()->guru->id)
            ->where('mata_pelajaran_id', $request->mapel_id)
            ->first();

        if (!$guruMapel) return response()->json([]);

        $rombels = PenugasanRombel::where('guru_mapel_id', $guruMapel->id)
            ->with('rombel')
            ->get();

        return response()->json($rombels);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel_id'  => 'required|exists:mata_pelajarans,id',
            'materi'    => 'required|string|max:255',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,txt|max:10240',
            'gmeet_link' => 'nullable|url',
            'rombels'   => 'required|array|min:1',
            'rombels.*' => 'exists:rombels,id',
        ]);

        $guru = Auth::user()->guru;

        // Validasi: guru memang berhak mengajar mapel ini
        $guruMapel = GuruMapel::where('guru_id', $guru->id)
            ->where('mata_pelajaran_id', $request->mapel_id)
            ->first();

        if (!$guruMapel) {
            return back()->withErrors(['mapel_id' => 'Anda tidak berhak mengajar mata pelajaran ini.']);
        }

        // Validasi: rombel yang dipilih memang penugasan guru ini
        $validRombelIds = PenugasanRombel::where('guru_mapel_id', $guruMapel->id)
            ->pluck('rombel_id')
            ->toArray();

        foreach ($request->rombels as $rombel_id) {
            if (!in_array($rombel_id, $validRombelIds)) {
                return back()->withErrors(['rombels' => 'Rombel yang dipilih tidak sesuai penugasan Anda.']);
            }
        }

        $file_materi_path = null;
        if ($request->hasFile('file_materi')) {
            $file_materi_path = $request->file('file_materi')->store('materi_sesi', 'public');
        }

        $sesi = SesiLes::create([
            'guru_id'          => $guru->id,
            'mata_pelajaran_id' => $request->mapel_id,
            'materi'           => $request->materi,
            'file_materi'      => $file_materi_path,
            'gmeet_link'       => $request->gmeet_link,
            'status'           => 'berjalan',
            'waktu_mulai'      => now(),
        ]);

        foreach ($request->rombels as $rombel_id) {
            SesiLesRombel::create([
                'sesi_les_id' => $sesi->id,
                'rombel_id'   => $rombel_id,
            ]);
        }

        return redirect()->route('guru.dashboard')
            ->with('success', 'Sesi berhasil dibuat dan dimulai.');
    }

    // =========================================================
    // ABSENSI: GURU MENANDAI SISWA HADIR
    // =========================================================

    /**
     * Guru mencentang siswa atau menekan tombol Sakit/Izin
     * AJAX endpoint — status bergantung payload
     */
    public function markStatus(Request $request, $sesiId, $siswaId)
    {
        $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,sakit,izin,belum_diabsen'
        ]);

        $guru = Auth::user()->guru;

        // Validasi sesi milik guru ini
        $sesi = SesiLes::where('id', $sesiId)
            ->where('guru_id', $guru->id)
            ->where('status', 'berjalan')
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak ditemukan atau sudah selesai.'
            ], 403);
        }

        // Validasi siswa memang bagian dari rombel target sesi ini
        $rombelIds = $sesi->sesi_les_rombels()->pluck('rombel_id');
        $siswa = Siswa::where('id', $siswaId)
            ->whereIn('rombel_id', $rombelIds)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak termasuk dalam rombel target sesi ini.'
            ], 403);
        }

        $targetStatus = $request->status;

        // Cari atau buat record absensi
        $absensi = AbsensiSiswa::where('sesi_les_id', $sesiId)
            ->where('siswa_id', $siswaId)
            ->first();

        if ($absensi && $absensi->status === 'hadir_valid') {
            return response()->json([
                'success' => true,
                'status'  => 'hadir_valid',
                'message' => 'Siswa sudah konfirmasi kehadiran.',
            ]);
        }

        if ($targetStatus === 'belum_diabsen') {
            if ($absensi) {
                $absensi->delete();
            }
        } else {
            AbsensiSiswa::updateOrCreate(
                [
                    'sesi_les_id' => $sesiId,
                    'siswa_id'    => $siswaId,
                ],
                [
                    'status'          => $targetStatus,
                    'dicatat_guru_at' => now(),
                    'confirmed_at'    => null, // reset confirmed if changed manually
                ]
            );
        }

        // Ambil stats terbaru
        $sesi->load('sesi_les_rombels.rombel.siswas', 'absensi_siswas');
        $stats = $sesi->getAbsensiStats();

        return response()->json([
            'success' => true,
            'status'  => $targetStatus,
            'message' => 'Status absensi berhasil diperbarui.',
            'stats'   => $stats,
        ]);
    }

    /**
     * AJAX: Ambil status absensi terkini untuk polling real-time di halaman guru
     */
    public function getAbsensiStatus(Request $request, $sesiId)
    {
        $guru = Auth::user()->guru;

        $sesi = SesiLes::where('id', $sesiId)
            ->where('guru_id', $guru->id)
            ->with([
                'sesi_les_rombels.rombel.siswas',
                'absensi_siswas.siswa',
            ])
            ->first();

        if (!$sesi) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak ditemukan.'], 404);
        }

        $stats = $sesi->getAbsensiStats();
        $daftar_rombel = $this->buildDaftarSiswaPerRombel($sesi);

        return response()->json([
            'success'       => true,
            'stats'         => $stats,
            'daftar_rombel' => $daftar_rombel,
            'sesi_status'   => $sesi->status,
        ]);
    }

    // =========================================================
    // UPLOAD BUKTI MENGAJAR
    // =========================================================

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $sesi = SesiLes::where('id', $id)
            ->where('guru_id', Auth::user()->guru->id)
            ->firstOrFail();

        $path = $request->file('bukti')->store('bukti_mengajar', 'public');
        $sesi->update(['bukti_path' => $path]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bukti mengajar berhasil diupload.'
            ]);
        }

        return redirect(route('guru.dashboard') . '#sesi-card-' . $id)->with('success', 'Bukti mengajar berhasil diupload.');
    }

    // =========================================================
    // SELESAIKAN SESI
    // =========================================================

    public function finishSession(Request $request, $id)
    {
        $sesi = SesiLes::where('id', $id)
            ->where('guru_id', Auth::user()->guru->id)
            ->where('status', 'berjalan')
            ->with('sesi_les_rombels.rombel.siswas')
            ->firstOrFail();

        DB::transaction(function () use ($sesi) {
            // Kumpulkan semua siswa dari rombel target
            $allSiswaIds = collect();
            foreach ($sesi->sesi_les_rombels as $slr) {
                $allSiswaIds = $allSiswaIds->concat($slr->rombel->siswas->pluck('id'));
            }
            $allSiswaIds = $allSiswaIds->unique();

            // Siswa yang sudah punya record absensi
            $existingAbsensiIds = AbsensiSiswa::where('sesi_les_id', $sesi->id)
                ->pluck('siswa_id')
                ->toArray();

            // Siswa yang BELUM DIABSEN SAMA SEKALI → tidak_hadir
            $tidakHadirIds = $allSiswaIds->filter(function ($id) use ($existingAbsensiIds) {
                return !in_array($id, $existingAbsensiIds);
            });

            foreach ($tidakHadirIds as $siswaId) {
                AbsensiSiswa::create([
                    'sesi_les_id' => $sesi->id,
                    'siswa_id'    => $siswaId,
                    'status'      => 'tidak_hadir',
                ]);
            }

            // Siswa yang MENUNGGU KONFIRMASI (guru tandai tapi siswa belum konfirmasi) → tidak_konfirmasi
            AbsensiSiswa::where('sesi_les_id', $sesi->id)
                ->where('status', 'menunggu_konfirmasi')
                ->update(['status' => 'tidak_konfirmasi']);

            // Jika ada yang tersimpan sebagai belum_diabsen di DB, ubah jadi tidak_hadir
            AbsensiSiswa::where('sesi_les_id', $sesi->id)
                ->where('status', 'belum_diabsen')
                ->update(['status' => 'tidak_hadir']);

            // Update status sesi
            $sesi->update([
                'status'        => 'selesai',
                'waktu_selesai' => now(),
            ]);
        });

        return back()->with('success', 'Sesi berhasil diselesaikan.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SesiLes;

class KepsekController extends Controller
{
    public function dashboard()
    {
        $sesi_aktif = $this->getSesiAktifData();
        return view('kepsek.dashboard', compact('sesi_aktif'));
    }

    /**
     * AJAX endpoint untuk polling real-time dari Kepsek dashboard
     */
    public function getStats()
    {
        $sesi_aktif = $this->getSesiAktifData();
        return response()->json([
            'success'    => true,
            'sesi_aktif' => $sesi_aktif,
        ]);
    }

    /**
     * Ambil data sesi aktif beserta statistik 4-status per rombel
     */
    private function getSesiAktifData(): array
    {
        $sesi_list = SesiLes::where('status', 'berjalan')
            ->with([
                'guru',
                'mata_pelajaran',
                'sesi_les_rombels.rombel.siswas',
                'absensi_siswas',
            ])
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        $result = [];

        foreach ($sesi_list as $sesi) {
            $absensi_by_status = $sesi->absensi_siswas->groupBy('status');

            // Statistik per rombel
            $rombel_stats = [];
            foreach ($sesi->sesi_les_rombels as $slr) {
                $rombel = $slr->rombel;
                $total_rombel = $rombel->siswas->count();

                // Absensi khusus siswa di rombel ini
                $siswa_ids = $rombel->siswas->pluck('id');
                $absensi_rombel = $sesi->absensi_siswas->whereIn('siswa_id', $siswa_ids);

                $hadir_valid   = $absensi_rombel->where('status', 'hadir_valid')->count();
                $menunggu      = $absensi_rombel->where('status', 'menunggu_konfirmasi')->count();
                $tidak_hadir   = $absensi_rombel->where('status', 'tidak_hadir')->count();
                $belum_diabsen = $total_rombel - $hadir_valid - $menunggu - $tidak_hadir;
                $belum_diabsen = max(0, $belum_diabsen);

                $persentase = $total_rombel > 0
                    ? round(($hadir_valid / $total_rombel) * 100, 2)
                    : 0;

                $rombel_stats[] = [
                    'rombel_id'          => $rombel->id,
                    'rombel_nama'        => $rombel->nama,
                    'total_siswa'        => $total_rombel,
                    'hadir_valid'        => $hadir_valid,
                    'menunggu_konfirmasi' => $menunggu,
                    'belum_diabsen'      => $belum_diabsen,
                    'tidak_hadir'        => $tidak_hadir,
                    'persentase'         => $persentase,
                ];
            }

            // Statistik total sesi
            $total_expected = collect($rombel_stats)->sum('total_siswa');
            $total_hadir    = collect($rombel_stats)->sum('hadir_valid');
            $total_menunggu = collect($rombel_stats)->sum('menunggu_konfirmasi');
            $total_belum    = collect($rombel_stats)->sum('belum_diabsen');
            $total_tidak_hadir = collect($rombel_stats)->sum('tidak_hadir');
            $total_sudah    = $total_expected - $total_belum;
            $persentase_total = $total_expected > 0
                ? round(($total_hadir / $total_expected) * 100, 2)
                : 0;

            $result[] = [
                'id'                 => $sesi->id,
                'mata_pelajaran'     => $sesi->mata_pelajaran->nama,
                'guru'               => $sesi->guru->nama_guru,
                'materi'             => $sesi->materi,
                'gmeet_link'         => $sesi->gmeet_link,
                'bukti_path'         => $sesi->bukti_path,
                'waktu_mulai'        => $sesi->waktu_mulai->format('H:i'),
                'waktu_mulai_full'   => $sesi->waktu_mulai->format('d/m/Y H:i'),
                'rombels'            => $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', '),
                'status'             => $sesi->status,
                'total_expected'     => $total_expected,
                'hadir_valid'        => $total_hadir,
                'menunggu_konfirmasi' => $total_menunggu,
                'belum_diabsen'      => $total_belum,
                'tidak_hadir'        => $total_tidak_hadir,
                'sudah_diabsen'      => $total_sudah,
                'persentase'         => $persentase_total,
                'rombel_stats'       => $rombel_stats,
            ];
        }

        return $result;
    }
}

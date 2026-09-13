<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiLes;
use App\Models\AbsensiSiswa;
use App\Exports\AbsensiSesiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriController extends Controller
{
    public function index(Request $request)
    {
        $guruId = auth()->user()->guru->id;
        
        $query = SesiLes::with(['mata_pelajaran', 'sesi_les_rombels.rombel'])
            ->where('guru_id', $guruId);

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('waktu_mulai', '>=', $request->start_date)
                  ->whereDate('waktu_mulai', '<=', $request->end_date);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('waktu_mulai', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('waktu_mulai', '<=', $request->end_date);
        }

        // Filter Mapel
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        // Filter Rombel (melalui relasi)
        if ($request->filled('rombel_id')) {
            $query->whereHas('sesi_les_rombels', function ($q) use ($request) {
                $q->where('rombel_id', $request->rombel_id);
            });
        }

        // Default urutan sesi terbaru
        $sesis = $query->orderBy('waktu_mulai', 'desc')
                       ->paginate(10)
                       ->appends($request->query());

        // Ambil data untuk opsi filter
        $mapels = \App\Models\MataPelajaran::orderBy('nama')->get();
        $rombels = \App\Models\Rombel::orderBy('nama')->get();

        return view('guru.histori.index', compact('sesis', 'mapels', 'rombels'));
    }

    public function show(Request $request, SesiLes $sesi)
    {
        // AUTHORIZATION: Pastikan sesi ini milik guru yang login
        if ($sesi->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Anda tidak diizinkan mengakses histori sesi ini.');
        }

        // Eager load relasi penting
        $sesi->load(['mata_pelajaran', 'sesi_les_rombels.rombel']);

        // Data Statistik
        $stats = $sesi->getAbsensiStats();

        // Data Absensi Siswa
        $absensiQuery = $sesi->absensi_siswas()->with('siswa.rombel');

        // Filter Absensi Rombel
        if ($request->filled('filter_rombel_id')) {
            $absensiQuery->whereHas('siswa', function ($q) use ($request) {
                $q->where('rombel_id', $request->filter_rombel_id);
            });
        }

        // Filter Absensi Status
        if ($request->filled('filter_status')) {
            $absensiQuery->where('status', $request->filter_status);
        }

        // Filter Cari Nama
        if ($request->filled('search_nama')) {
            $absensiQuery->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search_nama . '%');
            });
        }

        $absensis = $absensiQuery->get();
        
        // Data Rekap per Rombel
        $rekapRombel = [];
        foreach ($sesi->sesi_les_rombels as $slr) {
            $rombel = $slr->rombel;
            $siswaIds = $rombel->siswas()->pluck('id')->toArray();
            
            // Hitung statistik per rombel
            $rombelAbsensi = $sesi->absensi_siswas()->whereIn('siswa_id', $siswaIds)->get();
            
            $total_siswa = count($siswaIds);
            $hadir_valid = $rombelAbsensi->where('status', 'hadir_valid')->count();
            $sakit = $rombelAbsensi->where('status', 'sakit')->count();
            $izin = $rombelAbsensi->where('status', 'izin')->count();
            $tidak_konfirmasi = $rombelAbsensi->where('status', 'tidak_konfirmasi')->count();
            $tidak_hadir = $rombelAbsensi->where('status', 'tidak_hadir')->count();
            
            $persentase = $total_siswa > 0 ? round(($hadir_valid / $total_siswa) * 100, 2) : 0;
            
            $rekapRombel[] = [
                'nama_rombel' => $rombel->nama,
                'total_siswa' => $total_siswa,
                'hadir_valid' => $hadir_valid,
                'sakit'       => $sakit,
                'izin'        => $izin,
                'tidak_konfirmasi' => $tidak_konfirmasi,
                'tidak_hadir' => $tidak_hadir,
                'persentase'  => $persentase
            ];
        }

        return view('guru.histori.show', compact('sesi', 'stats', 'absensis', 'rekapRombel'));
    }

    public function downloadExcel(SesiLes $sesi)
    {
        if ($sesi->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Akses ditolak.');
        }

        $namaFile = 'absensi-' . strtolower(str_replace(' ', '-', $sesi->mata_pelajaran->nama)) . '-' . $sesi->waktu_mulai->format('Y-m-d') . '.xlsx';
        return Excel::download(new AbsensiSesiExport($sesi), $namaFile);
    }

    public function downloadPdf(SesiLes $sesi)
    {
        if ($sesi->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Akses ditolak.');
        }

        $sesi->load(['mata_pelajaran', 'guru', 'absensi_siswas.siswa.rombel', 'sesi_les_rombels.rombel']);
        $stats = $sesi->getAbsensiStats();
        
        $pdf = Pdf::loadView('guru.histori.pdf', compact('sesi', 'stats'));
        $pdf->setPaper('A4', 'portrait');
        
        $namaFile = 'absensi-' . strtolower(str_replace(' ', '-', $sesi->mata_pelajaran->nama)) . '-' . $sesi->waktu_mulai->format('Y-m-d') . '.pdf';
        return $pdf->download($namaFile);
    }
}

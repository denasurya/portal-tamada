<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SesiLes extends Model {
    protected $guarded = [];
    protected $casts = [
        'waktu_mulai'   => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function guru()           { return $this->belongsTo(Guru::class); }
    public function mata_pelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function sesi_les_rombels() { return $this->hasMany(SesiLesRombel::class); }
    public function absensi_siswas() { return $this->hasMany(AbsensiSiswa::class); }

    /**
     * Hitung total siswa yang seharusnya hadir (dari semua rombel target sesi)
     */
    public function getTotalExpected(): int {
        $total = 0;
        foreach ($this->sesi_les_rombels as $slr) {
            $total += $slr->rombel->siswas()->count();
        }
        return $total;
    }

    /**
     * Ambil statistik absensi sesi ini
     * Return: array [total, hadir_valid, menunggu_konfirmasi, izin, sakit, tidak_konfirmasi, belum_diabsen]
     */
    public function getAbsensiStats(): array {
        $total_expected = $this->getTotalExpected();

        $absensi_counts = $this->absensi_siswas()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $hadir_valid         = $absensi_counts['hadir_valid'] ?? 0;
        $menunggu_konfirmasi = $absensi_counts['menunggu_konfirmasi'] ?? 0;
        $izin                = $absensi_counts['izin'] ?? 0;
        $sakit               = $absensi_counts['sakit'] ?? 0;
        $tidak_konfirmasi    = $absensi_counts['tidak_konfirmasi'] ?? 0;
        $tidak_hadir_db      = $absensi_counts['tidak_hadir'] ?? 0;
        
        // Siswa yang sama sekali belum disentuh (tidak ada di tabel absensi_siswas, ATAU berstatus belum_diabsen)
        $belum_diabsen_db = $absensi_counts['belum_diabsen'] ?? 0;
        $sudah_ada_di_db = array_sum($absensi_counts);
        $tidak_ada_di_db = max(0, $total_expected - $sudah_ada_di_db);
        
        $tidak_hadir_total = $tidak_hadir_db + $belum_diabsen_db + $tidak_ada_di_db;

        $persentase = $total_expected > 0
            ? round(($hadir_valid / $total_expected) * 100, 2)
            : 0;

        return [
            'total_expected'      => $total_expected,
            'hadir_valid'         => $hadir_valid,
            'menunggu_konfirmasi' => $menunggu_konfirmasi,
            'izin'                => $izin,
            'sakit'               => $sakit,
            'tidak_konfirmasi'    => $tidak_konfirmasi,
            'tidak_hadir'         => $tidak_hadir_total,
            'persentase'          => $persentase,
        ];
    }
}
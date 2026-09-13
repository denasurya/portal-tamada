<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model {
    protected $guarded = [];
    protected $casts = [
        'dicatat_guru_at' => 'datetime',
        'confirmed_at'    => 'datetime',
    ];

    public function sesi_les() { return $this->belongsTo(SesiLes::class); }
    public function siswa()    { return $this->belongsTo(Siswa::class); }

    // Helper: sudah konfirmasi (hadir valid)
    public function isHadirValid(): bool {
        return $this->status === 'hadir_valid';
    }

    // Helper: menunggu konfirmasi siswa
    public function isMenungguKonfirmasi(): bool {
        return $this->status === 'menunggu_konfirmasi';
    }

    // Helper: guru sudah mencatat (menunggu atau sudah valid)
    public function isSudahDicatatGuru(): bool {
        return in_array($this->status, ['menunggu_konfirmasi', 'hadir_valid']);
    }
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model {
    protected $guarded = [];
    public function guru() { return $this->belongsTo(Guru::class); }
    public function mata_pelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function penugasan_rombels() { return $this->hasMany(PenugasanRombel::class); }
}
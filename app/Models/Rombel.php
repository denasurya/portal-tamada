<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model {
    protected $guarded = [];
    public function jurusan() { return $this->belongsTo(Jurusan::class); }
    public function siswas() { return $this->hasMany(Siswa::class); }
    public function penugasans() { return $this->hasMany(PenugasanRombel::class); }
}
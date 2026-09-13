<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
    protected $guarded = [];
    public function rombel() { return $this->belongsTo(Rombel::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function absensis() { return $this->hasMany(AbsensiSiswa::class); }
}
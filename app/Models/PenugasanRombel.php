<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenugasanRombel extends Model {
    protected $guarded = [];
    public function guru_mapel() { return $this->belongsTo(GuruMapel::class); }
    public function rombel() { return $this->belongsTo(Rombel::class); }
}
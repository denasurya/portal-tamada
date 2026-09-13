<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SesiLesRombel extends Model {
    protected $guarded = [];
    public function sesi_les() { return $this->belongsTo(SesiLes::class); }
    public function rombel() { return $this->belongsTo(Rombel::class); }
}
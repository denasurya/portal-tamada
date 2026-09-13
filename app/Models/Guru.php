<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function guru_mapels() { return $this->hasMany(GuruMapel::class); }
    public function sesi_les() { return $this->hasMany(SesiLes::class); }
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model {
    protected $guarded = [];
    public function rombels() { return $this->hasMany(Rombel::class); }
}
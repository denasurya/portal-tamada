<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model {
    protected $guarded = [];
    public function guru_mapels() { return $this->hasMany(GuruMapel::class); }
}
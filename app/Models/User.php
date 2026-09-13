<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
    
    public function siswa() { return $this->hasOne(Siswa::class); }
    public function guru() { return $this->hasOne(Guru::class); }
}
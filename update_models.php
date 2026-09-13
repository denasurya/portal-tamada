<?php
$models = glob(__DIR__ . '/app/Models/*.php');

$schemas = [
    'User' => <<<'PHP'
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
PHP,
    'Jurusan' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model {
    protected $guarded = [];
    public function rombels() { return $this->hasMany(Rombel::class); }
}
PHP,
    'Rombel' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model {
    protected $guarded = [];
    public function jurusan() { return $this->belongsTo(Jurusan::class); }
    public function siswas() { return $this->hasMany(Siswa::class); }
    public function penugasans() { return $this->hasMany(PenugasanRombel::class); }
}
PHP,
    'Siswa' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
    protected $guarded = [];
    public function rombel() { return $this->belongsTo(Rombel::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function absensis() { return $this->hasMany(AbsensiSiswa::class); }
}
PHP,
    'MataPelajaran' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model {
    protected $guarded = [];
    public function guru_mapels() { return $this->hasMany(GuruMapel::class); }
}
PHP,
    'Guru' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function guru_mapels() { return $this->hasMany(GuruMapel::class); }
    public function sesi_les() { return $this->hasMany(SesiLes::class); }
}
PHP,
    'GuruMapel' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model {
    protected $guarded = [];
    public function guru() { return $this->belongsTo(Guru::class); }
    public function mata_pelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function penugasan_rombels() { return $this->hasMany(PenugasanRombel::class); }
}
PHP,
    'PenugasanRombel' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenugasanRombel extends Model {
    protected $guarded = [];
    public function guru_mapel() { return $this->belongsTo(GuruMapel::class); }
    public function rombel() { return $this->belongsTo(Rombel::class); }
}
PHP,
    'SesiLes' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SesiLes extends Model {
    protected $guarded = [];
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];
    public function guru() { return $this->belongsTo(Guru::class); }
    public function mata_pelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function sesi_les_rombels() { return $this->hasMany(SesiLesRombel::class); }
    public function absensi_siswas() { return $this->hasMany(AbsensiSiswa::class); }
}
PHP,
    'SesiLesRombel' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SesiLesRombel extends Model {
    protected $guarded = [];
    public function sesi_les() { return $this->belongsTo(SesiLes::class); }
    public function rombel() { return $this->belongsTo(Rombel::class); }
}
PHP,
    'AbsensiSiswa' => <<<'PHP'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model {
    protected $guarded = [];
    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];
    public function sesi_les() { return $this->belongsTo(SesiLes::class); }
    public function siswa() { return $this->belongsTo(Siswa::class); }
}
PHP
];

foreach ($models as $file) {
    $basename = basename($file, '.php');
    if (isset($schemas[$basename])) {
        file_put_contents($file, $schemas[$basename]);
        echo "Updated: $basename\n";
    }
}

<?php
$migrations = glob(__DIR__ . '/database/migrations/*.php');

$schemas = [
    'create_users_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // NISN for siswa, kode_guru/username for guru
            $table->string('password');
            $table->enum('role', ['siswa', 'guru', 'staff', 'kepsek', 'admin']);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
PHP,
    'create_jurusans_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('jurusans'); }
};
PHP,
    'create_rombels_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->string('nama')->unique();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rombels'); }
};
PHP,
    'create_siswas_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->string('nisn', 20)->unique();
            $table->string('nama');
            $table->string('jk', 5);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siswas'); }
};
PHP,
    'create_mata_pelajarans_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mata_pelajarans'); }
};
PHP,
    'create_gurus_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('kode_guru', 20)->unique();
            $table->string('nama_guru');
            $table->string('status_data')->default('AKTIF');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('gurus'); }
};
PHP,
    'create_guru_mapels_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('guru_mapels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('guru_mapels'); }
};
PHP,
    'create_penugasan_rombels_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('penugasan_rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_mapel_id')->constrained('guru_mapels')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('penugasan_rombels'); }
};
PHP,
    'create_sesi_les_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('sesi_les', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->string('materi');
            $table->string('gmeet_link')->nullable();
            $table->string('pin_masuk', 10)->nullable();
            $table->string('pin_keluar', 10)->nullable();
            $table->enum('status', ['berjalan', 'selesai'])->default('berjalan');
            $table->string('bukti_path')->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sesi_les'); }
};
PHP,
    'create_sesi_les_rombels_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('sesi_les_rombels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_les_id')->constrained('sesi_les')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sesi_les_rombels'); }
};
PHP,
    'create_absensi_siswas_table' => <<<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('absensi_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_les_id')->constrained('sesi_les')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->enum('status', ['Hadir Sebagian', 'Hadir Penuh', 'ALPA'])->default('ALPA');
            $table->dateTime('waktu_masuk')->nullable();
            $table->dateTime('waktu_keluar')->nullable();
            $table->unique(['sesi_les_id', 'siswa_id']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('absensi_siswas'); }
};
PHP
];

foreach ($migrations as $file) {
    foreach ($schemas as $key => $content) {
        if (strpos($file, $key) !== false) {
            file_put_contents($file, $content);
            echo "Updated: " . basename($file) . "\n";
            break;
        }
    }
}

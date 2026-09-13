<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * REVISI ABSENSI: Hapus sistem PIN masuk/keluar lama.
     * Ganti dengan sistem Validasi Dua Pihak:
     *   guru mencatat -> siswa konfirmasi -> HADIR VALID
     */
    public function up(): void
    {
        // 1. Disable foreign key checks, hapus data lama dengan urutan yang benar
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('absensi_siswas')->truncate();
        DB::table('sesi_les_rombels')->truncate();
        DB::table('sesi_les')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 3. Modifikasi tabel sesi_les: hapus pin_masuk dan pin_keluar
        Schema::table('sesi_les', function (Blueprint $table) {
            $table->dropColumn(['pin_masuk', 'pin_keluar']);
        });

        // 4. Modifikasi tabel absensi_siswas: ganti struktur status
        Schema::table('absensi_siswas', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['waktu_masuk', 'waktu_keluar', 'status']);
        });

        Schema::table('absensi_siswas', function (Blueprint $table) {
            // Tambah kolom baru
            $table->enum('status', [
                'belum_diabsen',
                'menunggu_konfirmasi',
                'hadir_valid',
                'tidak_hadir'
            ])->default('belum_diabsen')->after('siswa_id');

            // Waktu guru mencatat siswa hadir
            $table->dateTime('dicatat_guru_at')->nullable()->after('status');

            // Waktu siswa melakukan konfirmasi
            $table->dateTime('confirmed_at')->nullable()->after('dicatat_guru_at');
        });
    }

    public function down(): void
    {
        // Restore sesi_les PIN columns
        Schema::table('sesi_les', function (Blueprint $table) {
            $table->string('pin_masuk', 10)->nullable();
            $table->string('pin_keluar', 10)->nullable();
        });

        // Restore absensi_siswas old structure
        Schema::table('absensi_siswas', function (Blueprint $table) {
            $table->dropColumn(['status', 'dicatat_guru_at', 'confirmed_at']);
        });

        Schema::table('absensi_siswas', function (Blueprint $table) {
            $table->enum('status', ['Hadir Sebagian', 'Hadir Penuh', 'ALPA'])->default('ALPA');
            $table->dateTime('waktu_masuk')->nullable();
            $table->dateTime('waktu_keluar')->nullable();
        });
    }
};

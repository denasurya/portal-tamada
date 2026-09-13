<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE absensi_siswas MODIFY COLUMN status ENUM('belum_diabsen','menunggu_konfirmasi','hadir_valid','tidak_hadir','sakit','izin','tidak_konfirmasi') NOT NULL DEFAULT 'belum_diabsen'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE absensi_siswas MODIFY COLUMN status ENUM('belum_diabsen','menunggu_konfirmasi','hadir_valid','tidak_hadir') NOT NULL DEFAULT 'belum_diabsen'");
    }
};

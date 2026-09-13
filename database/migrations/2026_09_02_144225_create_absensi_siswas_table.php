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
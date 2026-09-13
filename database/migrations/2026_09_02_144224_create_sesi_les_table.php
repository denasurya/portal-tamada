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
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
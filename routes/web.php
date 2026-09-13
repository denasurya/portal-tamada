<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================
// SISWA ROUTES
// =========================================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Siswa\AbsensiController::class, 'dashboard'])->name('dashboard');

    // Konfirmasi kehadiran (menggantikan check-in/check-out)
    Route::post('/konfirmasi/{sesiId}', [\App\Http\Controllers\Siswa\AbsensiController::class, 'konfirmasi'])->name('konfirmasi');

    // AJAX: polling status absensi
    Route::get('/status/{sesiId}', [\App\Http\Controllers\Siswa\AbsensiController::class, 'getStatus'])->name('status');
});

// =========================================================
// GURU ROUTES
// =========================================================
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Guru\SesiLesController::class, 'dashboard'])->name('dashboard');

    // Tambahan rute untuk menu yang diminta
    Route::view('/sesi-les', 'guru.sesi_les.index')->name('sesi-les.index');
    Route::get('/penugasan', [\App\Http\Controllers\Guru\PenugasanController::class, 'index'])->name('penugasan');
    Route::view('/profil', 'guru.profil')->name('profil');

    // Buat sesi
    Route::get('/sesi-les/create', [\App\Http\Controllers\Guru\SesiLesController::class, 'create'])->name('sesi-les.create');
    Route::post('/sesi-les', [\App\Http\Controllers\Guru\SesiLesController::class, 'store'])->name('sesi-les.store');
    Route::get('/sesi-les/get-rombel', [\App\Http\Controllers\Guru\SesiLesController::class, 'getRombel'])->name('sesi-les.get-rombel');

    // Upload bukti dan selesaikan sesi
    Route::post('/sesi-les/{id}/upload-bukti', [\App\Http\Controllers\Guru\SesiLesController::class, 'uploadBukti'])->name('sesi-les.upload-bukti');
    Route::post('/sesi-les/{id}/finish', [\App\Http\Controllers\Guru\SesiLesController::class, 'finishSession'])->name('sesi-les.finish');

    // ABSENSI: Guru menandai siswa hadir (AJAX)
    Route::post('/sesi-les/{sesiId}/mark-status/{siswaId}', [\App\Http\Controllers\Guru\SesiLesController::class, 'markStatus'])->name('sesi-les.mark-status');

    // AJAX: polling status absensi sesi
    Route::get('/sesi-les/{sesiId}/absensi-status', [\App\Http\Controllers\Guru\SesiLesController::class, 'getAbsensiStatus'])->name('sesi-les.absensi-status');

    // HISTORI SESI GURU
    Route::get('/histori', [\App\Http\Controllers\Guru\HistoriController::class, 'index'])->name('histori.index');
    Route::get('/histori/{sesi}', [\App\Http\Controllers\Guru\HistoriController::class, 'show'])->name('histori.show');
    Route::get('/histori/{sesi}/download/excel', [\App\Http\Controllers\Guru\HistoriController::class, 'downloadExcel'])->name('histori.download.excel');
    Route::get('/histori/{sesi}/download/pdf', [\App\Http\Controllers\Guru\HistoriController::class, 'downloadPdf'])->name('histori.download.pdf');
});

// =========================================================
// KEPSEK ROUTES
// =========================================================
Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\KepsekController::class, 'dashboard'])->name('dashboard');

    // AJAX: polling real-time stats
    Route::get('/stats', [\App\Http\Controllers\KepsekController::class, 'getStats'])->name('stats');

    // Histori Sesi
    Route::get('/histori', [\App\Http\Controllers\Kepsek\HistoriController::class, 'index'])->name('histori.index');
    Route::get('/histori/{sesi}', [\App\Http\Controllers\Kepsek\HistoriController::class, 'show'])->name('histori.show');
    Route::get('/histori/{sesi}/download/excel', [\App\Http\Controllers\Kepsek\HistoriController::class, 'downloadExcel'])->name('histori.download.excel');
    Route::get('/histori/{sesi}/download/pdf', [\App\Http\Controllers\Kepsek\HistoriController::class, 'downloadPdf'])->name('histori.download.pdf');
});

// =========================================================
// ADMIN ROUTES
// =========================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data
    Route::resource('jurusan', \App\Http\Controllers\Admin\JurusanController::class)->except(['show']);
    Route::resource('rombel', \App\Http\Controllers\Admin\RombelController::class)->except(['show']);
    Route::resource('mapel', \App\Http\Controllers\Admin\MataPelajaranController::class)->except(['show']);
    
    // Master Guru & Penugasan
    Route::resource('guru', \App\Http\Controllers\Admin\GuruMasterController::class);
    Route::post('/guru/{guru}/assign-mapel', [\App\Http\Controllers\Admin\GuruMasterController::class, 'assignMapel'])->name('guru.assign-mapel');
    Route::delete('/guru/{guru}/remove-mapel/{guruMapel}', [\App\Http\Controllers\Admin\GuruMasterController::class, 'removeMapel'])->name('guru.remove-mapel');
    Route::post('/guru/{guru}/mapel/{guruMapel}/assign-rombel', [\App\Http\Controllers\Admin\GuruMasterController::class, 'assignRombel'])->name('guru.assign-rombel');
    Route::delete('/guru/{guru}/mapel/{guruMapel}/remove-rombel/{penugasanRombel}', [\App\Http\Controllers\Admin\GuruMasterController::class, 'removeRombel'])->name('guru.remove-rombel');

    // Master Siswa & Import
    Route::get('/siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'showImportForm'])->name('siswa.import');
    Route::post('/siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'import'])->name('siswa.import.process');
    Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class)->except(['show']);

    // User Management
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->except(['show']);

    // System Settings & Logs
    Route::get('/system/activity-log', [\App\Http\Controllers\Admin\SystemController::class, 'activityLog'])->name('system.activity_log');
    Route::get('/system/settings', [\App\Http\Controllers\Admin\SystemController::class, 'settings'])->name('system.settings');
    Route::post('/system/settings', [\App\Http\Controllers\Admin\SystemController::class, 'updateSettings'])->name('system.settings.update');

    // Manajemen Sesi
    Route::resource('sesi', \App\Http\Controllers\Admin\SesiController::class)->only(['index', 'destroy']);
});

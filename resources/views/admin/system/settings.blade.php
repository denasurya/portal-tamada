@extends('layouts.admin')

@section('header', 'Pengaturan Sistem')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
    <p class="text-sm text-gray-500 mt-1">Konfigurasi variabel global aplikasi Portal Les TKA.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('admin.system.settings.update') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-6">
            <!-- Waktu Tunggu Check-in -->
            <div class="pb-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Waktu Tunggu Absensi</h3>
                <p class="text-sm text-gray-500 mb-4">Pengaturan waktu terkait sesi les berjalan dan toleransi keterlambatan.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="toleransi_keterlambatan" class="block text-sm font-medium text-gray-700 mb-1">Toleransi Keterlambatan (Menit)</label>
                        <div class="relative">
                            <input type="number" name="toleransi_keterlambatan" id="toleransi_keterlambatan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3 pr-16" value="{{ $settings['toleransi_keterlambatan'] ?? 15 }}" min="0" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">menit</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Batas waktu siswa masih diizinkan absen setelah sesi dimulai.</p>
                    </div>
                    
                    <div>
                        <label for="durasi_sesi_default" class="block text-sm font-medium text-gray-700 mb-1">Durasi Default Sesi (Menit)</label>
                        <div class="relative">
                            <input type="number" name="durasi_sesi_default" id="durasi_sesi_default" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3 pr-16" value="{{ $settings['durasi_sesi_default'] ?? 90 }}" min="10" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">menit</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Estimasi durasi satu sesi les jika tidak diakhiri manual oleh guru.</p>
                    </div>
                </div>
            </div>

            <!-- Identitas Sekolah -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Identitas Portal</h3>
                <p class="text-sm text-gray-500 mb-4">Informasi yang ditampilkan di kop surat atau dashboard.</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi/Sekolah</label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $settings['nama_sekolah'] ?? 'Portal Les TKA 2026/2027' }}" required>
                    </div>
                    
                    <div>
                        <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran Aktif</label>
                        <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $settings['tahun_ajaran'] ?? '2026/2027' }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

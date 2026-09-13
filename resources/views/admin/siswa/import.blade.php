@extends('layouts.admin')

@section('header', 'Import Data Siswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.siswa.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Import Data Siswa</h1>
    <p class="text-sm text-gray-500 mt-1">Unggah file CSV untuk menambahkan banyak siswa sekaligus.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.siswa.import.process') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="file_csv" class="block text-sm font-medium text-gray-700 mb-1">File CSV Data Siswa</label>
                    <input type="file" name="file_csv" id="file_csv" accept=".csv" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                    @error('file_csv') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="default_password" class="block text-sm font-medium text-gray-700 mb-1">Default Password Akun</label>
                    <input type="text" name="default_password" id="default_password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('default_password') border-red-300 @enderror" value="siswa123" required>
                    <p class="text-xs text-gray-500 mt-1">Password ini akan digunakan oleh semua siswa yang diimport untuk login pertama kali.</p>
                    @error('default_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 border-t border-gray-100 pt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Mulai Import
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Format -->
    <div class="bg-blue-50 rounded-xl shadow-sm border border-blue-100 p-6">
        <h3 class="text-lg font-bold text-blue-800 flex items-center mb-4">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Format File CSV
        </h3>
        
        <p class="text-sm text-blue-900 mb-3">Pastikan file CSV Anda mengikuti format kolom berurutan sebagai berikut tanpa baris header tambahan di atasnya:</p>
        
        <div class="bg-white rounded border border-blue-200 p-3 mb-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left font-bold text-blue-800 border-b border-blue-100">
                        <th class="pb-2 pr-4">Kolom 1</th>
                        <th class="pb-2 pr-4">Kolom 2</th>
                        <th class="pb-2">Kolom 3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-gray-600">
                        <td class="pt-2 pr-4">NISN (Text)</td>
                        <td class="pt-2 pr-4">Nama Lengkap (Text)</td>
                        <td class="pt-2">Nama Rombel (Sesuai di Master Rombel)</td>
                    </tr>
                    <tr class="text-gray-500 italic text-xs">
                        <td class="pt-1 pr-4">Contoh: 008123456</td>
                        <td class="pt-1 pr-4">Contoh: Budi Santoso</td>
                        <td class="pt-1">Contoh: XII TKR 1</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="text-sm text-blue-900 space-y-1 list-disc list-inside">
            <li>Gunakan pemisah koma <code>(,)</code> pada file CSV.</li>
            <li>Nama rombel harus <b>persis sama</b> dengan yang ada di menu Master Rombel.</li>
            <li>Jika NISN sudah ada di database, baris tersebut akan diabaikan (skip).</li>
            <li>Username akun otomatis diset sama dengan NISN.</li>
        </ul>
    </div>
</div>
@endsection

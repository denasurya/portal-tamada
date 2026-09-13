@extends('layouts.admin')

@section('header', 'Tambah Guru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.guru.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Tambah Guru Baru</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
    <form action="{{ route('admin.guru.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Biodata Guru -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Biodata Guru</h3>
                
                <div>
                    <label for="kode_guru" class="block text-sm font-medium text-gray-700 mb-1">Kode Guru</label>
                    <input type="text" name="kode_guru" id="kode_guru" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kode_guru') border-red-300 @enderror" value="{{ old('kode_guru') }}" required autofocus placeholder="Contoh: G001">
                    @error('kode_guru') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama_guru" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Guru</label>
                    <input type="text" name="nama_guru" id="nama_guru" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_guru') border-red-300 @enderror" value="{{ old('nama_guru') }}" required placeholder="Contoh: Budi Santoso, S.Pd">
                    @error('nama_guru') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Akun (Login)</h3>
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('username') border-red-300 @enderror" value="{{ old('username') }}" required placeholder="Contoh: guru.budi">
                    @error('username') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror" required placeholder="Minimal 6 karakter">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                Simpan & Buat Akun
            </button>
        </div>
    </form>
</div>
@endsection

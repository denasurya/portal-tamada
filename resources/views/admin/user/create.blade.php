@extends('layouts.admin')

@section('header', 'Tambah User')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.user.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <form action="{{ route('admin.user.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Opsional)</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_lengkap') border-red-300 @enderror" value="{{ old('nama_lengkap') }}" placeholder="Kosongkan jika ingin memakai username sebagai nama">
                @error('nama_lengkap') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username (Untuk Login)</label>
                <input type="text" name="username" id="username" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('username') border-red-300 @enderror" value="{{ old('username') }}" required autofocus>
                @error('username') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror" required>
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter.</p>
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
                <select name="role" id="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('role') border-red-300 @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                    <option value="kepsek" {{ old('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah (Hanya Laporan)</option>
                </select>
                @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('header', 'Edit Siswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.siswa.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Edit Data Siswa: {{ $siswa->nama }}</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Biodata Siswa -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Biodata Siswa</h3>
                
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nisn') border-red-300 @enderror" value="{{ old('nisn', $siswa->nisn) }}" required>
                    <p class="text-xs text-gray-500 mt-1">Mengubah NISN akan mengubah username login siswa.</p>
                    @error('nisn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-300 @enderror" value="{{ old('nama', $siswa->nama) }}" required>
                    @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="rombel_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas (Rombel)</label>
                    <select name="rombel_id" id="rombel_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('rombel_id') border-red-300 @enderror" required>
                        <option value="">-- Pilih Rombel --</option>
                        @foreach($rombels as $rombel)
                            <option value="{{ $rombel->id }}" {{ old('rombel_id', $siswa->rombel_id) == $rombel->id ? 'selected' : '' }}>
                                {{ $rombel->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('rombel_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Keamanan</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username Saat Ini</label>
                    <input type="text" disabled class="w-full rounded-md border-gray-200 bg-gray-50 text-gray-500 shadow-sm" value="{{ $siswa->user->username }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Reset Password</label>
                    <input type="password" name="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror" placeholder="Kosongkan jika tidak diubah">
                    <p class="text-xs text-gray-500 mt-1">Hanya diisi jika ingin mereset password siswa.</p>
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

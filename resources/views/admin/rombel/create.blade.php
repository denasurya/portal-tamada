@extends('layouts.admin')

@section('header', 'Tambah Rombel')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.rombel.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Tambah Rombel Baru</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <form action="{{ route('admin.rombel.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Rombel</label>
                <input type="text" name="nama" id="nama" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" value="{{ old('nama') }}" required autofocus placeholder="Contoh: XII TKR 1">
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jurusan_id') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                Simpan Rombel
            </button>
        </div>
    </form>
</div>
@endsection

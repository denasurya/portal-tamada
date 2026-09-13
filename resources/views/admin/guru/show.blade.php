@extends('layouts.admin')

@section('header', 'Detail & Penugasan Guru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.guru.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">{{ $guru->nama_guru }}</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola mata pelajaran dan rombel yang diajar oleh guru ini.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Kiri: Form Penugasan Mapel -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Tugaskan Mata Pelajaran</h3>
            </div>
            <form action="{{ route('admin.guru.assign-mapel', $guru->id) }}" method="POST" class="p-4">
                @csrf
                <div class="mb-4">
                    <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors text-sm">
                    Tambah Penugasan Mapel
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Penugasan -->
    <div class="lg:col-span-2 space-y-6">
        @forelse($guru->guru_mapels as $guruMapel)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Mapel -->
            <div class="p-4 bg-indigo-50 border-b border-indigo-100 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg mr-3 text-indigo-700 font-bold">
                        {{ $guruMapel->mata_pelajaran->kode }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $guruMapel->mata_pelajaran->nama }}</h3>
                        <p class="text-xs text-indigo-600 font-medium">Mata Pelajaran Diampu</p>
                    </div>
                </div>
                <form action="{{ route('admin.guru.remove-mapel', [$guru->id, $guruMapel->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penugasan mapel ini beserta semua rombelnya?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-md transition-colors">
                        Hapus Mapel
                    </button>
                </form>
            </div>

            <!-- List Rombel untuk Mapel ini -->
            <div class="p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wider">Rombel yang diajar:</h4>
                
                <div class="flex flex-wrap gap-2 mb-4">
                    @forelse($guruMapel->penugasan_rombels as $pr)
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm bg-gray-100 text-gray-800 border border-gray-200">
                            {{ $pr->rombel->nama }}
                            <form action="{{ route('admin.guru.remove-rombel', [$guru->id, $guruMapel->id, $pr->id]) }}" method="POST" class="ml-2 inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 focus:outline-none" title="Hapus Rombel">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada rombel yang ditugaskan untuk mapel ini.</p>
                    @endforelse
                </div>

                <!-- Form Tambah Rombel -->
                <form action="{{ route('admin.guru.assign-rombel', [$guru->id, $guruMapel->id]) }}" method="POST" class="flex gap-2 mt-4 items-end bg-gray-50 p-3 rounded-lg border border-gray-100">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tambah Rombel</label>
                        <select name="rombel_id" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5" required>
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($rombels as $rombel)
                                <!-- Jangan tampilkan jika sudah di-assign -->
                                @if(!$guruMapel->penugasan_rombels->contains('rombel_id', $rombel->id))
                                    <option value="{{ $rombel->id }}">{{ $rombel->nama }} ({{ $rombel->jurusan->nama ?? '-' }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium transition-colors text-sm">
                        Tambah
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <h3 class="text-lg font-medium text-gray-900">Belum Ada Penugasan</h3>
            <p class="text-sm text-gray-500 mt-1">Guru ini belum ditugaskan untuk mengajar mata pelajaran apapun.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

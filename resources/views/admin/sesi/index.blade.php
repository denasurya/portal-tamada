@extends('layouts.admin')

@section('header', 'Manajemen Sesi Les')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Sesi Les</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan hapus histori sesi percobaan yang ada di sistem.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Filter & Search -->
    <div class="p-4 border-b border-gray-100 bg-gray-50">
        <form action="{{ route('admin.sesi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-auto">
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status Sesi</label>
                <select name="status" id="status" class="w-full sm:w-48 text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="berjalan" {{ request('status') === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <div class="w-full flex-1">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Pencarian</label>
                <div class="flex">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari Mapel atau Nama Guru..." class="flex-1 text-sm rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-r-md hover:bg-indigo-700 transition-colors">
                        Cari
                    </button>
                </div>
            </div>

            @if(request()->hasAny(['status', 'search']))
                <a href="{{ route('admin.sesi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-white border-b border-gray-100">
                <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Mata Pelajaran & Guru</th>
                    <th class="px-6 py-4">Rombel Target</th>
                    <th class="px-6 py-4">Waktu Pelaksanaan</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sesis as $sesi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $sesi->mata_pelajaran->nama }}</div>
                            <div class="text-xs text-gray-500 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $sesi->guru->nama_guru }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-800">{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - 
                                {{ $sesi->waktu_selesai ? \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') : '...' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($sesi->status === 'berjalan')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Berjalan
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.sesi.destroy', $sesi->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus sesi ini juga akan menghapus SEMUA data absensi siswa dan foto bukti mengajar secara permanen. Apakah Anda yakin ingin menghapus sesi ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-md text-xs font-medium transition-colors border border-red-100 shadow-sm" title="Hapus Histori Sesi">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data sesi les yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($sesis->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $sesis->links() }}
    </div>
    @endif
</div>
@endsection

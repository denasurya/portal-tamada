@extends('layouts.guru')

@section('header', 'Histori Sesi Les')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Histori Sesi Les</h1>
    <p class="text-sm text-gray-500 mt-1">Daftar kegiatan pembelajaran yang telah Anda selenggarakan.</p>
</div>

<!-- Filter Section -->
<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form action="{{ route('guru.histori.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
        
        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-700 mb-1">Mulai Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        
        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-700 mb-1">Mata Pelajaran</label>
            <select name="mapel_id" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Semua Mapel --</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-700 mb-1">Rombel</label>
            <select name="rombel_id" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Semua Rombel --</option>
                @foreach($rombels as $rombel)
                    <option value="{{ $rombel->id }}" {{ request('rombel_id') == $rombel->id ? 'selected' : '' }}>{{ $rombel->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('guru.histori.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b">
                    <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                    <th class="px-4 py-3">Mata Pelajaran</th>
                    <th class="px-4 py-3">Materi</th>
                    <th class="px-4 py-3">Rombel</th>
                    <th class="px-4 py-3 whitespace-nowrap">Waktu</th>
                    <th class="px-4 py-3 text-center">Total Siswa</th>
                    <th class="px-4 py-3 text-center whitespace-nowrap">Hadir Valid</th>
                    <th class="px-4 py-3 text-center">Persentase</th>
                    <th class="px-4 py-3 text-center">Status Bukti</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sesis as $sesi)
                    @php
                        $stats = $sesi->getAbsensiStats();
                        $rombels = $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ');
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">{{ $sesi->waktu_mulai->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $sesi->mata_pelajaran->nama }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $sesi->materi }}">{{ $sesi->materi }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $rombels }}">{{ $rombels }}</td>
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                            {{ $sesi->waktu_mulai ? $sesi->waktu_mulai->format('H:i') : '-' }} - 
                            {{ $sesi->waktu_selesai ? $sesi->waktu_selesai->format('H:i') : 'Berjalan' }}
                        </td>
                        <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $stats['total_expected'] }}</td>
                        <td class="px-4 py-3 text-center font-medium text-green-600">{{ $stats['hadir_valid'] }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($stats['persentase'] >= 90)
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs font-semibold">{{ $stats['persentase'] }}%</span>
                            @elseif($stats['persentase'] >= 70)
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded text-xs font-semibold">{{ $stats['persentase'] }}%</span>
                            @else
                                <span class="px-2 py-1 bg-red-50 text-red-700 rounded text-xs font-semibold">{{ $stats['persentase'] }}%</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($sesi->bukti_path)
                                <span class="text-green-600 font-medium text-xs flex items-center justify-center" title="Sudah Ada">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Ada
                                </span>
                            @else
                                <span class="text-yellow-600 font-medium text-xs flex items-center justify-center" title="Belum Ada">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Belum
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('guru.histori.show', $sesi->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded hover:bg-indigo-100 transition-colors whitespace-nowrap">
                                DETAIL
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="font-medium">Belum ada histori sesi les.</span>
                                <span class="text-xs mt-1">Daftar kegiatan pembelajaran yang telah Anda selenggarakan akan muncul di sini.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($sesis->hasPages())
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $sesis->links() }}
        </div>
    @endif
</div>
@endsection

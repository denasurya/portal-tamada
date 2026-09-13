@extends('layouts.admin')

@section('header', 'Dashboard Utama')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Selamat datang di Portal Admin</h1>
    <p class="text-sm text-gray-500 mt-1">Ringkasan statistik sistem Portal Les TKA.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Siswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-lg bg-blue-50 text-blue-600 mr-4">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</p>
        </div>
    </div>
    
    <!-- Total Guru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 mr-4">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Guru</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_guru'] }}</p>
        </div>
    </div>

    <!-- Total Rombel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-3 rounded-lg bg-green-50 text-green-600 mr-4">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Rombel</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_rombel'] }}</p>
        </div>
    </div>

    <!-- Sesi Aktif -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center relative overflow-hidden">
        <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600 mr-4 z-10">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="z-10">
            <p class="text-sm font-medium text-gray-500">Sesi Sedang Berjalan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['sesi_aktif'] }}</p>
        </div>
        @if($stats['sesi_aktif'] > 0)
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-400 rounded-full opacity-10 animate-pulse"></div>
        @endif
    </div>
</div>

<!-- Sesi Terakhir -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">5 Sesi Les Terakhir</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Mapel</th>
                    <th class="px-6 py-3">Guru</th>
                    <th class="px-6 py-3">Rombel</th>
                    <th class="px-6 py-3">Waktu Mulai</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recent_sessions as $sesi)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $sesi->mata_pelajaran->nama }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $sesi->guru->nama_guru }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ') }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $sesi->waktu_mulai->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($sesi->status === 'berjalan')
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 flex items-center w-fit gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                Berjalan
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada sesi les yang terbuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

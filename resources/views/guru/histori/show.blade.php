@extends('layouts.guru')

@section('header', 'Detail Sesi Les')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <a href="{{ route('guru.histori.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Histori
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Sesi: {{ $sesi->mata_pelajaran->nama }}</h1>
    </div>
    
    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
        <!-- DOWNLOAD EXCEL -->
        <a href="{{ route('guru.histori.download.excel', $sesi->id) }}" hx-boost="false" class="inline-flex items-center justify-center px-4 py-2.5 border border-green-600 shadow-sm text-sm font-medium rounded-lg text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Download Excel
        </a>
        
        <!-- DOWNLOAD PDF -->
        <a href="{{ route('guru.histori.download.pdf', $sesi->id) }}" hx-boost="false" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Informasi Sesi -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Informasi Sesi</h3>
            @if($sesi->status == 'selesai')
                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wider">Selesai</span>
            @else
                <span class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold uppercase tracking-wider">Berjalan</span>
            @endif
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-1">Tanggal</span>
                    <span class="block text-sm text-gray-800 font-medium">{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->translatedFormat('d F Y') }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-1">Waktu Pelaksanaan</span>
                    <span class="block text-sm text-gray-800 font-medium">
                        {{ $sesi->waktu_mulai ? $sesi->waktu_mulai->format('H:i') : '-' }} WIB s/d 
                        {{ $sesi->waktu_selesai ? $sesi->waktu_selesai->format('H:i') : '-' }} WIB
                    </span>
                </div>
                <div class="sm:col-span-2 border-t border-gray-100 pt-4 mt-2"></div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-1">Mata Pelajaran</span>
                    <span class="block text-sm text-gray-800 font-medium">{{ $sesi->mata_pelajaran->nama }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-1">Guru Pengajar</span>
                    <span class="block text-sm text-gray-800 font-medium">{{ auth()->user()->guru->nama_guru }}</span>
                </div>
                <div class="sm:col-span-2 border-t border-gray-100 pt-4 mt-2"></div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-gray-500 mb-1">Materi Pembelajaran</span>
                    <span class="block text-sm text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100 mt-1">{{ $sesi->materi ?: '-' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-gray-500 mb-1">Rombel Target</span>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($sesi->sesi_les_rombels as $slr)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs font-medium border border-indigo-100">
                                {{ $slr->rombel->nama }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Kehadiran Keseluruhan -->
    <div class="bg-indigo-800 rounded-xl shadow-md border border-indigo-900 overflow-hidden text-white flex flex-col">
        <div class="p-5 border-b border-indigo-700/50">
            <h3 class="text-lg font-bold">Rekap Keseluruhan</h3>
            <p class="text-indigo-200 text-xs mt-1">Statistik absensi seluruh rombel</p>
        </div>
        <div class="p-6 flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-6 pb-6 border-b border-indigo-700/50">
                <div>
                    <span class="block text-indigo-200 text-xs font-medium uppercase tracking-wider mb-1">PERSENTASE</span>
                    <span class="block text-4xl font-bold">{{ $stats['persentase'] }}<span class="text-xl text-indigo-300">%</span></span>
                </div>
                <div class="w-16 h-16 rounded-full border-4 border-indigo-600 flex items-center justify-center bg-indigo-900 relative">
                    <!-- Circular progress approximation -->
                    <div class="absolute inset-0 rounded-full border-4 border-white opacity-20" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);"></div>
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 flex-1">
                <div class="bg-indigo-900/50 p-3 rounded-lg border border-indigo-700/50">
                    <span class="block text-indigo-300 text-[10px] font-bold uppercase tracking-wider mb-1">Total Siswa</span>
                    <span class="block text-2xl font-bold">{{ $stats['total_expected'] }}</span>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg border border-green-500/30">
                    <span class="block text-green-300 text-[10px] font-bold uppercase tracking-wider mb-1">Hadir Valid</span>
                    <span class="block text-2xl font-bold text-green-400">{{ $stats['hadir_valid'] }}</span>
                </div>
                <div class="bg-red-500/20 p-3 rounded-lg border border-red-500/30">
                    <span class="block text-red-300 text-[10px] font-bold uppercase tracking-wider mb-1">Tidak Hadir</span>
                    <span class="block text-2xl font-bold text-red-400">{{ $stats['tidak_hadir'] }}</span>
                </div>
                
                <div class="bg-yellow-500/20 p-3 rounded-lg border border-yellow-500/30">
                    <span class="block text-yellow-300 text-[10px] font-bold uppercase tracking-wider mb-1">Sakit</span>
                    <span class="block text-2xl font-bold text-yellow-400">{{ $stats['sakit'] }}</span>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-lg border border-purple-500/30">
                    <span class="block text-purple-300 text-[10px] font-bold uppercase tracking-wider mb-1">Izin</span>
                    <span class="block text-2xl font-bold text-purple-400">{{ $stats['izin'] }}</span>
                </div>
                <div class="bg-gray-700/50 p-3 rounded-lg border border-gray-600/50">
                    <span class="block text-gray-300 text-[10px] font-bold uppercase tracking-wider mb-1">Tdk Konfirmasi</span>
                    <span class="block text-2xl font-bold text-gray-300">{{ $stats['tidak_konfirmasi'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rekap Per Rombel -->
<h3 class="text-lg font-bold text-gray-800 mb-4 mt-8 flex items-center">
    <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    Rekapitulasi Per Rombel
</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach($rekapRombel as $rekap)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4 pb-3 border-b border-gray-100">
                <h4 class="font-bold text-gray-800 text-lg">{{ $rekap['nama_rombel'] }}</h4>
                <div class="text-right">
                    <span class="block text-xl font-bold {{ $rekap['persentase'] >= 90 ? 'text-green-600' : ($rekap['persentase'] >= 75 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $rekap['persentase'] }}%
                    </span>
                    <span class="block text-[10px] uppercase text-gray-400 font-medium tracking-wider">Hadir Valid</span>
                </div>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Siswa:</span>
                    <span class="font-medium text-gray-800">{{ $rekap['total_siswa'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Hadir Valid:</span>
                    <span class="font-medium text-green-600">{{ $rekap['hadir_valid'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Sakit:</span>
                    <span class="font-medium text-yellow-600">{{ $rekap['sakit'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Izin:</span>
                    <span class="font-medium text-purple-600">{{ $rekap['izin'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tidak Konfirmasi:</span>
                    <span class="font-medium text-gray-700">{{ $rekap['tidak_konfirmasi'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tidak Hadir:</span>
                    <span class="font-medium text-red-600">{{ $rekap['tidak_hadir'] }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Absensi Siswa -->
    <div class="lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Detail Absensi Siswa
        </h3>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <!-- Table Filters -->
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <form action="{{ route('guru.histori.show', $sesi->id) }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <select name="filter_rombel_id" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Rombel</option>
                        @foreach($sesi->sesi_les_rombels as $slr)
                            <option value="{{ $slr->rombel_id }}" {{ request('filter_rombel_id') == $slr->rombel_id ? 'selected' : '' }}>{{ $slr->rombel->nama }}</option>
                        @endforeach
                    </select>
                    
                    <select name="filter_status" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="belum_diabsen" {{ request('filter_status') == 'belum_diabsen' ? 'selected' : '' }}>Belum Diabsen</option>
                        <option value="menunggu_konfirmasi" {{ request('filter_status') == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="hadir_valid" {{ request('filter_status') == 'hadir_valid' ? 'selected' : '' }}>Hadir Valid</option>
                        <option value="sakit" {{ request('filter_status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ request('filter_status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="tidak_konfirmasi" {{ request('filter_status') == 'tidak_konfirmasi' ? 'selected' : '' }}>Tidak Konfirmasi</option>
                        <option value="tidak_hadir" {{ request('filter_status') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                    
                    <div class="flex-1 flex">
                        <input type="text" name="search_nama" value="{{ request('search_nama') }}" placeholder="Cari nama siswa..." class="flex-1 text-sm rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-r-md hover:bg-indigo-700 transition-colors">Cari</button>
                    </div>
                    
                    @if(request()->hasAny(['filter_rombel_id', 'filter_status', 'search_nama']))
                        <a href="{{ route('guru.histori.show', $sesi->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition-colors flex items-center justify-center">Reset</a>
                    @endif
                </form>
            </div>
            
            <div class="overflow-x-auto max-h-96">
                <table class="min-w-full text-sm">
                    <thead class="bg-white sticky top-0 shadow-sm">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 w-12 text-center border-b border-gray-200">No</th>
                            <th class="px-4 py-3 border-b border-gray-200">Nama Siswa / NISN</th>
                            <th class="px-4 py-3 border-b border-gray-200">Rombel</th>
                            <th class="px-4 py-3 border-b border-gray-200 text-center">Status Absensi</th>
                            <th class="px-4 py-3 border-b border-gray-200 text-center whitespace-nowrap">Waktu Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($absensis as $index => $absensi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <span class="block font-medium text-gray-800">{{ $absensi->siswa->nama }}</span>
                                    <span class="block text-xs text-gray-500 font-mono">{{ $absensi->siswa->nisn }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $absensi->siswa->rombel->nama }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($absensi->status == 'hadir_valid')
                                        <span class="px-2 py-1 bg-green-50 text-green-700 border border-green-200 rounded text-xs font-semibold whitespace-nowrap">Hadir Valid</span>
                                    @elseif($absensi->status == 'menunggu_konfirmasi')
                                        <span class="px-2 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded text-xs font-semibold whitespace-nowrap">Menunggu Konfirmasi</span>
                                    @elseif($absensi->status == 'sakit')
                                        <span class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded text-xs font-semibold whitespace-nowrap">Sakit</span>
                                    @elseif($absensi->status == 'izin')
                                        <span class="px-2 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded text-xs font-semibold whitespace-nowrap">Izin</span>
                                    @elseif($absensi->status == 'tidak_konfirmasi')
                                        <span class="px-2 py-1 bg-gray-700 text-white border border-gray-800 rounded text-xs font-semibold whitespace-nowrap">Tidak Konfirmasi</span>
                                    @elseif($absensi->status == 'tidak_hadir')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 border border-gray-200 rounded text-xs font-semibold whitespace-nowrap">Tidak Hadir</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 border border-gray-200 rounded text-xs font-semibold whitespace-nowrap">Belum Diabsen</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 text-xs whitespace-nowrap">
                                    {{ $absensi->confirmed_at ? \Carbon\Carbon::parse($absensi->confirmed_at)->format('H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    Tidak ada data siswa yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Bukti & Ekstra -->
    <div class="lg:col-span-1 space-y-6">
        <!-- BUKTI PELAKSANAAN -->
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Bukti Pelaksanaan
        </h3>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            @if($sesi->bukti_path)
                <div class="flex items-center text-green-600 mb-4 bg-green-50 p-2 rounded-lg border border-green-100">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">Bukti Foto Tersedia</span>
                </div>
                
                <div class="aspect-video w-full rounded-lg bg-gray-100 border border-gray-200 overflow-hidden mb-4 relative group">
                    <img src="{{ Storage::url($sesi->bukti_path) }}" alt="Bukti Mengajar" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ Storage::url($sesi->bukti_path) }}" target="_blank" class="px-4 py-2 bg-white text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-100">Lihat Penuh</a>
                    </div>
                </div>
                
                <a href="{{ Storage::url($sesi->bukti_path) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Buka Bukti Mengajar
                </a>
            @else
                <div class="flex flex-col items-center justify-center py-6 text-yellow-600">
                    <svg class="h-12 w-12 text-yellow-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-bold text-sm text-center">Belum ada bukti yang diunggah</span>
                    <span class="text-xs text-yellow-700 mt-1 text-center">Guru belum mengunggah foto bukti pelaksanaan sesi ini.</span>
                </div>
            @endif
        </div>
        
        <!-- LINK GOOGLE MEET -->
        @if($sesi->link_meet)
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 shadow-sm">
                <h4 class="font-bold text-blue-900 mb-2 flex items-center text-sm">
                    <svg class="h-5 w-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Tautan Video Conference
                </h4>
                <p class="text-xs text-blue-800 mb-3 truncate" title="{{ $sesi->link_meet }}">{{ $sesi->link_meet }}</p>
                <a href="{{ $sesi->link_meet }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buka Google Meet
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

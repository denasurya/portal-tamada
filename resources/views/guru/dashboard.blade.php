@extends('layouts.guru')

@section('content')
<div class="space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Hero Banner --}}
    <div class="bg-white rounded-2xl p-8 relative overflow-hidden shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-8">
        <!-- Abstract Shapes Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-100 rounded-full opacity-50 blur-3xl transform translate-x-1/2 -translate-y-1/4"></div>
            <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-emerald-100 rounded-full opacity-40 blur-2xl transform translate-y-1/2"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 flex-1">
            <p class="text-gray-500 text-sm font-medium mb-1">Selamat datang di</p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-green-800 tracking-tight leading-tight">TAMADA</h1>
            <h2 class="text-2xl md:text-3xl font-bold text-green-700 mb-4">Portal Guru</h2>
            <p class="text-gray-500 text-sm max-w-md leading-relaxed">
                Kelola pembelajaran, pantau aktivitas, dan wujudkan pendidikan yang lebih baik bersama.
            </p>
        </div>

        <!-- Hero Quotes & Decoration -->
        <div class="relative z-10 flex-1 flex flex-col items-end w-full">
            <div class="bg-white/90 backdrop-blur-sm border border-gray-100 p-4 rounded-xl shadow-sm max-w-sm mb-5 flex gap-3 relative">
                <div class="text-green-500 font-serif text-5xl leading-none rotate-180 absolute -top-2 -left-3 opacity-30">"</div>
                <div class="text-green-600 font-bold text-3xl pt-1">“</div>
                <p class="text-gray-600 text-sm font-medium leading-relaxed italic">
                    Pendidikan hari ini,<br>untuk generasi yang lebih unggul esok nanti.
                </p>
            </div>
            
            <div class="text-right mt-2">
                <p class="font-serif italic text-xl md:text-2xl text-green-800 font-bold opacity-80 leading-snug">
                    Satu Akses<br>Banyak Layanan<br>untuk Kemajuan Bersama
                </p>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
        <!-- Card 1 -->
        <div class="bg-white p-5 rounded-[1.25rem] shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-[3.25rem] h-[3.25rem] rounded-2xl bg-[#e6f4ea] text-[#0e7448] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[13px] text-gray-500 font-medium leading-tight">Total Sesi</span>
                    <span class="text-3xl font-extrabold text-[#0f172a] leading-none my-1">{{ $total_sesi_bulan_ini ?? 0 }}</span>
                    <span class="text-[11px] text-gray-500 leading-tight">Sesi bulan ini</span>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-green-50 text-[#0e7448] flex items-center justify-center shrink-0 group-hover:bg-[#e6f4ea] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-white p-5 rounded-[1.25rem] shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-[3.25rem] h-[3.25rem] rounded-2xl bg-[#e6f4ea] text-[#0e7448] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[13px] text-gray-500 font-medium leading-tight">Total Siswa</span>
                    <span class="text-3xl font-extrabold text-[#0f172a] leading-none my-1">{{ $total_siswa ?? 0 }}</span>
                    <span class="text-[11px] text-gray-500 leading-tight">Siswa yang diajar</span>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-green-50 text-[#0e7448] flex items-center justify-center shrink-0 group-hover:bg-[#e6f4ea] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-5 rounded-[1.25rem] shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-[3.25rem] h-[3.25rem] rounded-2xl bg-[#e6f4ea] text-[#0e7448] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[13px] text-gray-500 font-medium leading-tight">Sesi Selesai</span>
                    <span class="text-3xl font-extrabold text-[#0f172a] leading-none my-1">{{ $total_sesi_selesai ?? 0 }}</span>
                    <span class="text-[11px] text-gray-500 leading-tight">{{ $persentase_selesai ?? 0 }}% dari total sesi</span>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-green-50 text-[#0e7448] flex items-center justify-center shrink-0 group-hover:bg-[#e6f4ea] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-5 rounded-[1.25rem] shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="w-[3.25rem] h-[3.25rem] rounded-2xl bg-[#e6f4ea] text-[#0e7448] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[13px] text-gray-500 font-medium leading-tight">Sesi Berjalan</span>
                    <span class="text-3xl font-extrabold text-[#0f172a] leading-none my-1">{{ $total_sesi_berjalan ?? 0 }}</span>
                    <span class="text-[11px] text-gray-500 leading-tight">
                        @if(($total_sesi_berjalan ?? 0) > 0)
                            <span class="text-[#0e7448] font-semibold">{{ $total_sesi_berjalan }} aktif</span>
                        @else
                            Tidak ada sesi aktif
                        @endif
                    </span>
                </div>
            </div>
            <div class="w-8 h-8 rounded-full bg-green-50 text-[#0e7448] flex items-center justify-center shrink-0 group-hover:bg-[#e6f4ea] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>
    </div>

    {{-- SESI AKTIF --}}
    <div>
        <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            Sesi Sedang Berjalan
        </h2>

        @forelse($sesi_aktif as $sesi)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6"
             id="sesi-card-{{ $sesi->id }}"
             x-data="absensiApp({{ $sesi->id }}, {{ json_encode($sesi->daftar_rombel) }}, {{ json_encode($sesi->stats) }}, {{ $sesi->bukti_path ? 'true' : 'false' }})">

            {{-- Info Sesi --}}
            <div class="p-6 border-b border-gray-50">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $sesi->mata_pelajaran->nama }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Materi: <span class="font-medium text-gray-700">{{ $sesi->materi }}</span>
                        </p>
                        <p class="text-sm text-gray-500">
                            Rombel: <span class="font-medium text-gray-700">
                                {{ $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ') }}
                            </span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Dimulai: {{ $sesi->waktu_mulai->format('H:i') }}</p>
                        @if($sesi->file_materi)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $sesi->file_materi) }}" target="_blank"
                                class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-lg border border-green-100 text-xs font-semibold hover:bg-green-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Materi
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2">
                        @if($sesi->gmeet_link)
                        <a href="{{ $sesi->gmeet_link }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Buka Google Meet
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistik Real-time --}}
            <div class="p-6 bg-[#fbfdfc] border-b border-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        Statistik Kehadiran 
                        <span class="text-[10px] font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full" x-text="stats.total_expected + ' Siswa'"></span>
                    </h4>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-4">
                    <div class="bg-green-50 rounded-xl p-3 text-center border border-green-100">
                        <p class="text-2xl font-bold text-green-600" x-text="stats.hadir_valid">0</p>
                        <p class="text-[10px] sm:text-[11px] text-green-600 mt-1 font-semibold uppercase tracking-wider">Hadir</p>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-3 text-center border border-yellow-100">
                        <p class="text-2xl font-bold text-yellow-600" x-text="stats.menunggu_konfirmasi">0</p>
                        <p class="text-[10px] sm:text-[11px] text-yellow-600 mt-1 font-semibold uppercase tracking-wider">Menunggu</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 text-center border border-purple-100">
                        <p class="text-2xl font-bold text-purple-600" x-text="stats.izin">0</p>
                        <p class="text-[10px] sm:text-[11px] text-purple-600 mt-1 font-semibold uppercase tracking-wider">Izin</p>
                    </div>
                    <div class="bg-red-50 rounded-xl p-3 text-center border border-red-100">
                        <p class="text-2xl font-bold text-red-600" x-text="stats.sakit">0</p>
                        <p class="text-[10px] sm:text-[11px] text-red-600 mt-1 font-semibold uppercase tracking-wider">Sakit</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-3 text-center border border-gray-800">
                        <p class="text-2xl font-bold text-gray-100" x-text="stats.tidak_konfirmasi">0</p>
                        <p class="text-[10px] sm:text-[11px] text-gray-200 mt-1 font-semibold uppercase tracking-wider">Tdk Konfirm</p>
                    </div>
                    <div class="bg-gray-100 rounded-xl p-3 text-center border border-gray-200">
                        <p class="text-2xl font-bold text-gray-500" x-text="stats.tidak_hadir">0</p>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 mt-1 font-semibold uppercase tracking-wider">Tdk Hadir</p>
                    </div>
                    <div class="bg-green-600 rounded-xl p-3 text-center border border-green-700 shadow-sm shadow-green-200 text-white">
                        <p class="text-2xl font-bold" x-text="stats.persentase + '%'">0%</p>
                        <p class="text-[10px] sm:text-[11px] text-green-100 mt-1 font-semibold uppercase tracking-wider">Persentase</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="h-2 rounded-full bg-green-500 transition-all duration-700"
                         :style="`width: ${stats.persentase}%`">
                    </div>
                </div>
            </div>

            {{-- Daftar Siswa --}}
            <div class="p-6" id="tabel-absensi-{{ $sesi->id }}">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                    <h4 class="text-sm font-bold text-gray-700">Daftar Siswa</h4>
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari nama siswa..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-colors">
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-100 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 w-12 text-center">No</th>
                                <th class="px-4 py-3">Nama Siswa</th>
                                <th class="px-4 py-3 w-64 text-center">Aksi</th>
                                <th class="px-4 py-3 w-48">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            <template x-for="(siswa, index) in paginatedStudents" :key="siswa.id">
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 text-center text-gray-400 font-medium" x-text="((currentPage - 1) * perPage) + index + 1"></td>
                                    <td class="px-4 py-3 font-semibold text-gray-700" x-text="siswa.nama"></td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            {{-- Checkbox Panggil --}}
                                            <div class="relative flex items-center justify-center">
                                                <input type="checkbox" 
                                                    class="w-5 h-5 text-green-600 rounded border-gray-300 focus:ring-green-500 cursor-pointer" 
                                                    :checked="['menunggu_konfirmasi', 'hadir_valid', 'tidak_konfirmasi'].includes(siswa.status)"
                                                    @change="togglePanggil(siswa, $event.target.checked)"
                                                    :disabled="['hadir_valid', 'sakit', 'izin'].includes(siswa.status)">
                                            </div>
                                            
                                            <button type="button" @click="markStatus(siswa.id, 'sakit')" 
                                                class="px-2 py-1.5 bg-red-50 text-red-600 text-[10px] uppercase tracking-wider font-bold rounded-lg border border-red-100 hover:bg-red-100 transition flex items-center gap-1"
                                                :class="{'opacity-50 cursor-not-allowed': ['hadir_valid', 'menunggu_konfirmasi'].includes(siswa.status)}"
                                                :disabled="['hadir_valid', 'menunggu_konfirmasi'].includes(siswa.status)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                Sakit
                                            </button>
                                            
                                            <button type="button" @click="markStatus(siswa.id, 'izin')" 
                                                class="px-2 py-1.5 bg-purple-50 text-purple-600 text-[10px] uppercase tracking-wider font-bold rounded-lg border border-purple-100 hover:bg-purple-100 transition flex items-center gap-1"
                                                :class="{'opacity-50 cursor-not-allowed': ['hadir_valid', 'menunggu_konfirmasi'].includes(siswa.status)}"
                                                :disabled="['hadir_valid', 'menunggu_konfirmasi'].includes(siswa.status)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Izin
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{-- Badges --}}
                                        <template x-if="siswa.status === 'hadir_valid'">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Hadir
                                            </span>
                                        </template>
                                        <template x-if="siswa.status === 'menunggu_konfirmasi'">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu
                                            </span>
                                        </template>
                                        <template x-if="siswa.status === 'sakit'">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Sakit
                                            </span>
                                        </template>
                                        <template x-if="siswa.status === 'izin'">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-purple-100 text-purple-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Izin
                                            </span>
                                        </template>
                                        <template x-if="siswa.status === 'tidak_konfirmasi'">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-700 text-gray-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Tdk Konfirm
                                            </span>
                                        </template>
                                        <template x-if="!['hadir_valid','menunggu_konfirmasi','sakit','izin','tidak_konfirmasi'].includes(siswa.status)">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Belum Hadir
                                            </span>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="paginatedStudents.length === 0">
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        Tidak ada siswa yang ditemukan.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="mt-4 flex items-center justify-between" x-show="totalPages > 1">
                    <p class="text-xs text-gray-500 font-medium">Menampilkan <span x-text="((currentPage - 1) * perPage) + 1"></span> - <span x-text="Math.min(currentPage * perPage, filteredStudents.length)"></span> dari <span x-text="filteredStudents.length"></span> siswa</p>
                    <div class="flex gap-1">
                        <button type="button" @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">← Prev</button>
                        
                        <template x-for="page in totalPages" :key="page">
                            <button type="button" @click="goToPage(page)" 
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition"
                                :class="currentPage === page ? 'bg-green-600 text-white border-green-600' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                x-text="page"></button>
                        </template>
                        
                        <button type="button" @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition">Next →</button>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti & Selesaikan Sesi --}}
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <div x-show="!buktiUploaded" class="flex-1 w-full">
                        <form action="{{ route('guru.sesi-les.upload-bukti', $sesi->id) }}" @submit.prevent.stop="uploadBukti($event)" hx-boost="false" method="POST" enctype="multipart/form-data"
                            class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl p-2 pl-4 w-full shadow-sm">
                            @csrf
                            <label class="text-xs text-gray-600 font-bold uppercase tracking-wider whitespace-nowrap">Bukti Mengajar:</label>
                            <input type="file" name="bukti" accept="image/*" required class="text-sm flex-1 text-gray-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition">
                            <button type="submit" :disabled="isUploading" class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-900 whitespace-nowrap transition disabled:opacity-50">
                                <span x-show="!isUploading">Upload</span>
                                <span x-show="isUploading">Uploading...</span>
                            </button>
                        </form>
                    </div>
                    
                    <div x-show="buktiUploaded" style="display: none;" class="flex items-center gap-2 flex-1 w-full bg-green-50 border border-green-200 rounded-xl p-3 shadow-sm">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-green-700 font-bold">Bukti mengajar sudah diupload</span>
                    </div>

                    <form action="{{ route('guru.sesi-les.finish', $sesi->id) }}" method="POST" id="form-finish-{{ $sesi->id }}" class="w-full md:w-auto shrink-0">
                        @csrf
                        <button type="button" @click="confirmFinishSesi()"
                            class="w-full md:w-auto px-6 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            Selesaikan Sesi
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm py-12 px-6 text-center border border-gray-100 flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-gray-800 font-bold text-lg">Belum ada sesi aktif</p>
            <p class="text-gray-500 text-sm mt-1 mb-6">Klik tombol di bawah untuk memulai sesi pembelajaran baru.</p>
            <div class="mt-2">
                <a href="{{ route('guru.sesi-les.create') }}" class="inline-flex items-center gap-2 bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-green-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Sesi Baru
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Grid Layout for Histori and Akses Cepat --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Histori Sesi --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Histori Sesi (10 Terakhir)
                    </h2>
                    <a href="{{ route('guru.histori.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700 flex items-center gap-1 uppercase tracking-wider">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                
                @if($histori->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                <th class="px-2 py-3">Mata Pelajaran</th>
                                <th class="px-2 py-3">Materi</th>
                                <th class="px-2 py-3">Rombel</th>
                                <th class="px-2 py-3">Tanggal</th>
                                <th class="px-2 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($histori as $h)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-2 py-4 font-bold text-gray-800">{{ $h->mata_pelajaran->nama }}</td>
                                <td class="px-2 py-4 text-gray-600">
                                    {{ Str::limit($h->materi, 20) }}
                                </td>
                                <td class="px-2 py-4 text-gray-500 font-medium text-xs">{{ $h->sesi_les_rombels->pluck('rombel.nama')->implode(', ') }}</td>
                                <td class="px-2 py-4 text-gray-400 text-xs">{{ $h->waktu_mulai->format('d/m/Y H:i') }}</td>
                                <td class="px-2 py-4 text-right">
                                    <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold bg-[#e6f4ea] text-green-700 uppercase tracking-wider border border-green-100">Selesai</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-8 text-center">
                    <p class="text-gray-400 text-sm">Belum ada histori sesi.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Akses Cepat --}}
        <div class="space-y-4">
            <div class="bg-transparent">
                <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Akses Cepat
                </h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('guru.sesi-les.create') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all group flex flex-col items-start h-full">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-green-700 flex items-center justify-center mb-3 group-hover:bg-[#e6f4ea] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-green-700 transition-colors">Buat Sesi</h3>
                        <p class="text-[10px] text-gray-400 leading-tight">Mulai sesi pembelajaran baru</p>
                        <div class="mt-auto pt-3 flex justify-end w-full">
                            <div class="w-5 h-5 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-green-50 text-gray-400 group-hover:text-green-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('guru.histori.index') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all group flex flex-col items-start h-full">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-green-700 flex items-center justify-center mb-3 group-hover:bg-[#e6f4ea] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-green-700 transition-colors">Lihat Histori</h3>
                        <p class="text-[10px] text-gray-400 leading-tight">Riwayat sesi yang telah dilakukan</p>
                        <div class="mt-auto pt-3 flex justify-end w-full">
                            <div class="w-5 h-5 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-green-50 text-gray-400 group-hover:text-green-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('guru.penugasan') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all group flex flex-col items-start h-full">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-green-700 flex items-center justify-center mb-3 group-hover:bg-[#e6f4ea] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-green-700 transition-colors">Penugasan Saya</h3>
                        <p class="text-[10px] text-gray-400 leading-tight">Lihat tugas dan aktivitas</p>
                        <div class="mt-auto pt-3 flex justify-end w-full">
                            <div class="w-5 h-5 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-green-50 text-gray-400 group-hover:text-green-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('guru.profil') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all group flex flex-col items-start h-full">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-green-700 flex items-center justify-center mb-3 group-hover:bg-[#e6f4ea] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-green-700 transition-colors">Profil Saya</h3>
                        <p class="text-[10px] text-gray-400 leading-tight">Kelola data profil</p>
                        <div class="mt-auto pt-3 flex justify-end w-full">
                            <div class="w-5 h-5 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-green-50 text-gray-400 group-hover:text-green-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
window.absensiApp = function(sesiId, daftarRombel, initialStats, initialBuktiUploaded) {
    return {
        sesiId: sesiId,
        students: [], 
        searchQuery: '',
        currentPage: 1,
        perPage: 20,
        stats: initialStats,
        buktiUploaded: initialBuktiUploaded,
        isUploading: false,
        isPolling: false,
        
        async uploadBukti(event) {
            this.isUploading = true;
            const form = event.target;
            const formData = new FormData(form);
            
            try {
                // Route for upload is generated dynamically via blade in the form action
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.status === 419) {
                    if (confirm('Sesi login Anda telah berakhir. Halaman perlu di-refresh. Klik OK untuk refresh.')) {
                        window.location.reload();
                    }
                    return;
                }
                
                const result = await response.json();
                if (result.success) {
                    this.buktiUploaded = true;
                } else {
                    alert(result.message || 'Gagal mengupload bukti.');
                }
            } catch (error) {
                alert('Terjadi kesalahan saat mengupload bukti.');
            } finally {
                this.isUploading = false;
            }
        },
        
        init() {
            let flat = [];
            daftarRombel.forEach(r => {
                r.siswa.forEach(s => {
                    flat.push({ ...s, rombel_nama: r.rombel_nama });
                });
            });
            this.students = flat;
            
            if (!this.isPolling) {
                this.isPolling = true;
                this.startPolling();
            }
        },

        confirmFinishSesi() {
            let noBukti = !this.buktiUploaded;
            
            // Hitung siswa yang belum selesai dikonfirmasi
            let belumKonfirmasi = this.students.filter(s => !['hadir_valid', 'sakit', 'izin', 'tidak_hadir'].includes(s.status)).length;
            
            let warningText = '';
            let icon = 'question';
            
            if (noBukti) {
                icon = 'warning';
                warningText = "<div style='background: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: bold;'>⚠️ PERINGATAN:<br>Anda BELUM mengunggah Foto Bukti Mengajar!</div>";
                warningText += "<span style='font-size: 14px; color: #4b5563;'>Sistem menyarankan Anda untuk mengunggah bukti terlebih dahulu sebelum menyelesaikan sesi.</span>";
            } else if (belumKonfirmasi > 0) {
                icon = 'warning';
                warningText = `<div style='background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: bold;'>⚠️ PERHATIAN:<br>Ada ${belumKonfirmasi} siswa yang belum dikonfirmasi statusnya!</div>`;
                warningText += "<span style='font-size: 14px; color: #4b5563;'>Siswa yang belum konfirmasi akan otomatis ditandai <b>tidak hadir</b> jika Anda menyelesaikan sesi sekarang.</span>";
            } else {
                warningText = "<span style='font-size: 14px; color: #4b5563;'>Semua siswa sudah dikonfirmasi dan bukti mengajar sudah diunggah. Sesi ini siap untuk ditutup dan direkap.</span>";
            }

            Swal.fire({
                title: '<span style="font-size: 20px;">Yakin ingin menyelesaikan sesi ini?</span>',
                html: warningText,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#f3f4f6',
                confirmButtonText: 'Ya, Selesaikan',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    actions: 'group gap-3',
                    confirmButton: 'px-5 py-2.5 rounded-lg font-semibold transition-colors border-0 bg-red-600 text-white group-hover:bg-gray-100 group-hover:text-gray-700 hover:!bg-red-600 hover:!text-white',
                    cancelButton: 'px-5 py-2.5 rounded-lg font-semibold transition-colors border-0 bg-gray-100 text-gray-700 hover:!bg-red-600 hover:!text-white'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-finish-' + this.sesiId).submit();
                }
            });
        },
        
        get filteredStudents() {
            if (this.searchQuery.trim() === '') return this.students;
            return this.students.filter(s => s.nama.toLowerCase().includes(this.searchQuery.toLowerCase()));
        },
        
        get paginatedStudents() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredStudents.slice(start, end);
        },
        
        get totalPages() {
            return Math.ceil(this.filteredStudents.length / this.perPage);
        },
        
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                // Scroll tepat ke bagian tabel, bukan ke awal card
                const tableContainer = document.getElementById('tabel-absensi-' + this.sesiId);
                if (tableContainer) {
                    tableContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        },

        togglePanggil(siswa, isChecked) {
            const targetStatus = isChecked ? 'menunggu_konfirmasi' : 'belum_diabsen';
            this.markStatus(siswa.id, targetStatus);
        },
        
        async markStatus(siswaId, targetStatus) {
            const student = this.students.find(s => s.id === siswaId);
            if (!student) return;

            // Jangan izinkan ubah manual jika sudah hadir/sakit/izin (kecuali dibatalkan/menunggu)
            // Meskipun disabled, kita cegah di logic.
            
            const oldStatus = student.status;
            student.status = targetStatus;
            
            try {
                const res = await fetch(`/guru/sesi-les/${this.sesiId}/mark-status/${siswaId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: targetStatus })
                });
                
                if (res.status === 419) {
                    // Refresh CSRF token meta dan minta user reload
                    if (confirm('Sesi login Anda telah berakhir. Halaman perlu di-refresh. Klik OK untuk refresh.')) {
                        window.location.reload();
                    }
                    return;
                }
                
                const data = await res.json();
                if (data.success) {
                    student.status = data.status;
                    if (data.stats) this.stats = data.stats;
                } else {
                    student.status = oldStatus;
                    alert(data.message || 'Gagal menyimpan.');
                }
            } catch (err) {
                student.status = oldStatus;
                alert('Terjadi kesalahan jaringan.');
            }
        },
        
        startPolling() {
            const poll = async () => {
                try {
                    const res = await fetch(`/guru/sesi-les/${this.sesiId}/absensi-status`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    
                    if (data.success && data.sesi_status === 'berjalan') {
                        if (data.stats) this.stats = data.stats;
                        
                        if (data.daftar_rombel) {
                            data.daftar_rombel.forEach(r => {
                                r.siswa.forEach(s => {
                                    const student = this.students.find(x => x.id === s.id);
                                    if (student && student.status !== s.status) {
                                        student.status = s.status;
                                    }
                                });
                            });
                        }
                    }
                } catch (err) {}
                
                setTimeout(poll, 10000);
            };
            
            setTimeout(poll, 10000);
        }
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

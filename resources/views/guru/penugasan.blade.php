@extends('layouts.guru')

@section('header', 'Penugasan Saya')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Daftar Penugasan</h2>
        <p class="text-sm text-gray-500 mt-1">Berikut adalah mata pelajaran dan rombel yang ditugaskan kepada Anda oleh admin.</p>
    </div>
</div>

@if($penugasans->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-10 text-center border-2 border-dashed border-gray-200">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Penugasan</h3>
        <p class="text-gray-500 max-w-md mx-auto">Admin belum memberikan tugas mata pelajaran dan rombel kepada Anda. Silakan hubungi admin sekolah jika ada kesalahan.</p>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($penugasans as $penugasan)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Mapel -->
            <div class="bg-indigo-50/50 p-5 border-b border-gray-100 flex items-start gap-4">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-700 font-bold rounded-xl flex items-center justify-center shrink-0 border border-indigo-200">
                    {{ substr($penugasan->mata_pelajaran->nama, 0, 3) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $penugasan->mata_pelajaran->nama }}</h3>
                    <p class="text-sm text-indigo-600 font-medium">Mata Pelajaran Diampu</p>
                </div>
            </div>
            
            <!-- Daftar Rombel -->
            <div class="p-5">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Rombel yang Diajar:</h4>
                
                @if($penugasan->penugasan_rombels->isEmpty())
                    <p class="text-sm text-gray-500 italic">Belum ada rombel yang diatur untuk mata pelajaran ini.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($penugasan->penugasan_rombels as $pr)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                            {{ $pr->rombel->nama }}
                        </span>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Footer Action -->
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                <a href="{{ route('guru.sesi-les.create') }}?mapel_id={{ $penugasan->mata_pelajaran_id }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    Buat Sesi untuk Mapel Ini
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection

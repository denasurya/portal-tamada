@extends('layouts.guru')

@section('header', 'Daftar Sesi Les')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-8 text-center border-2 border-dashed border-gray-200">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
    </div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">Sesi Les Saya</h2>
    <p class="text-gray-500 max-w-md mx-auto mb-6">Untuk melihat sesi les yang sedang berjalan, silakan kunjungi halaman Dashboard. Untuk membuat sesi baru, klik tombol di bawah ini.</p>
    
    <a href="{{ route('guru.sesi-les.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
        Buat Sesi Baru
    </a>
</div>
@endsection

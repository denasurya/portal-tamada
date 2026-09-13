@extends('layouts.guru')

@section('header', 'Profil Saya')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl mx-auto">
    <div class="bg-indigo-600 h-32"></div>
    <div class="px-8 pb-8">
        <div class="relative flex justify-center -mt-16 mb-4">
            <div class="w-32 h-32 bg-white rounded-full p-2">
                <div class="w-full h-full bg-indigo-100 rounded-full flex items-center justify-center text-4xl font-bold text-indigo-600">
                    {{ substr(Auth::user()->guru->nama_guru ?? Auth::user()->username, 0, 1) }}
                </div>
            </div>
        </div>
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->guru->nama_guru ?? Auth::user()->username }}</h2>
            <p class="text-indigo-600 font-medium">Pengajar</p>
        </div>

        <div class="space-y-4">
            <div class="border rounded-lg p-4 flex justify-between items-center bg-gray-50">
                <span class="text-gray-500 font-medium">Username Akun</span>
                <span class="text-gray-800 font-bold">{{ Auth::user()->username }}</span>
            </div>
            
            <div class="border rounded-lg p-4 flex justify-between items-center bg-gray-50">
                <span class="text-gray-500 font-medium">Status</span>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">Aktif</span>
            </div>
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-400">
            *Untuk mengubah password atau data diri, silakan hubungi Administrator.
        </div>
    </div>
</div>
@endsection

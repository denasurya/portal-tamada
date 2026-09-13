@extends('layouts.app')

@section('content')
<!-- Fullscreen Background Override -->
<div class="fixed inset-0 z-0 h-screen w-full bg-gradient-to-br from-[#e1ede6] via-[#f4f7f6] to-[#d4e2da] overflow-hidden flex flex-col items-center justify-center p-3 sm:p-4">
    
    <!-- Main Card -->
    <div class="relative z-10 w-full max-w-[420px] bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] flex flex-col border border-white/60 mb-8 max-h-[88vh]">
        
        <!-- Scrollable Content Area (in case screen is extremely small) -->
        <div class="p-5 sm:p-6 pb-4 overflow-y-auto" style="scrollbar-width: thin;">
            <!-- Logo & Titles -->
            <div class="flex flex-col items-center text-center mb-5">
                <img src="{{ asset('logo.png') }}" alt="Logo SMK Tamtama 2 Sidareja" class="h-20 sm:h-24 w-auto mb-3 drop-shadow-sm">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#094d34] tracking-tight mb-1 leading-none">TAMADA</h1>
                <h2 class="text-[13px] sm:text-sm font-bold text-[#1e293b] mb-2">Sistem Informasi Terpadu</h2>
                
                <div class="w-10 h-1 bg-[#4ade80] rounded-full mb-2"></div>
                
                <h3 class="text-[13px] sm:text-sm font-bold text-[#0e5c3e] mb-0.5">SMK Tamtama 2 Sidareja</h3>
                <p class="text-[11px] sm:text-xs text-gray-500 leading-snug px-2 font-medium">
                    Satu Akses, Banyak Layanan, untuk Kemajuan Bersama
                </p>
            </div>

            <div x-data="{ tab: 'siswa', showPassword: false }">
                <!-- Role Tabs -->
                <div class="flex bg-[#f8faf9] p-1 rounded-lg mb-5 border border-gray-200/70 items-center">
                    <button type="button" @click="tab = 'siswa'" :class="tab === 'siswa' ? 'bg-[#156a44] text-white shadow-sm' : 'text-gray-600 hover:text-[#156a44] hover:bg-gray-100'" class="flex-1 py-1.5 text-[12px] font-semibold rounded-md transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.22 4.622 1 1 0 01-.89.89 8.969 8.969 0 00-1.05.174v-4.102L13 10.12v4.815a9.025 9.025 0 00-3.7 1.638z"></path></svg>
                        Siswa
                    </button>
                    
                    <div class="h-4 w-px bg-gray-300 mx-0.5" x-show="tab !== 'siswa' && tab !== 'guru'"></div>
                    
                    <button type="button" @click="tab = 'guru'" :class="tab === 'guru' ? 'bg-[#156a44] text-white shadow-sm' : 'text-gray-600 hover:text-[#156a44] hover:bg-gray-100'" class="flex-1 py-1.5 text-[12px] font-semibold rounded-md transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        Guru / Staff
                    </button>
                    
                    <div class="h-4 w-px bg-gray-300 mx-0.5" x-show="tab !== 'guru' && tab !== 'admin'"></div>

                    <button type="button" @click="tab = 'admin'" :class="tab === 'admin' ? 'bg-[#156a44] text-white shadow-sm' : 'text-gray-600 hover:text-[#156a44] hover:bg-gray-100'" class="flex-1 py-1.5 text-[12px] font-semibold rounded-md transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                        Admin
                    </button>
                </div>

                <!-- Form -->
                <form class="space-y-3" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    @if($errors->any())
                        <div class="bg-red-50 text-red-700 p-2.5 rounded-lg text-xs border border-red-100 flex items-start gap-1.5 mb-3">
                            <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Username Field -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-[16px] w-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input id="username" name="username" type="text" required 
                            class="block w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#156a44] focus:border-[#156a44] transition-colors text-[13px] font-medium" 
                            :placeholder="tab === 'siswa' ? 'Masukkan NISN' : (tab === 'guru' ? 'Username Guru/Staff' : 'Username Admin')">
                    </div>

                    <!-- Password Field -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-[16px] w-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required 
                            class="block w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#156a44] focus:border-[#156a44] transition-colors text-[13px] font-medium" 
                            placeholder="Password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" @click="showPassword = !showPassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!showPassword" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="pt-1.5">
                        <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-[14px] font-bold text-white bg-[#156a44] hover:bg-[#105636] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#156a44] transition-all gap-2 group">
                            Masuk 
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                    
                    <!-- Options -->
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-3.5 w-3.5 text-[#156a44] focus:ring-[#156a44] border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-1.5 block text-[12px] text-gray-700 cursor-pointer">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-[12px]">
                            <a href="#" class="font-semibold text-[#156a44] hover:text-[#105636]">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Bottom Menu Icons -->
        <div class="border-t border-gray-100 bg-[#fafafa] p-3 rounded-b-2xl shrink-0">
            <div class="grid grid-cols-5 text-center divide-x divide-gray-200">
                <a href="#" class="flex flex-col items-center gap-1 text-gray-500 hover:text-[#156a44] transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-medium hidden sm:block">Akademik</span>
                    <span class="text-[9px] font-medium sm:hidden">Akademik</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-1 text-gray-500 hover:text-[#156a44] transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-medium hidden sm:block">Kesiswaan</span>
                    <span class="text-[9px] font-medium sm:hidden">Siswa</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-1 text-gray-500 hover:text-[#156a44] transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-medium hidden sm:block">Absensi</span>
                    <span class="text-[9px] font-medium sm:hidden">Absen</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-1 text-gray-500 hover:text-[#156a44] transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-medium hidden sm:block">Pembayaran</span>
                    <span class="text-[9px] font-medium sm:hidden">Bayar</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-1 text-gray-500 hover:text-[#156a44] transition-colors">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-medium hidden sm:block">Lainnya</span>
                    <span class="text-[9px] font-medium sm:hidden">Lainnya</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Footer Credits (Fixed tightly at the bottom) -->
    <div class="absolute bottom-3 left-0 right-0 text-center text-[10px] sm:text-[11px] text-[#4b6a5b] font-medium z-10 drop-shadow-sm flex flex-col gap-0.5">
        <span>&copy; {{ date('Y') }} SMK Tamtama 2 Sidareja</span>
        <span>TAMADA - Sistem Informasi Terpadu - Bersama Membangun Generasi Unggul</span>
    </div>
</div>
@endsection

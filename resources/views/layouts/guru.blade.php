<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Guru - TAMADA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f7f5;
        }
        [x-cloak] { display: none !important; }
        .menu-item-green {
            transition: all 0.2s ease-in-out;
        }
        .menu-item-green:hover {
            background-color: #16a34a !important; /* Tailwind green-600 */
            color: #ffffff !important;
        }
        .menu-item-green:hover svg {
            color: #ffffff !important;
        }
        .menu-active-green {
            background-color: #15803d !important; /* Tailwind green-700 */
            color: #ffffff !important;
            font-weight: 600;
        }
        .menu-active-green svg {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="text-gray-800 antialiased" hx-boost="true">
    @php
        $mapels = '';
        if (Auth::user() && Auth::user()->guru) {
            $mapels = Auth::user()->guru->guru_mapels->map(function($gm) {
                return $gm->mata_pelajaran->nama;
            })->implode(', ');
        }
        $roleText = $mapels ? 'Guru ' . $mapels : 'Guru';
    @endphp
    <div x-data="{ sidebarOpen: $persist(true) }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="flex-shrink-0 bg-white border-r border-green-50 transition-all duration-300 flex flex-col relative z-20">
            <!-- Logo Area -->
            <div class="py-6 flex flex-col items-center justify-center border-b border-gray-50">
                <img src="{{ asset('logo.png') }}" alt="TAMADA Logo" class="w-20 h-auto object-contain mb-3 transition-all duration-300" :class="!sidebarOpen && 'w-10'">
                <div x-show="sidebarOpen" class="text-center transition-opacity duration-300">
                    <h1 class="text-green-800 font-bold text-lg tracking-wide leading-tight">TAMADA</h1>
                    <p class="text-[10px] text-green-600 font-medium tracking-wide">SMK Tamtama 2 Sidareja</p>
                    <p class="text-xs font-semibold text-gray-700 mt-1">Portal Guru</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1 custom-scrollbar">
                
                <!-- Dashboard -->
                <a href="{{ route('guru.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.dashboard') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.dashboard') ? 'text-white' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" /><path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" /></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Dashboard</span>
                </a>
                
                <div x-show="sidebarOpen" class="px-3 pt-4 pb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">PEMBELAJARAN</div>
                
                <!-- Sesi Les -->
                <a href="{{ route('guru.sesi-les.index') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.sesi-les.index') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.sesi-les.index') ? 'text-white' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Sesi Les</span>
                </a>

                <!-- Buat Sesi -->
                <a href="{{ route('guru.sesi-les.create') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.sesi-les.create') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.sesi-les.create') ? 'text-white' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Buat Sesi</span>
                </a>

                <!-- Histori -->
                <a href="{{ route('guru.histori.index') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.histori.*') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.histori.*') ? 'text-white' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Histori</span>
                </a>

                <div x-show="sidebarOpen" class="px-3 pt-4 pb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">LAINNYA</div>

                <!-- Penugasan Saya -->
                <a href="{{ route('guru.penugasan') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.penugasan') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.penugasan') ? 'text-white' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Penugasan Saya</span>
                </a>

                <!-- Profil -->
                <a href="{{ route('guru.profil') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('guru.profil') ? 'menu-active-green shadow-sm' : 'text-gray-600 menu-item-green' }} group">
                    <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.profil') ? 'text-white' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Profil</span>
                </a>
            </div>

            <!-- Profile & Logout (Bottom) -->
            <div class="mt-auto px-3 py-3 border-t border-gray-50" x-show="sidebarOpen">
                <div class="bg-gray-50 rounded-xl p-2 mb-2 flex items-center">
                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold overflow-hidden shrink-0">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="h-full w-full object-cover">
                        @else
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        @endif
                    </div>
                    <div class="ml-2 overflow-hidden flex-1">
                        <p class="text-[11px] font-bold text-gray-800 truncate" title="{{ Auth::user()->guru->nama_guru ?? Auth::user()->username ?? 'Guru' }}">{{ Auth::user()->guru->nama_guru ?? Auth::user()->username ?? 'Guru' }}</p>
                        <p class="text-[9px] text-gray-500 truncate" title="{{ $roleText }}">{{ $roleText }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-2 py-1.5 text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                        <svg class="h-4 w-4 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
                <div class="mt-2 text-[9px] leading-tight text-gray-400 text-center">
                    &copy; 2026 TAMADA<br>SMK Tamtama 2 Sidareja<br>v1.0.0
                </div>
            </div>
            
            <div class="mt-auto py-4 flex flex-col items-center border-t border-gray-50" x-show="!sidebarOpen">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Logout">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Abstract background shape (Optional, based on image showing faint green shapes) -->
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[50%] bg-gradient-to-bl from-green-100 to-transparent rounded-full opacity-50 blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-5%] w-[30%] h-[40%] bg-gradient-to-tr from-green-100 to-transparent rounded-full opacity-50 blur-3xl"></div>
            </div>

            <!-- Top navbar -->
            <header class="bg-transparent z-10 h-16 flex items-center justify-between px-6">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-green-600 focus:outline-none bg-white p-2 rounded-xl shadow-sm border border-gray-100 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-bold text-gray-800 hidden sm:block">
                        @yield('header', 'Portal Guru')
                    </h2>
                </div>
                
                <div class="flex items-center space-x-5">
                    <!-- Notification Bell -->
                    <button class="relative text-gray-500 hover:text-green-600 transition-colors p-2 bg-white rounded-xl shadow-sm border border-gray-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-2 h-2 w-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    
                    <!-- Top Profile -->
                    <div class="flex items-center gap-3 bg-white pl-2 pr-4 py-1.5 rounded-full shadow-sm border border-gray-100 cursor-pointer hover:bg-gray-50 transition-colors">
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold overflow-hidden">
                             @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="h-full w-full object-cover">
                            @else
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            @endif
                        </div>
                        <div class="hidden md:block max-w-[130px]">
                            <p class="text-xs font-bold text-gray-800 truncate" title="{{ Auth::user()->guru->nama_guru ?? Auth::user()->username ?? 'Guru' }}">{{ Auth::user()->guru->nama_guru ?? Auth::user()->username ?? 'Guru' }}</p>
                            <p class="text-[10px] text-gray-500 truncate" title="{{ $roleText }}">{{ $roleText }}</p>
                        </div>
                        <svg class="h-4 w-4 text-gray-400 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:px-8 lg:py-6 z-10 custom-scrollbar">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-100 flex items-center shadow-sm">
                        <svg class="h-5 w-5 text-green-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-100 flex items-center shadow-sm">
                        <svg class="h-5 w-5 text-red-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 20px;
        }
    </style>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Admin - TKA 2026/2027</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="flex-shrink-0 bg-indigo-800 text-white transition-all duration-300 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-indigo-700 px-4">
                <span x-show="sidebarOpen" class="text-xl font-bold whitespace-nowrap">Portal Admin</span>
                <span x-show="!sidebarOpen" class="text-xl font-bold">PA</span>
            </div>
            
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="space-y-1 px-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                    </a>
                    
                    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Master Data</div>
                    <!-- Master Jurusan -->
                    <a href="{{ route('admin.jurusan.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Master Jurusan</span>
                    </a>
                    <!-- Master Rombel -->
                    <a href="{{ route('admin.rombel.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Master Rombel</span>
                    </a>
                    <!-- Master Mata Pelajaran -->
                    <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Mata Pelajaran</span>
                    </a>
                    <!-- Master Guru -->
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Master Guru</span>
                    </a>
                    <!-- Master Siswa -->
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Master Siswa</span>
                    </a>

                    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Sistem</div>
                    <!-- User Management -->
                    <a href="{{ route('admin.user.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">User Management</span>
                    </a>
                    <!-- Manajemen Sesi -->
                    <a href="{{ route('admin.sesi.index') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Manajemen Sesi</span>
                    </a>
                    <!-- Aktivitas Sistem -->
                    <a href="{{ route('admin.system.activity_log') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Aktivitas Sistem</span>
                    </a>
                    <!-- Pengaturan -->
                    <a href="{{ route('admin.system.settings') }}" class="flex items-center px-2 py-2.5 rounded-lg text-indigo-100 hover:bg-indigo-700 hover:text-white group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Pengaturan</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top navbar -->
            <header class="bg-white shadow-sm border-b z-10 h-16 flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-md">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="ml-4 text-xl font-semibold text-gray-800 hidden sm:block">
                        @yield('header', 'Admin Panel')
                    </h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm font-medium text-gray-600">
                        {{ Auth::user()->nama_lengkap ?: (Auth::user()->username ?? 'Admin') }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-medium transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

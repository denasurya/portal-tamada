<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Kepsek - TKA 2026/2027</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="flex-shrink-0 bg-indigo-800 text-white transition-all duration-300 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-indigo-700 px-4">
                <span x-show="sidebarOpen" class="text-xl font-bold whitespace-nowrap">Portal Kepsek</span>
                <span x-show="!sidebarOpen" class="text-xl font-bold">PK</span>
            </div>
            
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="space-y-1 px-2">
                    <!-- Dashboard / Command Center -->
                    <a href="{{ route('kepsek.dashboard') }}" class="flex items-center px-2 py-2.5 rounded-lg {{ request()->routeIs('kepsek.dashboard') ? 'bg-indigo-900 text-white font-semibold' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Command Center</span>
                    </a>
                    
                    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Laporan</div>
                    
                    <!-- Histori Sesi -->
                    <a href="{{ route('kepsek.histori.index') }}" class="flex items-center px-2 py-2.5 rounded-lg {{ request()->routeIs('kepsek.histori.*') ? 'bg-indigo-900 text-white font-semibold' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} group">
                        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-show="sidebarOpen" class="ml-3">Histori Laporan</span>
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
                        @yield('header', 'Portal Kepsek')
                    </h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm font-medium text-gray-600">
                        {{ Auth::user()->nama_lengkap ?: (Auth::user()->username ?? 'Kepala Sekolah') }}
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

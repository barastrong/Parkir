<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EasyParkir') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sidebar-bg': '#3B82F6', // Blue 500 - Biru terang
                        'sidebar-active': '#1D4ED8', // Blue 700 - Biru gelap untuk active
                        'sidebar-hover': '#2563EB', // Blue 600 - Biru untuk hover
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-scroll::-webkit-scrollbar { display: none; }
        .sidebar-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        .main-content {
            min-height: calc(100vh - 2rem);
        }
        
        .nav-link {
            transition: all 0.2s ease-in-out;
        }
        
        .nav-link:hover {
            transform: translateX(4px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="relative min-h-screen lg:flex">
        
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-sidebar-bg text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-xl">
            
            <div class="flex items-center justify-center h-20 flex-shrink-0 border-b border-white/20">
                <a href="#" class="flex items-center space-x-2 px-4">
                    <span class="bg-white text-sidebar-bg font-bold text-xl w-9 h-9 flex items-center justify-center rounded-lg shadow-sm">P</span>
                    <span class="text-xl font-bold text-white">EasyParkir</span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                @php
                    function isLinkActive($path) {
                        return request()->is($path) || request()->routeIs($path) ? 'bg-sidebar-active border-white shadow-lg' : 'border-transparent hover:bg-sidebar-hover hover:border-white/50';
                    }
                @endphp

                <a href="{{ route('parkir.dashboard') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('parkir.dashboard') }} transition-all duration-200">
                    <i class="fas fa-tachometer-alt w-8 text-center text-lg"></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>
                
                @if(optional(Auth::user())->role === 'admin')
                    <div class="space-y-1">
                        <div class="pt-2 pb-1">
                            <div class="border-t border-white/10"></div>
                        </div>
                        
                        <a href="{{ route('users.dashboard') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('users.*') }} transition-all duration-200">
                            <i class="fas fa-users w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Manajemen User</span>
                        </a>
                        
                        <a href="{{ route('kendaraanmasuk.dashboard') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('kendaraanmasuk.*') }} transition-all duration-200">
                            <i class="fas fa-plus-circle w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Kendaraan Masuk</span>
                        </a>
                        
                        <a href="{{ route('riwayatkeluar.dashboard') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('riwayatkeluar.*') }} transition-all duration-200">
                            <i class="fas fa-check-circle w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Kendaraan Keluar</span>
                        </a>
                        
                        <a href="" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('kendaraan.parkir') }} transition-all duration-200">
                            <i class="fas fa-list-ul w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Kendaraan Parkir</span>
                        </a>
                        
                        <a href="{{ route('parkir.slot') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('parkir.slot') }} transition-all duration-200">
                            <i class="fas fa-th-large w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Slot Parkir</span>
                        </a>
                        
                        <a href="{{ route('parkir.jenis-kendaraan.index') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('parkir.jenis-kendaraan.*') }} transition-all duration-200">
                            <i class="fas fa-truck w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Jenis Kendaraan</span>
                        </a>
                        
                        <a href="" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('laporan.*') }} transition-all duration-200">
                            <i class="fas fa-file-lines w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Laporan Parkir</span>
                        </a>
                    </div>
                @else
                    <div class="space-y-1">
                        <div class="pt-2 pb-1">
                            <div class="border-t border-white/10"></div>
                        </div>
                        
                        <a href="" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('kendaraan.masuk') }} transition-all duration-200">
                            <i class="fas fa-plus-circle w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Kendaraan Masuk</span>
                        </a>
                        
                        <a href="" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('kendaraan.keluar') }} transition-all duration-200">
                            <i class="fas fa-check-circle w-8 text-center text-lg"></i>
                            <span class="ml-3 font-medium">Kendaraan Keluar</span>
                        </a>
                    </div>
                @endif
                
                <div class="pt-2 pb-1">
                    <div class="border-t border-white/10"></div>
                </div>
                
                <a href="{{ route('dashboard') }}" class="nav-link flex items-center pl-3 pr-4 py-3 rounded-lg border-l-4 {{ isLinkActive('public.*') }} transition-all duration-200">
                    <i class="fas fa-globe w-8 text-center text-lg"></i>
                    <span class="ml-3 font-medium">Halaman Publik</span>
                </a>
            </nav>

            <!-- User Profile & Logout -->
            <div class="px-4 pb-6 mt-auto">
                <div class="pt-4 mt-4 border-t border-white/20">
                    <a href="#" class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-sidebar-hover transition-colors duration-200">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-white/20" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(optional(Auth::user())->name ?? 'User') }}&background=E0E7FF&color=3B82F6" 
                             alt="Avatar">
                        <div class="ml-3 text-left">
                            <p class="text-sm font-semibold text-white">{{ optional(Auth::user())->name ?? 'User' }}</p>
                            <p class="text-xs text-blue-200 capitalize">{{ optional(Auth::user())->role ?? 'guest' }}</p>
                        </div>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full flex items-center pl-3 pr-4 py-2.5 text-red-300 hover:bg-red-500 hover:text-white rounded-lg transition-colors duration-200 group">
                            <i class="fas fa-power-off w-8 text-center text-lg group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="ml-3 font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen">
            <header class="flex items-center justify-between p-4 bg-white border-b border-gray-200 lg:hidden shadow-sm">
                <a href="#" class="flex items-center space-x-2">
                    <span class="bg-sidebar-bg text-white font-bold text-lg w-8 h-8 flex items-center justify-center rounded-lg">P</span>
                    <span class="text-lg font-bold text-sidebar-bg">EasyParkir</span>
                </a>
                <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-8 bg-gray-100 overflow-y-auto main-content">
                @yield('content')
            </main>
        </div>

        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden transition-opacity duration-300" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>
    </div>
</body>
</html>
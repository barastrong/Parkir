<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EasyParkir') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            
            <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('dashboard')}}" class="flex items-center space-x-2">
                                <span class="bg-blue-600 text-white font-bold text-xl w-9 h-9 flex items-center justify-center rounded-lg">P</span>
                                <span class="text-xl font-bold text-blue-600">EasyParkir</span>
                            </a>
                        </div>

                        <!-- Desktop Menu -->
                        <div class="hidden md:flex items-center space-x-8">
                            @guest
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                                    <i class="fas fa-home mr-2"></i>Beranda
                                </a>
                                <a href="#" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition duration-200">
                                    <i class="fas fa-search mr-2"></i>Cek Parkir
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-semibold rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                                </a>
                            @else
                                <div class="flex items-center space-x-5">
                                    <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none transition duration-200">
                                        <i class="fas fa-bell fa-lg"></i>
                                        <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">3</span>
                                    </button>
                                    
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="flex items-center space-x-2 text-sm focus:outline-none">
                                            <img class="h-9 w-9 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="User Avatar">
                                            <div class="text-left hidden sm:block">
                                                <div class="font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-gray-500">Admin</div>
                                            </div>
                                            <i class="fas fa-chevron-down text-xs text-gray-500 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">Profil</a>
                                            <div class="border-t border-gray-100"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">Keluar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-200">
                                <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                                <i class="fas fa-times text-lg" x-show="mobileMenuOpen"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="md:hidden border-t border-gray-200 bg-white">
                        <div class="px-2 pt-2 pb-3 space-y-1">
                            @guest
                                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-600 hover:text-blue-600 hover:bg-gray-50 font-medium rounded-md transition duration-200">
                                    <i class="fas fa-home mr-2"></i>Beranda
                                </a>
                                <a href="#" class="block px-3 py-2 text-gray-600 hover:text-blue-600 hover:bg-gray-50 font-medium rounded-md transition duration-200">
                                    <i class="fas fa-search mr-2"></i>Cek Parkir
                                </a>
                                <a href="{{ route('login') }}" class="block px-3 py-2 text-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-md border border-blue-600 text-center transition duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                                </a>
                            @else
                                <div class="flex items-center px-3 py-2 space-x-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="User Avatar">
                                    <div>
                                        <div class="font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">Admin</div>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                                            <i class="fas fa-bell fa-lg"></i>
                                            <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">3</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <a href="#" class="block px-3 py-2 text-gray-600 hover:text-blue-600 hover:bg-gray-50 font-medium rounded-md transition duration-200">
                                        <i class="fas fa-user mr-2"></i>Profil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-3 py-2 text-gray-600 hover:text-red-600 hover:bg-gray-50 font-medium rounded-md transition duration-200">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
            @endif

            <main class="flex-grow py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <footer class="bg-white border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    © {{ date('Y') }} EasyParkir. All Rights Reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
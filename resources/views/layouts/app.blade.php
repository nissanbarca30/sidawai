<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="main-html" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIDAWAI') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:wght@400;600;800;900&display=swap" rel="stylesheet">

    <!-- Scripts (Vite & Local Assets) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('aset/css/getboot.min.css') }}" rel="stylesheet">

    <!-- Tailwind CSS CDN dengan konfigurasi Dark Mode class -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    @livewireStyles
    <style>
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
    <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col font-sans">
        <div id="app" class="flex flex-col min-h-screen">
            
            <!-- Navbar Header -->
            <nav class="bg-[#40BF89] dark:bg-[#1a8a5f] px-3 sm:px-6 py-3 shadow-sm transition-colors duration-300 relative z-20">
                <div class="container-fluid flex justify-between items-center px-1 sm:px-4">
                    
                    <!-- Logo -->
                    <a class="flex items-center space-x-2 sm:space-x-4 no-underline text-white hover:text-white shrink" href="{{ url('/home') }}">
                        <img src="{{ asset('assets/logo/kemenkes_bkk.png') }}" alt="Logo Kemenkes" class="h-10 sm:h-14 w-auto object-contain brightness-0 invert me-1 sm:me-3">
                        <div class="h-8 sm:h-12 w-[1.5px] bg-white opacity-80"></div>
                        <div class="flex flex-col justify-center text-left leading-none min-w-0">
                            <span class="text-white text-lg sm:text-2xl font-black tracking-wider uppercase drop-shadow-sm truncate">
                                SIDAWAI
                            </span>
                            <span class="text-white text-[9px] sm:text-[11px] font-bold tracking-wide uppercase opacity-90 mt-0.5 sm:mt-1 truncate">
                                BKK KELAS I PONTIANAK
                            </span>
                        </div>
                    </a>

                    <!-- Tombol Darkmode & Auth Profil -->
                    <div class="flex items-center space-x-3 sm:space-x-4 shrink-0">

                        <button 
                            type="button" 
                            onclick="toggleFrontendTheme()" 
                            class="text-white hover:text-emerald-100 p-1.5 rounded-full hover:bg-white/10 transition flex items-center justify-center focus:outline-none"
                            title="Ganti Mode Tampilan (Terang / Gelap)"
                        >
                            <svg id="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            
                            <svg id="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>

                        @guest
                            @php
                                // Cek status pendaftaran dari database (1 = Terbuka, 0 = Terkunci/Hide)
                                $allowRegister = \App\Models\Setting::get('allow_register', '1') == '1';
                            @endphp

                            {{-- Tombol Register hanya tampil (unhide) jika pendaftaran dibuka --}}
                            @if ($allowRegister && Route::has('register'))
                                <a class="text-white font-bold no-underline hover:underline text-xs sm:text-sm transition-all duration-200" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <div class="relative flex items-center">
                                <span class="hidden sm:inline text-white font-extrabold text-base sm:text-lg mr-2 select-none truncate max-w-[150px]">
                                    {{ Auth::user()->name }}
                                </span>
                                
                                <button
                                    type="button" id="userDropdown" class="text-white p-1 rounded-full border-0 flex items-center justify-center focus:outline-none hover:opacity-80 transition cursor-pointer" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-9 sm:w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9" />
                                        <circle cx="12" cy="9" r="2.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 18c.8-2.2 2.4-3.5 4.5-3.5s3.7 1.3 4.5 3.5"/>
                                    </svg>
                                </button>

                                <div
                                    id="profileDropdown" class="hidden absolute right-0 top-full mt-3 w-48 bg-white dark:bg-gray-800 border-2 border-black dark:border-gray-600 rounded-lg shadow-lg overflow-hidden z-50">
                                    
                                    <!-- Nama User Khusus Tampilan Mobile -->
                                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 sm:hidden">
                                        <span class="block text-xs text-gray-500 dark:text-gray-300 font-bold">Login sebagai:</span>
                                        <span class="block text-sm font-extrabold text-black dark:text-white truncate">{{ Auth::user()->name }}</span>
                                    </div>

                                    <!-- Menu Profil Saya -->
                                    <a href="{{ route('profile.edit') }}" class="w-full px-4 py-3 text-black dark:text-white font-extrabold text-sm flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition no-underline border-b border-gray-200 dark:border-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#40BF89]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>

                                    <!-- Menu Logout -->
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit" 
                                            class="w-full px-4 py-3 text-black dark:text-white font-extrabold text-sm flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>

            <main class="flex-grow flex items-center justify-center p-3 sm:p-4 bg-[length:100%_100%] bg-center bg-no-repeat relative"
                style="background-image: url('{{ asset('assets/logo/bg_projek.jpg') }}');">

                <div class="absolute inset-0 bg-black/5 dark:bg-black/30 pointer-events-none"></div>

                <div class="relative z-10 w-full flex justify-center">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 py-6 mt-auto transition-colors duration-300 relative z-20">
                <div class="container mx-auto px-4 flex flex-col items-center justify-center text-center space-y-2">
                    <div class="w-12 h-1 rounded-full mb-1" style="background-color: #40BF89;"></div>
                    <p class="text-gray-700 dark:text-gray-300 font-bold text-sm sm:text-base m-0">
                        &copy; {{ date('Y') }} Balai Kekarantinaan Kesehatan (BKK) Pontianak.
                    </p>
                    <p class="text-gray-400 dark:text-gray-400 font-semibold text-xs sm:text-sm m-0">
                        Sistem Dokumentasi dan Arsip Pegawai - Developed by 
                        <a href="https://instagram.com/nissan.gianda" target="_blank" rel="noopener noreferrer" class="text-[#40BF89] hover:text-[#32996e] dark:text-[#40BF89] dark:hover:text-[#52d69e] underline font-bold transition-colors">
                            Nafil
                        </a>
                    </p>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('aset/js/jquery.min.js') }}" defer></script>
        @livewireScripts
        
        <script>
            function toggleFrontendTheme() {
                const htmlTag = document.documentElement;
                const isDark = htmlTag.classList.contains('dark');

                if (isDark) {
                    htmlTag.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    htmlTag.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateFrontendIcons();
            }

            function updateFrontendIcons() {
                const htmlTag = document.documentElement;
                const moonIcon = document.getElementById('theme-icon-moon');
                const sunIcon = document.getElementById('theme-icon-sun');
                const isDark = htmlTag.classList.contains('dark');

                if (moonIcon && sunIcon) {
                    if (isDark) {
                        moonIcon.classList.add('hidden');
                        sunIcon.classList.remove('hidden');
                    } else {
                        moonIcon.classList.remove('hidden');
                        sunIcon.classList.add('hidden');
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                updateFrontendIcons();

                const userDropdown = document.getElementById('userDropdown');
                const profileDropdown = document.getElementById('profileDropdown');

                if (userDropdown && profileDropdown) {
                    userDropdown.addEventListener('click', function (event) {
                        event.stopPropagation();
                        profileDropdown.classList.toggle('hidden');

                        const isOpen = !profileDropdown.classList.contains('hidden');
                        userDropdown.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    });

                    document.addEventListener('click', function (event) {
                        if (!profileDropdown.contains(event.target) && !userDropdown.contains(event.target)) {
                            profileDropdown.classList.add('hidden');
                            userDropdown.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
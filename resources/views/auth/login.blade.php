@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 my-6 transition-colors duration-300">
    <div class="text-white text-center py-4 bg-[#40BF89] dark:bg-[#1a8a5f] transition-colors duration-300">
        <h3 class="m-0 font-extrabold text-2xl tracking-wide uppercase">LOGIN</h3>
        <small id="subtitle-absen" class="opacity-75">Masukkan NIP dan password Anda</small>
    </div>

    <div class="p-6">
        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700 text-xs font-bold text-center">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="nip" class="block text-black dark:text-gray-200 font-extrabold mb-1.5 text-sm">
                    Nomor Induk Pegawai (NIP)
                </label>

                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 1992xxxx" required autofocus class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#40BF89] dark:focus:bg-[#161a1e] transition-colors">
                @error('nip')
                    <span class="text-red-600 dark:text-red-400 text-xs font-bold mt-1 block">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-black dark:text-gray-200 font-extrabold mb-1.5 text-sm">
                    Password
                </label>

                <div class="relative">
                    <input 
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 pr-12 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#40BF89] dark:focus:bg-[#161a1e] transition-colors"
                    >

                    <button
                        type="button"
                        id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400 hover:text-[#40BF89] dark:hover:text-[#40BF89] transition"
                        aria-label="Tampilkan password"
                    >
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3l18 18M10.58 10.58a2 2 0 102.83 2.83M9.88 4.24A9.77 9.77 0 0112 4c5 0 9.27 3.11 10.5 8a10.05 10.05 0 01-4.13 5.74M6.23 6.23A10.05 10.05 0 003.5 12c.61 2.39 2.02 4.36 3.87 5.74A9.77 9.77 0 0012 20c1.61 0 3.13-.38 4.5-1.06" />
                        </svg>

                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.46 12C3.73 7.94 7.52 5 12 5s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7s-8.27-2.94-9.54-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>

                @error('password')
                    <span class="text-red-600 dark:text-red-400 text-xs font-bold mt-1 block">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-2">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-black dark:text-gray-300 font-extrabold text-sm hover:underline no-underline">
                        Lupa Password?
                    </a>
                @else
                    <a href="#"
                        class="text-black dark:text-gray-300 font-extrabold text-sm hover:underline no-underline">
                        Lupa Password?
                    </a>
                @endif

                <button 
                    type="submit"
                    class="bg-[#40BF89] dark:bg-[#1a8a5f] text-white font-extrabold py-2 px-7 rounded-full hover:bg-emerald-600 dark:hover:bg-emerald-700 transition duration-150 text-sm border-2 border-[#40BF89] dark:border-[#1a8a5f] shadow-sm">
                    Masuk
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/auth/login.js') }}"></script>
@endpush

@endsection
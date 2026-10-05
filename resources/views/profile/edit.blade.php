@extends('layouts.app')

@section('content')
<div class="w-full max-w-2xl mx-auto my-6 px-3 sm:px-0">
    <div class="bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 transition-colors duration-300">
        
        <!-- Header -->
        <div class="bg-[#40BF89] dark:bg-[#1a8a5f] py-4 px-6 text-white flex items-center gap-2 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h3 class="font-extrabold text-xl tracking-wide m-0">Edit Data: {{ $user->name }}</h3>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="p-3.5 bg-emerald-100 dark:bg-emerald-900/40 border border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300 text-sm font-bold rounded-xl mb-5">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-gray-800 dark:text-gray-200 font-extrabold text-sm mb-1">Nama Lengkap Pegawai</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-black dark:text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-[#40BF89]">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-gray-800 dark:text-gray-200 font-extrabold text-sm mb-1">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}" required
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-black dark:text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-[#40BF89]">
                    @error('nip') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-800 dark:text-gray-200 font-extrabold text-sm mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-black dark:text-white font-bold text-sm focus:outline-none focus:ring-2 focus:ring-[#40BF89]">
                    @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Password Baru (Opsional) -->
                <div>
                    <label for="password" class="block text-gray-800 dark:text-gray-200 font-extrabold text-sm mb-1">Password Baru (Opsional)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin merubah password"
                            class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg pl-4 pr-11 py-2.5 text-black dark:text-white placeholder-gray-400 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-[#40BF89]">
                        <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                            </svg>
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 flex justify-between items-center border-t border-gray-100 dark:border-gray-700/60 mt-6">
                    <a href="{{ route('home') }}" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-extrabold py-2 px-5 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm flex items-center gap-1.5 no-underline shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Batal</span>
                    </a>

                    <button type="submit" class="bg-[#40BF89] dark:bg-[#1a8a5f] text-white font-extrabold py-2.5 px-6 rounded-lg hover:bg-emerald-600 dark:hover:bg-emerald-700 transition text-sm flex items-center gap-2 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/profile/edit.js') }}"></script>
@endpush

@endsection
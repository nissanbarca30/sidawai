@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 my-6 transition-colors duration-300">
    <div class="text-white text-center py-4 bg-[#40BF89] dark:bg-[#1a8a5f] transition-colors duration-300">
        <h3 class="m-0 font-extrabold text-2xl tracking-wide uppercase">Password Baru</h3>
        <small class="opacity-80">Buat password baru akun Anda</small>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Alamat Email</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ $email ?? old('email') }}" 
                    required 
                    autocomplete="email" 
                    readonly
                    class="w-full bg-gray-200 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 font-bold text-sm focus:outline-none"
                >
                @error('email')
                    <span class="text-red-600 dark:text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Password Baru</label>
                <div class="relative">
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Masukkan password baru"
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg pl-4 pr-11 py-2.5 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#40BF89] font-bold text-sm"
                    >
                    <button 
                        type="button" 
                        id="togglePassword" 
                        aria-label="Tampilkan password"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none"
                    >
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
                @error('password')
                    <span class="text-red-600 dark:text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input 
                        id="password-confirm" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Ulangi password baru"
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg pl-4 pr-11 py-2.5 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#40BF89] font-bold text-sm"
                    >
                    <button 
                        type="button" 
                        id="togglePasswordConfirm" 
                        aria-label="Tampilkan konfirmasi password"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none"
                    >
                        <svg id="eyeClosedConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                        <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="pt-3">
                <button 
                    type="submit" 
                    class="w-full bg-[#40BF89] dark:bg-[#1a8a5f] text-white font-extrabold py-2.5 px-6 rounded-full hover:bg-emerald-600 dark:hover:bg-emerald-700 transition duration-150 text-sm border-2 border-[#40BF89] dark:border-[#1a8a5f] shadow-sm uppercase tracking-wider">
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/auth/password/reset.js') }}"></script>
@endpush

@endsection
@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 my-6 transition-colors duration-300">
    <div class="text-white text-center py-4 bg-[#40BF89] dark:bg-[#1a8a5f] transition-colors duration-300">
        <h3 class="m-0 font-extrabold text-2xl tracking-wide uppercase">Reset Password</h3>
        <small class="opacity-80">Masukkan Email terdaftar Anda</small>
    </div>

    <div class="p-6">
        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700 text-xs font-bold text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-black dark:text-gray-200 font-extrabold mb-1.5 text-sm">
                    Alamat Email
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Contoh: user@gmail.com"
                    required 
                    autocomplete="email" 
                    autofocus
                    class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#40BF89] dark:focus:bg-[#161a1e] transition-colors font-bold text-sm"
                >
                @error('email')
                    <span class="text-red-600 dark:text-red-400 text-xs font-bold mt-1 block">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="flex items-center justify-between pt-3">
                <a href="{{ route('login') }}" class="text-black dark:text-gray-300 font-extrabold text-sm hover:underline no-underline">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="bg-[#40BF89] dark:bg-[#1a8a5f] text-white font-extrabold py-2 px-6 rounded-full hover:bg-emerald-600 dark:hover:bg-emerald-700 transition duration-150 text-sm border-2 border-[#40BF89] dark:border-[#1a8a5f] shadow-sm">
                    Kirim Link Reset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="w-full max-w-xl mx-auto my-6">
    <div class="bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 flex flex-col transition-colors duration-300">
        <div class="bg-[#40BF89] dark:bg-[#1a8a5f] py-5 px-6 text-center transition-colors duration-300">
            <h2 class="text-white text-2xl font-black tracking-wide uppercase mb-0">
                Rincian Data Dukung
            </h2>
        </div>

        <div class="p-6 space-y-5 bg-white dark:bg-[#1e232a] transition-colors duration-300">
            <!-- Nama -->
            <div class="grid grid-cols-12 items-center text-gray-800 dark:text-gray-200 font-extrabold text-base">
                <span class="col-span-4 text-gray-500 dark:text-gray-400 font-bold">Nama</span>
                <span class="col-span-8 text-black dark:text-white">: {{ $document->user->name }}</span>
            </div>

            <!-- Tgl Tidak Hadir -->
            <div class="grid grid-cols-12 items-center text-gray-800 dark:text-gray-200 font-extrabold text-base">
                <span class="col-span-4 text-gray-500 dark:text-gray-400 font-bold">Tgl tidak Hadir</span>
                <span class="col-span-8 text-black dark:text-white">: {{ \Carbon\Carbon::parse($document->tanggal)->translatedFormat('d F Y') }}</span>
            </div>

            <div>
                <p class="text-gray-500 dark:text-gray-400 font-bold text-sm mb-2">Keterangan</p>
                <div class="bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 p-3.5 rounded-xl text-black dark:text-gray-100 font-extrabold text-sm leading-relaxed transition-colors">
                    {{ $document->keterangan }}
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ route('document.preview', $document->id) }}" 
                   target="_blank" 
                   class="inline-flex items-center space-x-3 text-black dark:text-emerald-400 font-extrabold hover:text-[#40BF89] dark:hover:text-emerald-300 transition no-underline group">
                    <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg group-hover:bg-[#40BF89]/10 dark:group-hover:bg-emerald-500/20 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black dark:text-emerald-400 group-hover:text-[#40BF89] dark:group-hover:text-emerald-300 shrink-0 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-base tracking-wide underline uppercase truncate max-w-xs sm:max-w-md">{{ $document->file_name }}</span>
                </a>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700/60">
                <a href="{{ route('document.month', ['bulan' => $document->bulan_periode ?? \Carbon\Carbon::parse($document->tanggal)->translatedFormat('F')]) }}" 
                   class="bg-white dark:bg-gray-800 text-black dark:text-white font-extrabold py-2 px-7 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm border-2 border-black dark:border-gray-500 shadow-sm no-underline flex items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
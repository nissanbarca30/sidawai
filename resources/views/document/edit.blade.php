@extends('layouts.app')

@section('content')
<div class="w-full max-w-xl mx-auto my-6">
    <div class="bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 flex flex-col transition-colors duration-300">
        <div class="bg-[#40BF89] dark:bg-[#1a8a5f] py-5 px-6 text-center transition-colors duration-300">
            <h2 class="text-white text-2xl font-black tracking-wide uppercase mb-0">
                Edit {{ $document->kategori === 'rekap_presensi' ? 'Rekap Presensi' : 'Data Dukung' }}
            </h2>
        </div>

        <div class="p-6 bg-white dark:bg-[#1e232a] transition-colors duration-300">
            <form action="{{ route('document.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                @if($document->kategori === 'data_dukung')
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="tanggal_mulai" class="block text-gray-700 dark:text-gray-200 font-extrabold mb-1.5 text-sm">Mulai Tgl</label>
                                <input 
                                    type="date" 
                                    id="tanggal_mulai" 
                                    name="tanggal_mulai" 
                                    value="{{ old('tanggal_mulai', $document->tanggal) }}"
                                    required 
                                    class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-black dark:text-white font-extrabold focus:outline-none focus:ring-2 focus:ring-[#40BF89] [color-scheme:light] dark:[color-scheme:dark]"
                                >
                            </div>
                            <div>
                                <label for="tanggal_selesai" class="block text-gray-700 dark:text-gray-200 font-extrabold mb-1.5 text-sm">S/d Tgl (Opsional)</label>
                                <input 
                                    type="date" 
                                    id="tanggal_selesai" 
                                    name="tanggal_selesai" 
                                    class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-black dark:text-white font-extrabold focus:outline-none focus:ring-2 focus:ring-[#40BF89] [color-scheme:light] dark:[color-scheme:dark]"
                                >
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 dark:text-gray-400 font-bold block">*Kosongkan "S/d Tgl" jika hanya 1 hari ketidakhadiran.</span>
                    </div>
                @endif

                <div>
                    <label for="keterangan" class="block text-gray-700 dark:text-gray-200 font-extrabold mb-1.5 text-sm">Keterangan</label>
                    @php
                        // Bersihkan teks prefix otomatis agar user hanya mengedit alasan utama
                        $cleanKeterangan = preg_replace('/^\(Izin Tgl [0-9\/]+ s\/d [0-9\/]+\)\s*/', '', $document->keterangan);
                        $cleanKeterangan = str_replace('[REKAP PRESENSI] ', '', $cleanKeterangan);
                    @endphp
                    <textarea 
                        id="keterangan" 
                        name="keterangan" 
                        rows="3" 
                        required 
                        class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-black dark:text-white font-extrabold focus:outline-none focus:ring-2 focus:ring-[#40BF89] placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                    >{{ old('keterangan', $cleanKeterangan) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-extrabold mb-1.5 text-sm">File Lampiran</label>
                    <div class="mb-2 text-xs text-gray-500 dark:text-gray-400 font-bold flex items-center space-x-1">
                        <span>File saat ini:</span>
                        <span class="text-black dark:text-emerald-400 underline truncate max-w-xs">{{ $document->file_name }}</span>
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="text" 
                            id="file_name_display" 
                            readonly 
                            placeholder="Ganti file (opsional)..." 
                            class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border border-gray-300 dark:border-gray-600 border-r-0 rounded-l-lg px-3 py-2 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-bold text-sm focus:outline-none"
                        >
                        <label for="lampiran" class="bg-white dark:bg-gray-800 text-black dark:text-white font-extrabold px-4 py-2 rounded-r-lg border border-gray-300 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm shrink-0 border-l-0">
                            Browse
                        </label>
                        <input 
                            type="file" 
                            id="lampiran" 
                            name="lampiran" 
                            class="hidden" 
                            onchange="document.getElementById('file_name_display').value = this.files[0] ? this.files[0].name : ''"
                        >
                    </div>
                    <span class="text-xs text-gray-400 dark:text-gray-400 mt-1 block">*Biarkan kosong jika tidak ingin mengganti file.</span>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700/60">
                    <a href="{{ route('document.month', $document->bulan_periode) }}" 
                       class="bg-white dark:bg-gray-800 text-black dark:text-white font-extrabold py-2 px-6 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm border-2 border-black dark:border-gray-500 no-underline shadow-sm">
                        Batal
                    </a>
                    
                    <button 
                        type="submit" 
                        class="bg-[#40BF89] dark:bg-[#1a8a5f] text-white font-extrabold py-2 px-7 rounded-full hover:opacity-90 transition text-sm shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
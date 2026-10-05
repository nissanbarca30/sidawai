@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 my-6 transition-colors duration-300">
    <div class="text-white text-center py-4 bg-[#40BF89] dark:bg-[#1a8a5f] transition-colors duration-300">
        <h3 class="m-0 font-extrabold text-2xl tracking-wide uppercase">Form Input Dokumen</h3>
        <small id="subtitle-absen" class="opacity-90">Upload Data Dukung atau Rekap Presensi</small>
    </div>

    <div class="p-6">
        <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="kategori" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Kategori Dokumen</label>
                <select 
                    id="kategori" 
                    name="kategori" 
                    required 
                    class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 rounded px-3 py-2 font-bold text-black dark:text-white focus:outline-none cursor-pointer transition-colors"
                    onchange="toggleCategoryInput(this.value)"
                >
                    <option value="data_dukung" class="dark:bg-[#1e232a]">Data Dukung</option>
                    <option value="rekap_presensi" class="dark:bg-[#1e232a]">Rekap Presensi Bulanan</option>
                </select>
            </div>

            <div id="section-tanggal" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="tanggal_mulai" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Mulai Tgl</label>
                        <input 
                            type="date" 
                            id="tanggal_mulai" 
                            name="tanggal_mulai" 
                            required 
                            class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 rounded px-2.5 py-1.5 font-bold text-black dark:text-white focus:outline-none text-sm [color-scheme:light] dark:[color-scheme:dark]"
                        >
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">S/d Tgl (Opsional)</label>
                        <input 
                            type="date" 
                            id="tanggal_selesai" 
                            name="tanggal_selesai" 
                            class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 rounded px-2.5 py-1.5 font-bold text-black dark:text-white focus:outline-none text-sm [color-scheme:light] dark:[color-scheme:dark]"
                        >
                    </div>
                </div>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 font-bold block">*Isi "S/d Tgl" jika tidak hadir berturut-turut lebih dari 1 hari.</span>
            </div>

            <div>
                <label for="keterangan" class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Keterangan</label>
                <textarea 
                    id="keterangan" 
                    name="keterangan" 
                    rows="3" 
                    required 
                    placeholder="Masukkan keterangan dokumen..."
                    class="w-full bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 rounded px-3 py-2 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 font-bold focus:outline-none transition-colors"
                ></textarea>
            </div>

            <div>
                <label class="block text-black dark:text-gray-200 font-extrabold mb-1 text-sm">Lampiran File Dokumen</label>
                <div 
                    id="dropzone-area" 
                    class="relative border-2 border-dashed border-black dark:border-gray-500 rounded-xl p-5 text-center bg-[#f0f0f0] dark:bg-[#161a1e] hover:bg-emerald-50/50 dark:hover:bg-gray-800/60 transition-all cursor-pointer group"
                    onclick="document.getElementById('lampiran').click();"
                    ondragover="handleDragOver(event)"
                    ondragleave="handleDragLeave(event)"
                    ondrop="handleDrop(event)"
                >
                    <input 
                        type="file" 
                        id="lampiran" 
                        name="lampiran[]" 
                        multiple 
                        required 
                        class="hidden" 
                        onchange="updateFileList(this.files)"
                    >

                    <div id="dropzone-prompt" class="space-y-2">
                        <div class="mx-auto w-12 h-12 rounded-full bg-white dark:bg-gray-800 border-2 border-black dark:border-gray-400 flex items-center justify-center text-black dark:text-white group-hover:scale-110 transition-transform shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-black dark:text-gray-200 m-0">
                                Drag & Drop file ke sini, atau <span class="underline text-[#40BF89]">Browse</span>
                            </p>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 font-bold block mt-1">Bisa pilih beberapa file sekaligus (PDF, PNG, JPG)</span>
                        </div>
                    </div>

                    <div id="file-list-container" class="hidden text-left space-y-1.5 mt-2">
                        <p class="text-xs font-black text-black dark:text-gray-200 uppercase tracking-wider mb-2 border-b border-black/20 dark:border-gray-700 pb-1">
                            File Terpilih (<span id="file-count">0</span>):
                        </p>
                        <div id="file-names-list" class="max-h-32 overflow-y-auto space-y-1 pr-1"></div>
                        <button 
                            type="button" 
                            onclick="event.stopPropagation(); resetFiles();" 
                            class="text-xs font-extrabold text-red-600 dark:text-red-400 hover:underline mt-2 inline-block">
                            Ganti File
                        </button>
                    </div>

                </div>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('home') }}" class="bg-white dark:bg-gray-800 text-black dark:text-white font-extrabold py-1.5 px-6 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm border-2 border-black dark:border-gray-500 no-underline shadow-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-white dark:bg-gray-800 text-black dark:text-white 
                        font-extrabold py-1.5 px-8 rounded-full hover:bg-gray-100 
                        dark:hover:bg-gray-700 transition text-sm border-2 border-black 
                        dark:border-gray-500 shadow">Submit
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/document/documentcreate.js') }}"></script>
@endpush

@endsection
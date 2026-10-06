@extends('layouts.app')

@section('content') 
<div class="w-full max-w-4xl bg-white dark:bg-[#1e232a] border border-gray-200 dark:border-gray-700/60 rounded-2xl shadow-xl overflow-hidden min-h-[500px] flex flex-col mx-auto my-6 transition-colors duration-300">
    <div class="bg-[#40BF89] dark:bg-[#1a8a5f] p-6 space-y-4 transition-colors duration-300">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full">
            
            <!-- Tombol Upload Data -->
            <a href="{{ route('document.create') }}" class="bg-white dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 px-4 py-2 rounded-md font-extrabold flex items-center justify-center space-x-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-600 dark:text-white no-underline shrink-0 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span>Upload Data</span>
            </a>

            <!-- Dropdown Filter Tahun (Otomatis berganti) -->
            <form id="filter-year-form" method="GET" action="{{ route('home') }}" class="shrink-0">
                <select name="tahun" 
                        onchange="document.getElementById('filter-year-form').submit()" 
                        class="bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 text-gray-800 dark:text-white font-extrabold px-3 py-2 rounded-md focus:outline-none cursor-pointer transition-all">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            Tahun {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Input Pencarian Real-time (Mencari Bulan di Tahun Pilihan) -->
            <div class="relative w-full flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                    
                <input type="text" id="search-input" placeholder="Cari data bulan di {{ $selectedYear }}....." class="w-full pl-10 pr-10 py-2 bg-[#f0f0f0] dark:bg-[#161a1e] border-2 border-black dark:border-gray-600 rounded-md font-bold text-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none transition-all" autocomplete="off">
                
                <!-- Tombol Clear/Reset -->
                <button type="button" id="clear-search" class="absolute inset-y-0 right-0 flex items-center pr-3 hidden text-gray-600 dark:text-gray-300 hover:opacity-70 focus:outline-none" title="Reset Pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <section class="p-6 border-b border-gray-200 dark:border-gray-700/60">
        <form method="POST" action="{{ route('home.ai-preferences') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <h2 class="text-lg font-extrabold text-gray-800 dark:text-white">Preferensi Model AI</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pilihan ini disimpan untuk akun Anda. Integrasi AI belum diaktifkan.
                </p>
            </div>

            @if (session('status'))
                <p role="status" class="text-sm font-bold text-emerald-700 dark:text-emerald-400">
                    {{ session('status') }}
                </p>
            @endif

            @if ($errors->any())
                <p role="alert" class="text-sm font-bold text-red-600 dark:text-red-400">
                    {{ $errors->first() }}
                </p>
            @endif

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <label for="ai_provider" class="block mb-1 text-sm font-bold text-gray-700 dark:text-gray-200">Provider</label>
                    <select id="ai_provider" name="ai_provider" required
                            class="w-full px-3 py-2 rounded-md border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-[#161a1e] text-gray-800 dark:text-white">
                        @foreach ($aiProviders as $provider => $models)
                            <option value="{{ $provider }}" {{ $selectedProvider === $provider ? 'selected' : '' }}>
                                {{ ucfirst($provider) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label for="ai_model" class="block mb-1 text-sm font-bold text-gray-700 dark:text-gray-200">Model</label>
                    <select id="ai_model" name="ai_model" required
                            class="w-full px-3 py-2 rounded-md border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-[#161a1e] text-gray-800 dark:text-white">
                        @foreach ($aiProviders as $provider => $models)
                            @foreach ($models as $model => $label)
                                <option value="{{ $model }}" data-provider="{{ $provider }}"
                                        {{ $selectedModel === $model ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="sm:self-end">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-md bg-[#40BF89] hover:bg-[#35a977] text-white font-bold transition-colors">
                        Simpan Preferensi
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- Body Tabel (Daftar Folder Bulan) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#f8fafc] dark:bg-[#1e232a] border-b border-gray-200 dark:border-gray-700/60 text-gray-500 dark:text-gray-400 uppercase text-xs font-black tracking-wider transition-colors duration-300">
                    <th scope="col" class="py-4 px-6">PERIODE BULAN</th>
                    <th scope="col" class="py-4 px-6 text-center">TAHUN</th>
                    <th scope="col" class="py-4 px-6 text-right">AKSI & KONTROL</th>
                </tr>
            </thead>

            <!-- Body Tabel -->
            <tbody id="folder-list" class="divide-y divide-gray-100 dark:divide-gray-700/50 font-semibold text-gray-700 dark:text-gray-200">
                @forelse($documents as $index => $doc)
                    <tr class="folder-item hover:bg-emerald-50/40 dark:hover:bg-gray-700/30 transition-colors duration-150 group"
                        data-bulan="{{ strtolower($doc->bulan_periode) }}">
                        
                        <!-- Nama Bulan / Link Folder -->
                        <td class="py-4 px-6">
                            <a href="{{ route('document.month', ['bulan' => $doc->bulan_periode, 'tahun' => $doc->tahun_periode]) }}" 
                               class="flex items-center space-x-3 text-gray-800 dark:text-gray-100 hover:text-[#40BF89] dark:hover:text-[#40BF89] no-underline font-bold transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400 group-hover:scale-110 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="text-base">
                                    {{ $doc->bulan_periode }}
                                </span>
                            </a>
                        </td>

                        <!-- Tahun Periode -->
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                {{ $doc->tahun_periode }}
                            </span>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Buka Folder -->
                                <a href="{{ route('document.month', ['bulan' => $doc->bulan_periode, 'tahun' => $doc->tahun_periode]) }}" 
                                   class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-[#40BF89] text-[#40BF89] hover:bg-[#40BF89] hover:text-white transition-all text-xs font-bold no-underline"
                                   title="Buka Berkas Bulan Ini">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Lihat</span>
                                </a>

                                <!-- Download ZIP -->
                                <a href="{{ route('document.download', ['bulan' => $doc->bulan_periode, 'tahun' => $doc->tahun_periode]) }}" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-amber-400 bg-amber-400 text-white hover:bg-amber-500 hover:border-amber-500 transition-all text-xs font-bold no-underline shadow-sm shrink-0" title="Download ZIP">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white shrink-0 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1" />
                                        <path d="M12 4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    <span>ZIP</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center text-gray-400 dark:text-gray-500 font-bold">
                            Belum ada berkas dokumen yang diunggah untuk tahun {{ $selectedYear }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/homeblade.js') }}"></script>
    <script>
        const aiProviderSelect = document.getElementById('ai_provider');
        const aiModelSelect = document.getElementById('ai_model');

        function filterAiModels() {
            const availableModels = Array.from(aiModelSelect.options)
                .filter(option => option.dataset.provider === aiProviderSelect.value);

            aiModelSelect.querySelectorAll('option').forEach(option => {
                option.hidden = option.dataset.provider !== aiProviderSelect.value;
            });

            if (!availableModels.some(option => option.value === aiModelSelect.value)) {
                aiModelSelect.value = availableModels[0].value;
            }
        }

        aiProviderSelect.addEventListener('change', filterAiModels);
        filterAiModels();
    </script>
@endpush

@endsection
@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto">
    <div class="bg-white dark:bg-[#1e232a] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700/60 flex flex-col transition-colors duration-300">
        <div class="bg-[#40BF89] dark:bg-[#1a8a5f] px-6 py-5 flex justify-between items-center transition-colors duration-300">
            <h2 class="text-white text-xl sm:text-2xl font-black mb-0 tracking-wide">
                Folder Bulan {{ $bulan }}
            </h2>
            <a href="{{ route('home') }}" 
               class="bg-white dark:bg-gray-800 text-black dark:text-white font-extrabold py-2 px-6 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition text-sm border-2 border-black dark:border-gray-500 shadow-sm no-underline flex items-center space-x-1.5 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8fafc] dark:bg-[#1e232a] border-b border-gray-200 dark:border-gray-700/60 text-gray-500 dark:text-gray-400 uppercase text-xs font-black tracking-wider transition-colors duration-300">
                        <th scope="col" class="py-4 px-6 text-center w-12">NO</th>
                        <th scope="col" class="py-4 px-6">NAMA</th>
                        <th scope="col" class="py-4 px-6 text-center">KATEGORI</th>
                        <th scope="col" class="py-4 px-6">TANGGAL IZIN</th>
                        <th scope="col" class="py-4 px-6">KETERANGAN</th>
                        <th scope="col" class="py-4 px-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50 text-gray-700 dark:text-gray-200 text-sm font-semibold">
                    @forelse($documents as $index => $doc)
                        @php
                            $isRekap = (($doc->kategori ?? 'data_dukung') === 'rekap_presensi') || 
                                       \Illuminate\Support\Str::contains(strtolower($doc->keterangan ?? ''), 'rekap presensi');

                            $rawKeterangan = $doc->keterangan ?? '-';
                            $tanggalIzinTeks = '-';
                            $cleanKeterangan = $rawKeterangan;

                            if ($isRekap) {
                                // KHUSUS REKAP PRESENSI: Tanggal Izin dikosongkan (-), bersihkan tag [REKAP PRESENSI]
                                $cleanKeterangan = trim(str_replace(['[REKAP PRESENSI]', '[rekap presensi]'], '', $rawKeterangan));
                                $tanggalIzinTeks = '-';
                            } else {
                                // KHUSUS DATA DUKUNG: Ekstrak Teks Izin jika ada format "(Izin Tgl ...)"
                                if (preg_match('/\((Izin Tgl [^\)]+)\)/i', $rawKeterangan, $matches)) {
                                    $tanggalIzinTeks = $matches[1]; // Ambil isi misal "Izin Tgl 18/08/2026 s/d 22/09/2026"
                                    $cleanKeterangan = trim(str_replace($matches[0], '', $rawKeterangan)); // Hapus dari keterangan
                                } elseif (!empty($doc->tanggal)) {
                                    $tanggalIzinTeks = \Carbon\Carbon::parse($doc->tanggal)->format('d/m/Y');
                                }
                            }

                            if (empty($cleanKeterangan)) {
                                $cleanKeterangan = '-';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors duration-150">
                            <td class="py-4 px-6 text-center font-bold text-gray-800 dark:text-gray-200">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-4 px-6 font-bold text-gray-800 dark:text-gray-100 whitespace-nowrap">
                                {{ $doc->user->name ?? Auth::user()->name }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($isRekap)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-300 dark:border-blue-700">
                                        Rekap Presensi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">
                                        Data Dukung
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                @if(!$isRekap && $tanggalIzinTeks !== '-')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $tanggalIzinTeks }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 font-normal">-</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                {{ $cleanKeterangan }}
                            </td>

                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Detail -->
                                    <a href="{{ route('document.show', $doc->id) }}" 
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 border border-amber-400 text-amber-600 dark:text-amber-400 rounded-lg text-xs font-bold hover:bg-amber-50 dark:hover:bg-amber-950/30 transition no-underline shadow-sm"
                                       title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>

                                    <a href="{{ route('document.edit', $doc->id) }}" 
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 border border-blue-400 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-blue-50 dark:hover:bg-blue-950/30 transition no-underline shadow-sm"
                                       title="Edit Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form id="delete-form-{{ $doc->id }}" action="{{ route('document.destroy', $doc->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('{{ $doc->id }}')" 
                                                class="inline-flex items-center space-x-1 px-3 py-1.5 border border-red-400 text-red-600 dark:text-red-400 rounded-lg text-xs font-bold hover:bg-red-50 dark:hover:bg-red-950/30 transition shadow-sm"
                                                title="Hapus Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 font-bold text-gray-400 dark:text-gray-500 text-base">
                                Tidak ada dokumen pada bulan {{ $bulan }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/document/index_month.js') }}"></script>
@endpush

@endsection
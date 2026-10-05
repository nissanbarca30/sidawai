@extends('layouts.admin')

@section('header', 'Berkas Dokumen Pegawai')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #40BF89;">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.documents.user', $user->id) }}" class="btn btn-sm btn-outline-secondary fw-bold">
                        <i class="bi bi-arrow-left"></i> Kembali ke Folder
                    </a>
                    <span class="fw-bold fs-5 text-body">Berkas {{ $user->name }} (Bulan: {{ $bulan }})</span>
                </div>
            </div>

            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show fw-bold text-sm m-3" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-body-secondary text-uppercase fw-bold small">
                            <tr>
                                <th class="py-3 px-3 text-center" style="width: 50px;">NO</th>
                                <th class="py-3 px-3 text-center">KATEGORI</th>
                                <th class="py-3 px-3">TANGGAL IZIN</th>
                                <th class="py-3 px-3">KETERANGAN</th>
                                <th class="py-3 px-3 text-nowrap">TANGGAL UPLOAD</th>
                                <th class="py-3 px-3 text-center text-nowrap" style="min-width: 180px;">FILE LAMPIRAN & KONTROL</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold">
                            @forelse($documents as $index => $doc)
                                @php
                                    $isRekapPresensi = (isset($doc->kategori) && strtolower($doc->kategori) === 'rekap presensi') || 
                                                       (isset($doc->nama_dokumen) && \Illuminate\Support\Str::contains(strtolower($doc->nama_dokumen), 'rekap presensi')) ||
                                                       (isset($doc->keterangan) && \Illuminate\Support\Str::contains(strtolower($doc->keterangan), 'rekap presensi'));

                                    $rawKeterangan = $doc->keterangan ?? '-';

                                    $tanggalIzinTeks = '-';
                                    $cleanKeterangan = $rawKeterangan;

                                    if ($isRekapPresensi) {
                                        $cleanKeterangan = trim(str_replace(['[REKAP PRESENSI]', '[rekap presensi]'], '', $rawKeterangan));
                                        $tanggalIzinTeks = '-';
                                    } else {
                                        if (preg_match('/\((Izin Tgl [^\)]+)\)/i', $rawKeterangan, $matches)) {
                                            $tanggalIzinTeks = $matches[1];
                                            $cleanKeterangan = trim(str_replace($matches[0], '', $rawKeterangan));
                                        } elseif (!empty($doc->tanggal)) {
                                            $tanggalIzinTeks = \Carbon\Carbon::parse($doc->tanggal)->format('d/m/Y');
                                        }
                                    }

                                    if (empty($cleanKeterangan)) {
                                        $cleanKeterangan = '-';
                                    }

                                    $protectedFileUrl = route('admin.file.preview', $doc->id);

                                    if (empty($doc->share_token)) {
                                        $doc->share_token = \Illuminate\Support\Str::random(40);
                                        $doc->save();
                                    }
                                    $publicShareUrl = route('document.shared.preview', $doc->share_token);
                                @endphp
                                <tr>
                                    <td class="py-3 px-3 text-center text-muted">{{ $index + 1 }}</td>
                                    <td class="py-3 px-3 text-center text-nowrap">
                                        @if($isRekapPresensi)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1.5 rounded-pill">
                                                Rekap Presensi
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1.5 rounded-pill" style="color: #40BF89 !important; border-color: #40BF89 !important;">
                                                Data Dukung
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-body text-nowrap">
                                        @if(!$isRekapPresensi && $tanggalIzinTeks !== '-')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-body-secondary text-body border">
                                                <i class="bi bi-calendar-event me-1 text-primary"></i> {{ $tanggalIzinTeks }}
                                            </span>
                                        @else
                                            <span class="text-muted fw-normal">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-body">
                                        {{ $cleanKeterangan }}
                                    </td>
                                    <td class="py-3 px-3 text-muted small text-nowrap">
                                        <i class="bi bi-clock me-1"></i> {{ $doc->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="py-3 px-3 text-center text-nowrap">
                                        <div class="d-inline-block d-md-none">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary fw-bold dropdown-toggle px-3" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        data-bs-boundary="window" 
                                                        aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical me-1"></i> Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border border-gray-200 dark:border-gray-700 rounded-3 py-2" style="z-index: 1060;">
                                                    @if($doc->file_path)
                                                        <li>
                                                            <a class="dropdown-item fw-bold text-success py-2 d-flex align-items-center" href="{{ $protectedFileUrl }}" target="_blank">
                                                                <i class="bi bi-file-earmark-pdf me-2 fs-6"></i> Lihat File
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="dropdown-item fw-bold text-dark dark:text-gray-200 py-2 d-flex align-items-center" onclick="copyToClipboard('{{ $publicShareUrl }}', this)">
                                                                <i class="bi bi-link-45deg me-2 fs-6"></i> <span class="btn-copy-text">Salin Link</span>
                                                            </button>
                                                        </li>
                                                        <li><hr class="dropdown-divider my-1"></li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item fw-bold text-warning py-2 d-flex align-items-center" href="{{ route('admin.documents.edit', $doc->id) }}">
                                                            <i class="bi bi-pencil-square me-2 fs-6"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item fw-bold text-danger py-2 d-flex align-items-center" onclick="confirmDelete('{{ $doc->id }}')">
                                                            <i class="bi bi-trash me-2 fs-6"></i> Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-inline-flex align-items-center gap-1 flex-nowrap justify-content-center">
                                            @if($doc->file_path)
                                                <a href="{{ $protectedFileUrl }}" target="_blank" class="btn btn-sm text-white fw-bold px-2.5 py-1.5 shadow-sm text-nowrap" style="background-color: #40BF89; border: none;" title="Lihat File PDF">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat File
                                                </a>

                                                <button type="button" 
                                                        onclick="copyToClipboard('{{ $publicShareUrl }}', this)" 
                                                        class="btn btn-sm btn-dark fw-bold px-2.5 py-1.5 shadow-sm text-nowrap" 
                                                        title="Salin Link Publik">
                                                    <i class="bi bi-link-45deg me-1"></i> <span class="btn-copy-text">Salin Link</span>
                                                </button>
                                            @else
                                                <span class="text-muted small me-2">Tanpa Lampiran</span>
                                            @endif

                                            <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-warning text-dark fw-bold px-2.5 py-1.5 shadow-sm text-nowrap" title="Edit Dokumen">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>

                                            <button type="button" 
                                                    onclick="confirmDelete('{{ $doc->id }}')" 
                                                    class="btn btn-sm btn-danger fw-bold px-2.5 py-1.5 shadow-sm text-nowrap" 
                                                    title="Hapus Dokumen">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $doc->id }}" 
                                              action="{{ route('admin.documents.destroy', $doc->id) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted fw-bold">Tidak ada file ditemukan dalam folder ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/documents/files.js') }}"></script>
@endpush

@endsection
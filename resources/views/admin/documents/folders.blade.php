@extends('layouts.admin')

@section('header', 'Folder Dokumen Pegawai')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #40BF89;">
                <div class="d-flex items-center align-items-center gap-2">
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-secondary fw-bold">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <span class="fw-bold fs-5 text-body">Folder Periode: {{ $user->name }}</span>
                </div>
                <button type="button" class="btn btn-sm text-white fw-bold px-3 py-2 rounded-2 shadow-sm" style="background-color: #40BF89;" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-upload me-1"></i> Upload Dokumen Pegawai
                </button>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show fw-bold text-sm mb-4" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row g-3">
                    @forelse($folders as $folder)
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.documents.files', ['userId' => $user->id, 'bulan' => $folder->bulan_periode]) }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm text-center p-3 h-100 transition rounded-3 bg-dark:bg-[#1e232a] border border-gray-100 dark:border-gray-700/60">
                                    <div class="my-2">
                                        <i class="bi bi-folder-fill text-warning" style="font-size: 3.5rem;"></i>
                                    </div>
                                    <h5 class="fw-extrabold text-gray-800 dark:text-gray-100 mb-1">{{ $folder->bulan_periode }}</h5>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1 rounded-pill small">
                                        Tahun {{ $folder->tahun_periode ?? date('Y') }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted font-semibold mt-2">Belum ada folder dokumen untuk pegawai ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background-color: #40BF89; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="modal-title fw-bold uppercase" id="uploadModalLabel">
                    <i class="bi bi-file-earmark-plus me-1"></i> Upload Dokumen: {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.documents.store_for_user', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 space-y-3">
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-bold text-gray-700 dark:text-gray-200 text-sm">Kategori Dokumen</label>
                        <select name="kategori" id="kategori" class="form-select bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 fw-bold" onchange="toggleAdminTanggal(this.value)" required>
                            <option value="data_dukung">Data Dukung</option>
                            <option value="rekap_presensi">Rekap Presensi Bulanan</option>
                        </select>
                    </div>

                    <div id="admin-section-tanggal" class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="tanggal_mulai" class="form-label fw-bold text-gray-700 dark:text-gray-200 text-sm">Mulai Tgl</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ date('Y-m-d') }}" class="form-control bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 fw-bold" required>
                            </div>
                            <div class="col-6">
                                <label for="tanggal_selesai" class="form-label fw-bold text-gray-700 dark:text-gray-200 text-sm">S/d Tgl (Opsional)</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 fw-bold">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold text-gray-700 dark:text-gray-200 text-sm">Keterangan / Alasan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 fw-bold" placeholder="Masukkan keterangan dokumen..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label fw-bold text-gray-700 dark:text-gray-200 text-sm">File Lampiran (PDF / Gambar)</label>
                        <input type="file" name="lampiran[]" id="lampiran" multiple class="form-control bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 fw-bold" required>
                    </div>
                </div>

                <div class="modal-footer bg-gray-50 dark:bg-gray-800/80 border-0 justify-content-between">
                    <button type="button" class="btn btn-secondary fw-bold px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-4 rounded-pill" style="background-color: #40BF89;">Submit Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/documents/folders.js') }}"></script>
@endpush

@endsection
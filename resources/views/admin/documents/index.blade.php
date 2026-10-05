@extends('layouts.admin')

@section('header', 'Monitoring Dokumen Pegawai')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">
                    <i class="bi bi-folder2-open me-2"></i>Pilih Pegawai untuk Melihat Dokumen
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row g-2 mb-4 align-items-center">
                    <div class="col-md-6 col-lg-7">
                        <div class="input-group">
                            <span class="input-group-text bg-body border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   id="search-pegawai" 
                                   class="form-control bg-body border-start-0 ps-0 fw-semibold" 
                                   placeholder="Ketik nama, NIP, atau email pegawai secara langsung..." 
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3">
                        <select id="sort-pegawai" class="form-select bg-body fw-semibold">
                            <option value="default">Urutkan: Default</option>
                            <option value="name_asc">Nama Pegawai (A - Z)</option>
                            <option value="name_desc">Nama Pegawai (Z - A)</option>
                            <option value="docs_desc">Berkas (Terbanyak)</option>
                            <option value="docs_asc">Berkas (Terdikit)</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-2 d-flex justify-content-md-end">
                        <div class="btn-group w-100 shadow-sm" role="group" aria-label="Layout View Switcher">
                            <button type="button" id="btn-view-grid" class="btn btn-outline-secondary active fw-bold d-flex align-items-center justify-content-center gap-1" title="Tampilan Kotak-kotak (Grid)">
                                <i class="bi bi-grid-fill"></i>
                                <span class="d-none d-xl-inline">Grid</span>
                            </button>
                            <button type="button" id="btn-view-list" class="btn btn-outline-secondary fw-bold d-flex align-items-center justify-content-center gap-1" title="Tampilan Detail Per Baris (List)">
                                <i class="bi bi-list-task"></i>
                                <span class="d-none d-xl-inline">List</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-3" id="pegawai-grid-view">
                    @forelse($users as $usr)
                        <div class="col-md-6 col-lg-4 pegawai-card-item" 
                             data-name="{{ strtolower($usr->name) }}" 
                             data-nip="{{ $usr->nip }}" 
                             data-email="{{ strtolower($usr->email) }}" 
                             data-docs="{{ $usr->documents_count }}">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle me-3 fs-3 flex-shrink-0">
                                        <i class="bi bi-person-bounding-box"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold mb-0 text-gray-800 dark:text-gray-100 text-truncate" title="{{ $usr->name }}">{{ $usr->name }}</h6>
                                        <small class="text-muted dark:text-gray-400 d-block text-truncate">NIP: {{ $usr->nip }}</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-gray-100 dark:border-gray-700/60 mt-auto">
                                    <span class="badge bg-body-secondary text-body border px-3 py-2 rounded-pill fw-bold">
                                        <i class="bi bi-file-earmark-text text-success me-1"></i> {{ $usr->documents_count }} Berkas
                                    </span>
                                    <a href="{{ route('admin.documents.user', $usr->id) }}" class="btn btn-sm text-white fw-bold px-3 shadow-sm" style="background-color: #40BF89; border: none;">
                                        Buka Folder <i class="bi bi-arrow-right-short ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted fw-bold">
                            Belum ada data pegawai.
                        </div>
                    @endforelse
                </div>

                <div id="pegawai-list-view" class="d-none">
                    <div class="table-responsive rounded-3 border border-gray-200 dark:border-gray-700">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-body-secondary text-uppercase fw-bold small">
                                <tr>
                                    <th class="py-3 px-4 text-center" style="width: 60px;">NO</th>
                                    <th class="py-3 px-4">NAMA PEGAWAI</th>
                                    <th class="py-3 px-4">NIP / EMAIL</th>
                                    <th class="py-3 px-4 text-center">TOTAL BERKAS</th>
                                    <th class="py-3 px-4 text-center">AKSI DOKUMEN</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold" id="pegawai-table-body">
                                @forelse($users as $index => $usr)
                                    <tr class="pegawai-row-item" data-name="{{ strtolower($usr->name) }}" data-nip="{{ $usr->nip }}" data-email="{{ strtolower($usr->email) }}" data-docs="{{ $usr->documents_count }}">
                                        <td class="py-3 px-4 text-center text-muted row-number">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-success bg-opacity-10 text-success rounded-circle me-3 fs-5 flex-shrink-0">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                                <span class="fw-bold text-gray-800 dark:text-gray-100">{{ $usr->name }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="py-3 px-4">
                                            <div class="text-gray-800 dark:text-gray-200 fw-bold">NIP: {{ $usr->nip }}</div>
                                            <div class="text-muted small">{{ $usr->email }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <span class="badge bg-body-secondary text-body border px-3 py-2 rounded-pill fw-bold">
                                                <i class="bi bi-file-earmark-text text-success me-1"></i> {{ $usr->documents_count }} Berkas
                                            </span>
                                        </td>
                                        
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('admin.documents.user', $usr->id) }}" class="btn btn-sm text-white fw-bold px-3 shadow-sm" style="background-color: #40BF89; border: none;">
                                                <i class="bi bi-folder2-open me-1"></i> Buka Folder
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted fw-bold">Belum ada data pegawai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="no-pegawai-found" class="text-center py-5 text-muted fw-bold d-none">
                    <i class="bi bi-person-x fs-1 d-block mb-2 text-warning"></i>
                    Data pegawai tidak ditemukan.
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/documents/index.js') }}"></script>
@endpush

@endsection
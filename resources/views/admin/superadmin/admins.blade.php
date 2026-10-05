@extends('layouts.admin')

@section('header', 'Kelola Hak Akses Admin')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">Manajemen Pengelola Sistem (Superadmin Area)</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-2">Halaman ini digunakan oleh <strong>Superadmin</strong> untuk mempromosikan Pegawai menjadi Admin, mengelola hak akses fitur spesifik per Admin, atau mencabut hak akses Admin kembali menjadi Pegawai biasa.</p>
                <div class="alert border-start border-4 mb-0" style="border-color: #ffc107 !important; background-color: rgba(255, 193, 7, 0.1);">
                    <strong class="text-body">Catatan Keamanan:</strong> <span class="text-body">Admin memiliki hak pengelolaan sistem. Sesuaikan hak akses fitur Admin hanya kepada pihak yang berwenang.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-body">
                    <i class="bi bi-shield-lock-fill me-2" style="color: #40BF89;"></i>Daftar Pengelola & Pegawai
                </h6>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show fw-bold text-sm mb-4" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.admins.index') }}" method="GET" class="row g-2 mb-4 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" id="search-admin" class="form-control border-start-0 ps-0 fw-semibold" placeholder="Cari nama, NIP, atau email..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="role" class="form-select fw-semibold" onchange="this.form.submit()">
                            <option value="">-- Semua Role --</option>
                            <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ request('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="sort" class="form-select fw-semibold" onchange="this.form.submit()">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Prioritas (Superadmin & Admin)</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama Pegawai (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Pegawai (Z-A)</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary w-100 fw-bold" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-body-secondary text-uppercase fw-bold small">
                            <tr>
                                <th class="py-3 px-4 text-center" style="width: 60px;">NO</th>
                                <th class="py-3 px-4">NAMA PEGAWAI</th>
                                <th class="py-3 px-4">NIP / EMAIL</th>
                                <th class="py-3 px-4 text-center">ROLE SAAT INI</th>
                                <th class="py-3 px-4 text-center">TINDAKAN (UBAH HAK AKSES)</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold">
                            @forelse($admins as $index => $adm)
                                <tr class="admin-row">
                                    <td class="py-3 px-4 text-center text-muted">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 text-body fw-bold">{{ $adm->name }}</td>
                                    <td class="py-3 px-4">
                                        <div class="text-body fw-bold">{{ $adm->nip }}</div>
                                        <div class="text-muted small">{{ $adm->email }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($adm->role === 'superadmin')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">SUPERADMIN</span>
                                        @elseif($adm->role === 'admin')
                                            <span class="badge px-3 py-2 rounded-pill shadow-sm text-white" style="background-color: #40BF89;">ADMIN</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm">PEGAWAI</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($adm->role === 'superadmin')
                                            <span class="badge bg-body-secondary text-body-tertiary border px-3 py-2">
                                                <i class="bi bi-lock-fill me-1"></i> Utama (Kunci)
                                            </span>
                                        @elseif($adm->role === 'admin')
                                            <div class="btn-group gap-1">
                                                <button type="button" class="btn btn-sm btn-info text-white fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#permissionsModal{{ $adm->id }}">
                                                    <i class="bi bi-shield-check me-1"></i> Kelola Fitur
                                                </button>

                                                <form id="demote-form-{{ $adm->id }}" action="{{ route('admin.admins.demote', $adm->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="button" onclick="confirmDemote('{{ $adm->id }}', '{{ $adm->name }}')" class="btn btn-sm btn-outline-warning fw-bold px-3 shadow-sm">
                                                        <i class="bi bi-shield-minus me-1"></i> Demote ke Pegawai
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="modal fade text-start" id="permissionsModal{{ $adm->id }}" tabindex="-1" aria-labelledby="permissionsModalLabel{{ $adm->id }}" aria-hidden="true" style="z-index: 1065;">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <div class="modal-header text-white" style="background-color: #40BF89; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                                                            <h5 class="modal-title fw-bold" id="permissionsModalLabel{{ $adm->id }}">
                                                                <i class="bi bi-person-gear me-2"></i> Hak Akses: {{ $adm->name }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.admins.update_permissions', $adm->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            
                                                            <div class="modal-body p-3 p-md-4">
                                                                <p class="text-body-secondary small mb-3 fw-semibold">
                                                                    Centang fitur yang diperbolehkan untuk diakses oleh <strong>{{ $adm->name }}</strong>:
                                                                </p>

                                                                @php
                                                                    $features = [
                                                                        'access_dashboard'  => ['Dashboard Admin & Monitoring', 'Melihat grafik statistik dan rekap data.'],
                                                                        'manage_users'      => ['Kelola Data Pegawai', 'Menambah, mengedit, dan hapus pegawai.'],
                                                                        'manage_documents'  => ['Kelola Dokumen Pegawai', 'Kelola folder, upload, & salin link.'],
                                                                    ];
                                                                @endphp

                                                                <div class="d-flex flex-column gap-3">
                                                                    @foreach($features as $key => [$title, $desc])
                                                                        <div class="p-3 bg-body-tertiary rounded-3 border d-flex align-items-center gap-3">
                                                                            <div class="form-check form-switch m-0 p-0 d-flex align-items-center">
                                                                                <input class="form-check-input m-0 perm-switch" type="checkbox" name="permissions[]" value="{{ $key }}" id="{{ $key }}_{{ $adm->id }}" @checked($adm->hasPermission($key))>
                                                                            </div>
                                                                            <label class="form-check-label flex-grow-1 m-0" role="button" for="{{ $key }}_{{ $adm->id }}">
                                                                                <span class="fw-bold d-block" style="font-size: .9rem;">{{ $title }}</span>
                                                                                <small class="text-muted fw-normal d-block" style="font-size: .78rem;">{{ $desc }}</small>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-body-tertiary border-0 justify-content-between p-3">
                                                                <button type="button" class="btn btn-secondary fw-bold px-3 py-2 rounded-pill text-sm" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn text-white fw-bold px-4 py-2 rounded-pill text-sm" style="background-color: #40BF89;">Simpan Hak Akses</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <form id="promote-form-{{ $adm->id }}" action="{{ route('admin.admins.promote', $adm->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="button"  onclick="confirmPromote('{{ $adm->id }}', '{{ $adm->name }}')" class="btn btn-sm text-white fw-bold px-3 shadow-sm" style="background-color: #40BF89; border: none;">
                                                    <i class="bi bi-shield-plus me-1"></i> Promote ke Admin
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted fw-bold">Data pengguna tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.theme-toggle-admin {
    z-index: 1040 !important;
}
</style>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/superadmin/superadmin.js') }}"></script>
@endpush

@endsection


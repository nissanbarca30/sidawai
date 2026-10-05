@extends('layouts.admin')

@section('header', 'Kelola Data Pegawai')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex flex-wrap justify-content-between align-items-center gap-2" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">
                    <i class="bi bi-people-fill me-2"></i>Daftar Seluruh Pegawai BKK Pontianak
                </h5>
                <a href="{{ route('admin.users.create') }}" class="btn text-white px-4 fw-bold shadow-sm" style="background-color: #40BF89; border: none;">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Pegawai Baru
                </a>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 mb-4 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   id="search-user"
                                   class="form-control border-start-0 ps-0 fw-semibold" 
                                   placeholder="Cari nama, NIP, atau email pegawai..." 
                                   value="{{ request('search') }}"
                                   autocomplete="off">
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
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 fw-bold" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </form>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0" id="user-table">
                        <thead class="bg-body-secondary text-uppercase fw-bold small">
                            <tr>
                                <th class="py-3 px-4 text-center" style="width: 60px;">NO</th>
                                <th class="py-3 px-4">NAMA PEGAWAI</th>
                                <th class="py-3 px-4">NIP / EMAIL</th>
                                <th class="py-3 px-4 text-center">STATUS ROLE</th>
                                <th class="py-3 px-4 text-center">TOTAL DOKUMEN</th>
                                <th class="py-3 px-4 text-center">AKSI KONTROL</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold">
                            @forelse($users as $index => $usr)
                                <tr class="user-row">
                                    <td class="py-3 px-4 text-center text-muted row-number">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 text-body fw-bold user-name">{{ $usr->name }}</td>
                                    <td class="py-3 px-4">
                                        <div class="text-body fw-bold user-nip">{{ $usr->nip }}</div>
                                        <div class="text-muted small user-email">{{ $usr->email }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($usr->role === 'superadmin')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">SUPERADMIN</span>
                                        @elseif($usr->role === 'admin')
                                            <span class="badge px-3 py-2 rounded-pill shadow-sm text-white" style="background-color: #40BF89;">ADMIN</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm">PEGAWAI</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="badge px-3 py-2 rounded-pill text-white" style="background-color: #2c3e50;">
                                            {{ $usr->documents_count }} Berkas
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="btn-group gap-1">
                                            <a href="{{ route('admin.users.edit', $usr->id) }}" class="btn btn-sm btn-outline-primary fw-bold px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>

                                            {{-- 
                                            Aturan Tombol Hapus:
                                            1. Akun Superadmin TIDAK BISA dihapus siapapun.
                                            2. User tidak bisa menghapus AKUN DIRINYA SENDIRI.
                                            3. Akun bertipe Admin hanya bisa dihapus jika yang sedang login adalah SUPERADMIN.
                                            --}}
                                            @if(
                                                $usr->role !== 'superadmin' && 
                                                auth()->id() !== $usr->id && 
                                                ($usr->role !== 'admin' || auth()->user()->isSuperadmin())
                                            )
                                                <form id="delete-user-form-{{ $usr->id }}" action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDeleteUser('{{ $usr->id }}', '{{ $usr->name }}')"
                                                            class="btn btn-sm btn-outline-danger fw-bold px-3">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted fw-bold">Data pegawai tidak ditemukan.</td>
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
    <script src="{{ asset('js/admin/users/users_index.js') }}"></script>
@endpush

@endsection
@extends('layouts.admin')

@section('header', 'Dashboard Utama Admin')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fw-bold text-sm mb-4 border-0 shadow-sm" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #40BF89, #5ed3a1);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Total Pegawai</h6>
                        <h2 class="fw-bold mb-0">{{ $totalPegawai }}</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #2c3e50, #4a6076);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Total Dokumen Masuk</h6>
                        <h2 class="fw-bold mb-0">{{ $totalDokumen }}</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-file-earmark-check-fill" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #ffc107, #ffdb70);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9; color: #212529;">Waktu Server</h6>
                        <h2 class="fw-bold mb-0" id="clock" style="color: #212529;">00:00:00</h2>
                    </div>
                    <div class="icon">
                        <i class="bi bi-clock-fill" style="font-size: 2.5rem; opacity: 0.3; color: #212529;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">Selamat Datang di Panel Admin SIDAWAI</h5>
                <form action="{{ route('admin.toggle_register') }}" method="POST" class="m-0">
                    @csrf
                    @if($allowRegister)
                        <button type="submit" class="btn btn-sm btn-success text-white font-bold px-3 py-1.5 rounded-pill shadow-sm d-flex align-items-center gap-2 border-0" title="Klik untuk Sembunyikan Tombol Register">
                            <i class="bi bi-eye-fill"></i>
                            <span>Menu Register: <strong>TAMPIL (UNHIDE)</strong></span>
                            <span class="btn btn-xs btn-outline-light rounded-pill px-2 py-0 ms-1" style="font-size: 0.75rem;">Sembunyikan</span>
                        </button>
                    @else
                        <button type="submit" class="btn btn-sm btn-secondary text-white font-bold px-3 py-1.5 rounded-pill shadow-sm d-flex align-items-center gap-2 border-0" title="Klik untuk Tampilkan Tombol Register">
                            <i class="bi bi-eye-slash-fill"></i>
                            <span>Menu Register: <strong>TERSEMBUNYI (HIDE)</strong></span>
                            <span class="btn btn-xs btn-light text-dark font-bold rounded-pill px-2 py-0 ms-1" style="font-size: 0.75rem;">Tampilkan</span>
                        </button>
                    @endif
                </form>
            </div>

            <div class="card-body">
                <p class="text-body">Melalui panel ini, Anda memiliki wewenang untuk mengontrol data pegawai serta memantau berkas Data Dukung dan Rekap Presensi bulanan pegawai.</p>

                <div class="alert border-start border-4" style="border-color: #40BF89 !important; background-color: rgba(64, 191, 137, 0.1);">
                    <strong class="text-body">Petunjuk Kontrol:</strong> 
                    <span class="text-body">
                        Gunakan menu navigasi untuk mengedit data pegawai atau beralih ke halaman folder dokumen pegawai. 
                        @if(auth()->user()->isSuperadmin())
                            Sebagai <strong>Superadmin</strong>, Anda juga memiliki wewenang mengelola dan mengubah hak akses Admin.
                        @endif
                    </span>
                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.documents.index') }}" class="btn text-white px-4 shadow-sm fw-bold" style="background-color: #40BF89; border: none;">
                        <i class="bi bi-folder-symlink me-1"></i> Buka Dokumen Pegawai
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                        <i class="bi bi-person-gear me-1"></i> Kelola Data Pegawai
                    </a>

                    @if(auth()->user()->isSuperadmin())
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-dark px-4 fw-bold shadow-sm">
                            <i class="bi bi-shield-lock me-1"></i> Kelola Hak Akses Admin
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush

@endsection


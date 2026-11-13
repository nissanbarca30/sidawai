@extends('layouts.admin')

@section('header', 'Dashboard Utama Admin')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fw-bold text-sm mb-4 border-0 shadow-sm" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Card Informasi & Petunjuk Kontrol -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">Selamat Datang di Panel Admin SIDAWAI</h5>
            </div>
        </div>
    </div>
</div>

<!-- Top Stats Cards (3 Kartu Ringkas) -->
<div class="row">
    <!-- Card 1: Total Pegawai -->
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

    <!-- Card 2: Total Dokumen Masuk -->
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

    <!-- Card 3: Rincian Kategori -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #0288D1, #29b6f6);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Rincian Kategori</h6>
                        <div class="fw-bold text-sm">
                            <div>Data Dukung: <span class="fs-6">{{ $totalDataDukung }}</span></div>
                            <div>Rekap Presensi: <span class="fs-6">{{ $totalRekapPresensi }}</span></div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="bi bi-pie-chart-fill" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Grafik Statistik -->
<div class="row mb-4" 
     id="dashboard-charts-data"
     data-months='@json($namaBulan)'
     data-monthly-stats='@json($monthlyStats)'
     data-data-dukung="{{ $totalDataDukung }}"
     data-rekap-presensi="{{ $totalRekapPresensi }}">
    
    <!-- Bar Chart: Dokumen per Bulan Tahun Ini -->
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-dark">Statistik Dokumen Tahun {{ $currentYear }}</h6>
                <span class="badge bg-success" style="background-color: #40BF89 !important;">Bulanan</span>
            </div>
            <div class="card-body">
                <div style="height: 260px; position: relative;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Doughnut Chart: Proporsi Kategori -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent py-3">
                <h6 class="m-0 fw-bold text-dark">Proporsi Kategori</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div style="height: 200px; width: 100%; position: relative;" class="d-flex justify-content-center">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-3 text-sm fw-bold">
                    <span><i class="bi bi-circle-fill me-1" style="color: #40BF89;"></i> Data Dukung</span>
                    <span><i class="bi bi-circle-fill me-1" style="color: #0288D1;"></i> Rekap Presensi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Akses Cepat & Status Pendaftaran -->
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm p-3 bg-body-tertiary">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                
                <!-- Tombol Navigasi Utama -->
                <div class="d-flex flex-wrap gap-2">
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush

@endsection
@extends('layouts.admin')

@section('header', 'Tambah Pegawai Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm bg-body-tertiary">
            <div class="card-header bg-transparent py-3" style="border-left: 5px solid #40BF89;">
                <h5 class="mb-0 fw-bold" style="color: #40BF89;">
                    <i class="bi bi-person-plus-fill me-2"></i>Formulir Pendaftaran Pegawai Baru
                </h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-body">Nama Lengkap Pegawai</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Ahmad Subagja, S.Kom." required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label fw-bold text-body">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 199108112012121001" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-body">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="pegawai@bkkpontianak.go.id" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold text-body">Password Akun</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold text-body">Hak Akses (Role)</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai (Pengguna Biasa)</option>
                            @if(auth()->user()->isSuperadmin())
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                            @endif
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="background-color: #40BF89; border: none;">
                            <i class="bi bi-save me-1"></i> Simpan Pegawai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
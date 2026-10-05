@extends('layouts.admin')

@section('header', 'Edit Dokumen Pegawai')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header text-white py-3" style="background-color: #40BF89; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="m-0 font-bold uppercase">Edit Dokumen: {{ $document->user->name }}</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Dokumen</label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="form-control font-bold" required>{{ old('keterangan', $document->keterangan) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold">Ganti File Lampiran (Opsional)</label>
                        <input type="file" name="file" id="file" class="form-control font-bold">
                        <small class="text-muted mt-1 block">*Biarkan kosong jika tidak ingin mengganti file lama ({{ $document->file_name }}).</small>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <a href="{{ route('admin.documents.files', ['userId' => $document->user_id, 'bulan' => $document->bulan_periode]) }}" class="btn btn-secondary fw-bold px-4 rounded-pill">
                            Batal
                        </a>
                        <button type="submit" class="btn text-white fw-bold px-4 rounded-pill" style="background-color: #40BF89;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
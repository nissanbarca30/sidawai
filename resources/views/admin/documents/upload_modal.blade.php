<!-- Overlay Layar Penuh -->
<div id="globalDropOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center" 
     style="background: rgba(64, 191, 137, 0.9); z-index: 9999; backdrop-filter: blur(4px);">
    <div class="text-center text-white p-5 border border-3 border-white border-dashed rounded-4">
        <i class="bi bi-cloud-arrow-up-fill" style="font-size: 4.5rem;"></i>
        <h3 class="fw-bold mt-2">Lepaskan File di Sini</h3>
        <p class="mb-0">File akan otomatis dimasukkan ke formulir upload dokumen {{ $user->name }}</p>
    </div>
</div>

<!-- Modal Upload Dokumen Pegawai -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: #40BF89;">
                <h5 class="modal-title fw-bold" id="uploadDocumentModalLabel">
                    <i class="bi bi-cloud-upload me-2"></i>Upload Dokumen: {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.documents.store_for_user', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    
                    <!-- Info Otomatisasi Bulan -->
                    <div class="alert alert-info py-2 px-3 small mb-3 border-0" style="background-color: rgba(2, 136, 209, 0.1); color: #0277bd;">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Folder bulan ditentukan otomatis oleh sistem berdasarkan <strong>Tanggal Izin</strong> (Data Dukung) atau <strong>Tanggal Cut-off</strong> (Rekap Presensi).
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-bold">Kategori Dokumen <span class="text-danger">*</span></label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="data_dukung">Data Dukung (Izin / Cuti / Sakit / DL)</option>
                            <option value="rekap_presensi">Rekap Presensi Bulanan</option>
                        </select>
                    </div>

                    <!-- Rentang Tanggal (Khusus Data Dukung) -->
                    <div id="tanggalContainer" class="row mb-3">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <label for="tanggal_mulai" class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai <small class="text-muted">(Opsional)</small></label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="form-control" placeholder="Contoh: Izin Sakit / Rekap Presensi Bulan..." required></textarea>
                    </div>

                    <!-- Input File Lampiran -->
                    <div class="mb-2">
                        <label for="lampiran" class="form-label fw-bold">File Lampiran (PDF / JPG / PNG, Maks 5MB) <span class="text-danger">*</span></label>
                        <input type="file" name="lampiran[]" id="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple required>
                        <div id="droppedFileBadge" class="mt-2 d-none">
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <span id="droppedFileCount">0</span> file siap di-upload</span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #40BF89;">
                        <i class="bi bi-save me-1"></i> Simpan Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
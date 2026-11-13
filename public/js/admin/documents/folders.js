function toggleAdminTanggal(kategori) {
    const sectionTanggal = document.getElementById('admin-section-tanggal');
    const tanggalMulai = document.getElementById('tanggal_mulai');

    if (!sectionTanggal || !tanggalMulai) return;

    if (kategori === 'rekap_presensi') {
        sectionTanggal.classList.add('d-none');
        tanggalMulai.removeAttribute('required');
    } else {
        sectionTanggal.classList.remove('d-none');
        tanggalMulai.setAttribute('required', 'required');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const dropOverlay = document.getElementById('globalDropOverlay');
    const uploadModalEl = document.getElementById('uploadModal');
    const fileInput = document.getElementById('lampiran');
    const droppedBadge = document.getElementById('droppedFileBadge');
    const droppedCount = document.getElementById('droppedFileCount');

    if (!uploadModalEl || !fileInput || !dropOverlay) return;

    const uploadModal = new bootstrap.Modal(uploadModalEl);
    let dragCounter = 0;

    window.addEventListener('dragenter', function (e) {
        e.preventDefault();
        if (e.dataTransfer && e.dataTransfer.types.includes('Files')) {
            dragCounter++;
            dropOverlay.classList.remove('d-none');
            dropOverlay.classList.add('d-flex');
        }
    });

    window.addEventListener('dragleave', function (e) {
        e.preventDefault();
        dragCounter--;
        if (dragCounter <= 0) {
            dragCounter = 0;
            dropOverlay.classList.add('d-none');
            dropOverlay.classList.remove('d-flex');
        }
    });

    window.addEventListener('dragover', function (e) {
        e.preventDefault();
    });

    window.addEventListener('drop', function (e) {
        e.preventDefault();
        dragCounter = 0;
        dropOverlay.classList.add('d-none');
        dropOverlay.classList.remove('d-flex');

        if (e.dataTransfer && e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;

            if (droppedBadge && droppedCount) {
                droppedCount.textContent = e.dataTransfer.files.length;
                droppedBadge.classList.remove('d-none');
            }

            uploadModal.show();
        }
    });

    fileInput.addEventListener('change', function () {
        if (this.files.length > 0 && droppedBadge && droppedCount) {
            droppedCount.textContent = this.files.length;
            droppedBadge.classList.remove('d-none');
        }
    });
});
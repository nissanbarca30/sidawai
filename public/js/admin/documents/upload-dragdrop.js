document.addEventListener('DOMContentLoaded', function () {
    const dropOverlay = document.getElementById('globalDropOverlay');
    const uploadModalEl = document.getElementById('uploadDocumentModal');
    const fileInput = document.getElementById('lampiran');
    const kategoriSelect = document.getElementById('kategori');
    const tanggalContainer = document.getElementById('tanggalContainer');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const droppedBadge = document.getElementById('droppedFileBadge');
    const droppedCount = document.getElementById('droppedFileCount');

    if (!uploadModalEl || !fileInput) return;

    const uploadModal = new bootstrap.Modal(uploadModalEl);

    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', function () {
            if (this.value === 'rekap_presensi') {
                tanggalContainer.classList.add('d-none');
                tanggalMulaiInput.removeAttribute('required');
            } else {
                tanggalContainer.classList.remove('d-none');
                tanggalMulaiInput.setAttribute('required', 'required');
            }
        });
    }

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
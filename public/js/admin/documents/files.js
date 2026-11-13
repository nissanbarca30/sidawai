function confirmDelete(id) {
    const isDark = document.documentElement.classList.contains('dark') || document.documentElement.getAttribute('data-bs-theme') === 'dark';

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Data akan dihapus ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3d47',
        cancelButtonColor: '#2b9bf4',
        confirmButtonText: 'HAPUS',
        cancelButtonText: 'BATAL',
        background: isDark ? '#1e232a' : '#ffffff',
        color: isDark ? '#ffffff' : '#1f2937',
        customClass: {
            popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100 dark:border-gray-700',
            title: 'text-2xl font-black mb-2 text-gray-800 dark:text-white',
            htmlContainer: 'font-semibold text-base mb-4 text-gray-500 dark:text-gray-300',
            confirmButton: 'px-6 py-2.5 font-bold text-white rounded-xl shadow-md text-sm uppercase me-2',
            cancelButton: 'px-6 py-2.5 font-bold text-white rounded-xl shadow-md text-sm uppercase'
        },
        buttonsStyling: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function copyToClipboard(text, buttonElement) {
    navigator.clipboard.writeText(text).then(function() {
        const textSpan = buttonElement.querySelector('.btn-copy-text');
        const icon = buttonElement.querySelector('i');
        
        const originalText = textSpan ? textSpan.innerText : 'Salin Link';
        const originalIconClass = icon ? icon.className : 'bi bi-link-45deg';

        if(textSpan) textSpan.innerText = 'Tersalin!';
        if(icon) icon.className = 'bi bi-check2-circle me-1 text-success';

        setTimeout(function() {
            if(textSpan) textSpan.innerText = originalText;
            if(icon) icon.className = originalIconClass;
        }, 2000);
    }).catch(function(err) {
        alert('Gagal menyalin link file: ' + err);
    });
}

// =========================================================================
// LOGIKA MODAL UPLOAD & GLOBAL DRAG-AND-DROP
// =========================================================================

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
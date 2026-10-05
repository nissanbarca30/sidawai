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
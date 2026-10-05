function confirmDeleteUser(id, name) {
    const isDark = document.documentElement.classList.contains('dark') || document.documentElement.getAttribute('data-bs-theme') === 'dark';

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus pegawai ' + name + ' ?',
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
            document.getElementById('delete-user-form-' + id).submit();
        }
    });

}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-user');
    const tableRows = document.querySelectorAll('.user-row');

    searchInput.addEventListener('keyup', function () {
        const query = this.value.toLowerCase().trim();

        tableRows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
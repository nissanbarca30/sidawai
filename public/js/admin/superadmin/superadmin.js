function confirmPromote(id, name) {
    const isDark =
        document.documentElement.classList.contains('dark') ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Jadikan ' + name + ' sebagai Admin ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#40BF89',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'SETUJU',
        cancelButtonText: 'BATAL',
        background: isDark ? '#1e232a' : '#ffffff',
        color: isDark ? '#ffffff' : '#1f2937',
        customClass: {
            popup: 'rounded-3xl p-4 p-md-6 shadow-2xl border border-gray-100 dark:border-gray-700',
            title: 'text-xl font-black text-gray-800 dark:text-white tracking-tight',
            htmlContainer: 'text-sm font-semibold text-gray-600 dark:text-gray-300 mt-2',
            confirmButton: 'btn btn-success text-white px-4 py-2 fw-bold me-2',
            cancelButton: 'btn btn-secondary px-4 py-2 fw-bold',
            icon: 'border-amber-300 text-amber-500 scale-90'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('promote-form-' + id).submit();
        }
    });
}


function confirmDemote(id, name) {
    const isDark =
        document.documentElement.classList.contains('dark') ||
        document.documentElement.getAttribute('data-bs-theme') === 'dark';

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Cabut hak akses Admin dari ' + name + ' ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3b30',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'CABUT',
        cancelButtonText: 'BATAL',
        background: isDark ? '#1e232a' : '#ffffff',
        color: isDark ? '#ffffff' : '#1f2937',
        customClass: {
            popup: 'rounded-3xl p-4 p-md-6 shadow-2xl border border-gray-100 dark:border-gray-700',
            title: 'text-xl font-black text-gray-800 dark:text-white tracking-tight',
            htmlContainer: 'text-sm font-semibold text-gray-600 dark:text-gray-300 mt-2',
            confirmButton: 'btn btn-danger px-4 py-2 fw-bold me-2',
            cancelButton: 'btn btn-secondary px-4 py-2 fw-bold',
            icon: 'border-amber-300 text-amber-500 scale-90'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('demote-form-' + id).submit();
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-admin');
    const tableRows = document.querySelectorAll('.admin-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase().trim();

            tableRows.forEach(function (row) {
                const text = row.textContent.toLowerCase();

                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
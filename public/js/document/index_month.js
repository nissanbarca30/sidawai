function confirmDelete(id) {
    const isDark = document.documentElement.classList.contains('dark');

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Data akan dihapus ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3d47',
        cancelButtonColor: '#2b9bf4',
        confirmButtonText: 'HAPUS',
        cancelButtonText: 'BATAL',
        reverseButtons: false,
        background: isDark ? '#1e232a' : '#ffffff',
        color: isDark ? '#ffffff' : '#1f2937',
        customClass: {
            popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100 dark:border-gray-700',
            title: 'text-3xl font-extrabold mb-2 text-gray-800 dark:text-white',
            htmlContainer: 'font-semibold text-lg mb-6 text-gray-500 dark:text-gray-300',
            confirmButton: 'px-8 py-3 font-black text-white rounded-xl shadow-md text-sm tracking-wide uppercase',
            cancelButton: 'px-8 py-3 font-black text-white rounded-xl shadow-md text-sm tracking-wide uppercase'
        },
        buttonsStyling: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
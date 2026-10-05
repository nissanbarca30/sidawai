function toggleAdminTanggal(kategori) {
    const secTanggal = document.getElementById('admin-section-tanggal');
    const inputMulai = document.getElementById('tanggal_mulai');

    if (kategori === 'data_dukung') {
        secTanggal.style.display = 'block';
        inputMulai.setAttribute('required', 'required');
    } else {
        secTanggal.style.display = 'none';
        inputMulai.removeAttribute('required');
    }
}
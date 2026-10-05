document.addEventListener('DOMContentLoaded', function () {
    // Fungsi re-usable untuk toggle password
    function setupPasswordToggle(inputId, toggleBtnId, eyeClosedId, eyeOpenId) {
        const passwordInput = document.getElementById(inputId);
        const toggleBtn = document.getElementById(toggleBtnId);
        const eyeClosed = document.getElementById(eyeClosedId);
        const eyeOpen = document.getElementById(eyeOpenId);

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                eyeClosed.classList.toggle('hidden', isPassword);
                eyeOpen.classList.toggle('hidden', !isPassword);

                toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }
    }

    setupPasswordToggle('password', 'togglePassword', 'eyeClosed', 'eyeOpen');
    setupPasswordToggle('password-confirm', 'togglePasswordConfirm', 'eyeClosedConfirm', 'eyeOpenConfirm');
});
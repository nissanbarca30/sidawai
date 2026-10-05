document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
            if (password.type === 'password') {
                // Tampilkan password
                password.type = 'text';

                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');

                togglePassword.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {
                // Sembunyikan password
                password.type = 'password';

                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');

                togglePassword.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );
            }
        });
    }
});
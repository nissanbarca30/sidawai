function togglePass() {
    const input = document.getElementById('password');
    const eyeClosed = document.getElementById('eyeClosed');
    const eyeOpen = document.getElementById('eyeOpen');

    if (input) {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        eyeClosed.classList.toggle('hidden', isPassword);
        eyeOpen.classList.toggle('hidden', !isPassword);
    }
}
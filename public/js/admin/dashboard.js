function updateClock() {
    const now = new Date();

    const options = {
        timeZone: 'Asia/Jakarta',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };

    const formatter = new Intl.DateTimeFormat('en-GB', options);
    const timeString = formatter.format(now);

    document.getElementById('clock').textContent = timeString + " WIB";
}

setInterval(updateClock, 1000);
updateClock();
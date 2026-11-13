document.addEventListener('DOMContentLoaded', function () {
    const chartContainer = document.getElementById('dashboard-charts-data');
    if (!chartContainer) return;

    // Ambil & parse data dari atribut HTML data-*
    const months = JSON.parse(chartContainer.dataset.months || '[]');
    const monthlyData = JSON.parse(chartContainer.dataset.monthlyStats || '[]');
    const dataDukung = parseInt(chartContainer.dataset.dataDukung || 0);
    const rekapPresensi = parseInt(chartContainer.dataset.rekapPresensi || 0);

    // 1. Render Bar Chart (Statistik Bulanan)
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        new Chart(monthlyCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: monthlyData,
                    backgroundColor: '#40BF89',
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }

    // 2. Render Donut Chart (Kategori Dokumen)
    const categoryCanvas = document.getElementById('categoryChart');
    if (categoryCanvas) {
        new Chart(categoryCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Data Dukung', 'Rekap Presensi'],
                datasets: [{
                    data: [dataDukung, rekapPresensi],
                    backgroundColor: ['#40BF89', '#0288D1'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });
    }
});
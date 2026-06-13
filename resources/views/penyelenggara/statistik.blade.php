<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Laporan - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-white rounded-[24px] p-6 border border-slate-200 shadow-sm sticky top-32">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 px-2">Menu Panitia</h3>
                
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('penyelenggara.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-colors">
                        <span class="text-xl opacity-70"></span> 
                        Ringkasan Utama
                    </a>
                    
                    <a href="{{ route('penyelenggara.statistik') }}" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-xl transition-colors border border-indigo-100">
                        <span class="text-xl"></span> 
                        Statistik & Laporan
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan Kinerja Lomba</h1>
                    <p class="text-slate-600 mt-2 font-medium">Analisis mendalam performa acara dan demografi peserta.</p>
                </div>
                
                <div class="bg-white px-6 py-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-end shrink-0">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Estimasi Pemasukan</span>
                    <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col xl:col-span-2">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                Lonjakan Pendaftar Baru
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 font-medium">Pergerakan data 14 hari terakhir.</p>
                        </div>
                        <span class="px-3 py-1 bg-slate-50 text-slate-500 rounded-lg text-xs font-bold border border-slate-100">+{{ array_sum($dataTren) ?? 0 }} Peserta</span>
                    </div>
                    <div class="flex-1 min-h-[300px] w-full">
                        <canvas id="chartTren"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col xl:col-span-1">
                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-bold text-slate-800">Rasio Jalur</h3>
                        <p class="text-xs text-slate-400 font-medium mt-1">Distribusi Gratis vs Premium.</p>
                    </div>
                    <div class="relative flex-1 flex justify-center items-center min-h-[250px]">
                        <canvas id="chartJalur"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total</span>
                            <span class="text-3xl font-black text-slate-800">{{ $jalurGratis + $jalurBerbayar }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col xl:col-span-2">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Rasio Lolos vs Gugur per Lomba</h3>
                        <p class="text-xs text-slate-400 font-medium mt-1">Deteksi indikasi syarat yang menyulitkan peserta.</p>
                    </div>
                    <div class="flex-1 min-h-[300px] w-full">
                        <canvas id="chartVerifikasi"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col xl:col-span-1">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Radar Instansi Top</h3>
                        <p class="text-xs text-slate-400 font-medium mt-1">Asal pendaftar terbanyak.</p>
                    </div>
                    <div class="flex-1 min-h-[300px] w-full">
                        <canvas id="chartInstansi"></canvas>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script>
        // Konfigurasi Font Global Chart.js agar sesuai desain Winly
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748b'; // text-slate-500

        // -----------------------------------------
        // 1. Grafik Donat (Jalur Pendaftaran)
        // -----------------------------------------
        new Chart(document.getElementById('chartJalur'), {
            type: 'doughnut',
            data: {
                labels: ['Gratis', 'Premium'],
                datasets: [{
                    data: [@json($jalurGratis), @json($jalurBerbayar)],
                    backgroundColor: ['#10b981', '#3b82f6'], // Emerald & Blue
                    hoverOffset: 4,
                    borderWidth: 0,
                    cutout: '80%' // Dibuat 80% agar ring-nya lebih tipis elegan seperti di gambar
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold' } } }
                }
            }
        });

        // -----------------------------------------
        // 2. Grafik Garis (Tren Pendaftar)
        // -----------------------------------------
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTren),
                datasets: [{
                    label: 'Pendaftar Baru',
                    data: @json($dataTren),
                    borderColor: '#3b82f6', // Biru
                    backgroundColor: 'rgba(59, 130, 246, 0.1)', // Biru transparan
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4, // Membuat kurva melengkung (smooth)
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // -----------------------------------------
        // 3. Grafik Batang Bertumpuk (Verifikasi)
        // -----------------------------------------
        new Chart(document.getElementById('chartVerifikasi'), {
            type: 'bar',
            data: {
                labels: @json($labelLomba),
                datasets: [
                    { label: 'Lolos', data: @json($dataSukses), backgroundColor: '#34d399', borderRadius: 4 }, // Emerald-400
                    { label: 'Pending', data: @json($dataPending), backgroundColor: '#fbbf24', borderRadius: 4 }, // Amber-400
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, font: { weight: 'bold' } } } },
                scales: {
                    x: { stacked: true, grid: { display: false } },
                    y: { stacked: true, beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { stepSize: 1 } }
                }
            }
        });

        // -----------------------------------------
        // 4. Grafik Batang Horizontal (Top Instansi)
        // -----------------------------------------
        new Chart(document.getElementById('chartInstansi'), {
            type: 'bar',
            data: {
                labels: @json($labelInstansi),
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: @json($dataInstansi),
                    backgroundColor: '#cbd5e1', // Slate-300
                    borderRadius: 4,
                    barThickness: 24
                }]
            },
            options: {
                indexAxis: 'y', // Mengubah menjadi horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                }
            }
        });
    </script>

</body>
</html>
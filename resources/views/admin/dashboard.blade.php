<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
    </style>
</head>

<body class="min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-slate-900 rounded-[24px] p-6 shadow-xl sticky top-32">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 px-2">Admin Control</h3>
                
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl transition-all shadow-md shadow-blue-900/20">
                        <span class="text-xl"></span> Dashboard Utama
                    </a>
                    
                    <a href="{{ route('admin.verifikasi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60"></span> Verifikasi Panitia
                        
                        @if($pendingVerificationCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse">
                                {{ $pendingVerificationCount }}
                            </span>
                        @endif
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60"></span> Laporan Keuangan
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Super Admin Dashboard</h1>
                <p class="text-slate-500 mt-2 font-medium text-sm">Pusat kendali utama platform Winly. Pantau verifikasi dan arus kas di sini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-amber-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0 border border-amber-100">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Antrean Verifikasi</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $pendingVerificationCount }} <span class="text-sm font-bold text-slate-400">Akun</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 border border-emerald-100">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Total Pemasukan</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Panitia Terverifikasi</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $activeOrganizers }} <span class="text-sm font-bold text-slate-400">Instansi</span></p>
                    </div>
                </div>
                
            </div>

            <div class="bg-white rounded-[24px] p-8 ring-1 ring-slate-100 shadow-sm text-center py-24">
                <span class="text-6xl mb-4 block animate-bounce">🚧</span>
                <h2 class="text-xl font-bold text-slate-800">Modul Sedang Dibangun</h2>
                <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto">Halaman Verifikasi Panitia dan Tabel Laporan Keuangan akan segera kita bangun pada langkah selanjutnya (Fase 3 & 4).</p>
            </div>

        </main>
    </div>

</body>
</html>
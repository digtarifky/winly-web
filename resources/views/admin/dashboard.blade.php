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
                        <span class="text-2xl">🛡️</span>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Antrean Verifikasi</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $pendingVerificationCount }} <span class="text-sm font-bold text-slate-400">Akun</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 border border-emerald-100">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Total Pemasukan</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                        <span class="text-2xl">🏢</span>
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
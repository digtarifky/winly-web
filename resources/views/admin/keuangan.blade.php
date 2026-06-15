<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
    </style>
</head>

<body class="min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <!-- ========================================== -->
        <!-- SIDEBAR ADMIN (DENGAN SVG ICONS)           -->
        <!-- ========================================== -->
        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-slate-900 rounded-[24px] p-6 shadow-xl sticky top-32">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 px-2">Admin Control</h3>
                
                <nav class="flex flex-col gap-1.5">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard Utama
                    </a>
                    
                    <!-- Verifikasi -->
                    <a href="{{ route('admin.verifikasi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <svg class="w-5 h-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Verifikasi Panitia
                    </a>

                    <!-- Keuangan (AKTIF) -->
                    <a href="{{ route('admin.keuangan') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl transition-all shadow-md shadow-blue-900/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Laporan Keuangan
                    </a>
                </nav>
            </div>
        </aside>

        <!-- ========================================== -->
        <!-- KONTEN UTAMA                               -->
        <!-- ========================================== -->
        <main class="flex-1 min-w-0">

            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan Keuangan</h1>
                    <p class="text-slate-500 mt-2 font-medium text-sm">Pantau seluruh arus kas masuk dari pembayaran platform Winly.</p>
                </div>
            </div>

            <!-- KARTU RINGKASAN PENDAPATAN -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[24px] p-8 shadow-lg shadow-emerald-600/20 mb-8 relative overflow-hidden">
                <!-- SVG Dekorasi Latar Belakang -->
                <svg class="absolute -right-10 -top-10 w-64 h-64 text-white opacity-10" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                    <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                </svg>

                <div class="relative z-10 text-white">
                    <p class="text-sm font-extrabold uppercase tracking-widest text-emerald-100 mb-1">Total Saldo Masuk (Berhasil)</p>
                    <h2 class="text-4xl md:text-5xl font-black">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- TABEL TRANSAKSI KESELURUHAN -->
            <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Transaksi</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Daftar pembayaran publikasi lomba oleh penyelenggara.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                <th class="p-5">Tanggal & ID</th>
                                <th class="p-5">Pengguna / Instansi</th>
                                <th class="p-5">Keterangan</th>
                                <th class="p-5">Status</th>
                                <th class="p-5 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-slate-600 divide-y divide-slate-50">
                            @forelse($transaksi as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5 font-mono">ID: {{ $item->id }}</p>
                                    </td>
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800">{{ $item->user->name ?? 'User Dihapus' }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $item->user->email ?? '-' }}</p>
                                    </td>
                                    <td class="p-5">
                                        <p class="text-slate-700 capitalize">{{ str_replace('_', ' ', $item->tipe_transaksi) }}</p>
                                    </td>
                                    <td class="p-5">
                                        @if(strtolower($item->status_pembayaran) === 'berhasil' || strtolower($item->status_pembayaran) === 'success' || strtolower($item->status_pembayaran) === 'settlement')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                Berhasil
                                            </span>
                                        @elseif(strtolower($item->status_pembayaran) === 'pending')
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-black inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Pending
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-black inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Gagal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 text-right">
                                        <p class="font-black text-emerald-600 text-base">
                                            Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400 flex-col items-center flex justify-center w-full">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Belum ada data transaksi masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
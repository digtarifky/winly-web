<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Center - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
    </style>
</head>

<body class="min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col gap-8">

        <header class="mb-4">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Super Admin Center</h1>
            <p class="text-slate-500 mt-2 font-medium text-sm">Pusat kendali utama. Pantau verifikasi penyelenggara dan arus kas platform di satu layar.</p>
        </header>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl border border-emerald-100 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-amber-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0 border border-amber-100">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>
                </div>
                <div class="relative">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Antrean Verifikasi</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $pendingVerificationCount }} <span class="text-sm font-bold text-slate-400">Akun</span></p>
                </div>
            </div>

            <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" /><path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" /></svg>
                </div>
                <div class="relative">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Total Pemasukan</p>
                    <p class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                </div>
                <div class="relative">
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Panitia Terverifikasi</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $activeOrganizers }} <span class="text-sm font-bold text-slate-400">Instansi</span></p>
                </div>
            </div>
        </div>

        <div class="space-y-12 w-full mt-4">

            <div class="space-y-6">
                
                <div class="border-b border-slate-200 pb-3 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 flex items-center justify-center rounded-2xl shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Modul Verifikasi Penyelenggara</h2>
                        <p class="text-sm text-slate-500 font-medium">Tinjau dan kelola persetujuan dokumen legalitas panitia lomba.</p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden w-full">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800">Antrean Tinjauan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <th class="p-5">Nama & Instansi</th>
                                    <th class="p-5">Kontak</th>
                                    <th class="p-5">Dokumen Bukti</th>
                                    <th class="p-5 text-right">Aksi Keputusan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-medium text-slate-600 divide-y divide-slate-50">
                                @forelse($panitiaPending as $panitia)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="p-5">
                                            <p class="font-bold text-slate-800">{{ $panitia->profile->nama_lengkap ?? 'Belum isi profil' }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $panitia->profile->asal_instansi ?? '-' }}</p>
                                        </td>
                                        <td class="p-5">
                                            <p class="text-slate-700">{{ $panitia->email }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $panitia->profile->no_wa ?? '-' }}</p>
                                        </td>
                                        <td class="p-5">
                                            <div class="flex gap-4">
                                                @if($panitia->dokumen_ktp)
                                                    <button type="button" onclick="openModal('{{ asset('storage/' . $panitia->dokumen_ktp) }}')" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg> Lihat KTP
                                                    </button>
                                                @endif
                                                @if($panitia->dokumen_legalitas)
                                                    <button type="button" onclick="openModal('{{ asset('storage/' . $panitia->dokumen_legalitas) }}')" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg> Lihat Surat
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-5 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <form action="{{ route('admin.verifikasi.proses', $panitia->id) }}" method="POST">
                                                    @csrf <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" onclick="return confirm('Yakin ingin menolak akun ini?')" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white font-bold rounded-lg transition-colors text-xs">Tolak</button>
                                                </form>
                                                <form action="{{ route('admin.verifikasi.proses', $panitia->id) }}" method="POST">
                                                    @csrf <input type="hidden" name="status" value="verified">
                                                    <button type="submit" onclick="return confirm('Yakin ingin menyetujui akun ini?')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg transition-colors text-xs shadow-sm shadow-emerald-500/30">Setujui</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                Semua panitia sudah ditinjau.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden w-full">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Keputusan</h3>
                    </div>
                    <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <th class="p-5">Nama & Instansi</th>
                                    <th class="p-5">Email</th>
                                    <th class="p-5 text-right">Status Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-medium text-slate-600 divide-y divide-slate-50">
                                @forelse($panitiaRiwayat as $riwayat)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-5">
                                            <p class="font-bold text-slate-800">{{ $riwayat->profile->nama_lengkap ?? 'Belum isi profil' }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $riwayat->profile->asal_instansi ?? '-' }}</p>
                                        </td>
                                        <td class="p-5">
                                            <p class="text-slate-700">{{ $riwayat->email }}</p>
                                        </td>
                                        <td class="p-5 text-right">
                                            @if($riwayat->status_verifikasi === 'verified')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black inline-flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg> Disetujui
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-black inline-flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg> Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-8 text-center text-slate-400">Belum ada riwayat verifikasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($panitiaRiwayat->hasPages())
                        <div class="p-4 border-t border-slate-100 bg-white">
                            {{ $panitiaRiwayat->appends(request()->except('riwayatPage'))->links() }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="space-y-6">
                
                <div class="border-b border-slate-200 pb-3 flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 flex items-center justify-center rounded-2xl shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Modul Laporan Keuangan</h2>
                        <p class="text-sm text-slate-500 font-medium">Riwayat transaksi pembayaran publikasi lomba oleh panitia.</p>
                    </div>
                </div>

                <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden w-full">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800">Tabel Arus Kas</h3>
                    </div>
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <th class="p-5">Waktu Transaksi</th>
                                    <th class="p-5">Pengguna / Panitia</th>
                                    <th class="p-5">Status</th>
                                    <th class="p-5 text-right">Nominal Masuk</th>
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
                                            @if(in_array(strtolower($item->status_pembayaran), ['berhasil', 'success', 'settlement']))
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-wide">Berhasil</span>
                                            @elseif(strtolower($item->status_pembayaran) === 'pending')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase tracking-wide">Pending</span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase tracking-wide">Gagal</span>
                                            @endif
                                        </td>
                                        <td class="p-5 text-right">
                                            <p class="font-black text-emerald-600 text-base">
                                                Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                            </p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada transaksi publikasi masuk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($transaksi->hasPages())
                        <div class="p-4 border-t border-slate-100 bg-white">
                            {{ $transaksi->appends(request()->except('keuanganPage'))->links() }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <div id="documentModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm items-center justify-center p-4 opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            <div class="flex justify-between items-center p-5 border-b border-slate-100 bg-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Pratinjau Dokumen
                </h3>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-6 bg-slate-50/50 flex justify-center items-center relative">
                <div id="modalLoader" class="absolute inset-0 flex items-center justify-center bg-slate-50 z-10">
                    <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                </div>
                <img id="modalImage" src="" alt="Dokumen Verifikasi" class="max-w-full max-h-[70vh] rounded-xl shadow-sm hidden" onload="document.getElementById('modalLoader').classList.add('hidden')">
                <iframe id="modalPdf" src="" class="w-full h-[70vh] rounded-xl border border-slate-200 hidden" onload="document.getElementById('modalLoader').classList.add('hidden')"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openModal(url) {
            const modal = document.getElementById('documentModal');
            const img = document.getElementById('modalImage');
            const pdf = document.getElementById('modalPdf');
            const content = document.getElementById('modalContent');
            const loader = document.getElementById('modalLoader');

            loader.classList.remove('hidden');
            if (url.toLowerCase().endsWith('.pdf')) {
                img.classList.add('hidden'); pdf.classList.remove('hidden'); pdf.src = url;
            } else {
                pdf.classList.add('hidden'); img.classList.remove('hidden'); img.src = url;
            }
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.remove('opacity-0'); content.classList.remove('scale-95'); }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('documentModal');
            const content = document.getElementById('modalContent');
            modal.classList.add('opacity-0'); content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('modalPdf').src = '';
                document.getElementById('modalImage').src = '';
            }, 300);
        }

        document.getElementById('documentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
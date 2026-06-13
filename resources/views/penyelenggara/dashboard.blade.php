<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panitia - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-white rounded-[24px] p-6 border border-slate-200 shadow-sm sticky top-32">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 px-2">Menu Panitia</h3>
                
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('penyelenggara.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-xl transition-colors border border-indigo-100">
                        <span class="text-xl"></span> 
                        Ringkasan Utama
                    </a>
                    
                    <a href="{{ route('penyelenggara.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-colors">
                        <span class="text-xl opacity-70"></span> 
                        Statistik & Laporan
                    </a>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60"></span> Profil & Verifikasi
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0" x-data="{ activeTab: '{{ request()->has('pending_page') ? 'pending' : 'valid' }}' }">

            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Panitia</h1>
                <p class="text-slate-600 mt-2 font-medium">Selamat datang kembali! Pantau seluruh pendaftar kompetisi Anda di sini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 flex items-center gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 shrink-0">
                        <svg viewBox="-25.6 -25.6 115.20 115.20" xmlns="http://www.w3.org/2000/svg" stroke-width="4.544" stroke="#7094ff" fill="none" class="w-8 h-8">
                            <circle cx="32" cy="18.14" r="11.14"></circle>
                            <path d="M54.55,56.85A22.55,22.55,0,0,0,32,34.3h0A22.55,22.55,0,0,0,9.45,56.85Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pendaftar</p>
                        <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($totalPendaftar) }} <span class="text-sm font-medium text-slate-400">orang</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 flex items-center gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sukses / Valid</p>
                        <p class="text-3xl font-black text-emerald-600 mt-1">{{ number_format($pesertaValid) }} <span class="text-sm font-medium text-slate-400">orang</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-7 shadow-sm border border-slate-100 flex items-center gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 shrink-0">
                        <svg class="w-8 h-8" fill="#e19223" viewBox="-12.24 -12.24 48.48 48.48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23,11a1,1,0,0,0-1,1,10.034,10.034,0,1,1-2.9-7.021A.862.862,0,0,1,19,5H16a1,1,0,0,0,0,2h3a3,3,0,0,0,3-3V1a1,1,0,0,0-2,0V3.065A11.994,11.994,0,1,0,24,12,1,1,0,0,0,23,11Z M12,6a1,1,0,0,0-1,1v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414L13,11.586V7A1,1,0,0,0,12,6Z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pending / Kendala</p>
                        <p class="text-3xl font-black text-amber-600 mt-1">{{ number_format($pesertaPending) }} <span class="text-sm font-medium text-slate-400">orang</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] p-8 drop-shadow-xl border-slate-200 overflow-hidden">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-8 gap-4 border-b border-slate-100 pb-6">
                    <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-full overflow-x-auto max-w-full">
                        <button @click="activeTab = 'valid'"
                            :class="activeTab === 'valid' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-2 shrink-0">
                            <span class="w-2 h-2 rounded-full bg-emerald-500" x-show="activeTab === 'valid'"></span>
                            Peserta Valid
                        </button>
                        <button @click="activeTab = 'pending'"
                            :class="activeTab === 'pending' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-2 shrink-0">
                            <span class="w-2 h-2 rounded-full bg-amber-500" x-show="activeTab === 'pending'"></span>
                            Menunggu Validasi
                        </button>
                    </div>

                    <a href="{{ route('penyelenggara.export.excel') }}" x-show="activeTab === 'valid'"
                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all text-xs flex items-center gap-2 shadow-lg shadow-emerald-100 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l3-3m-3 3l-3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-1z"></path>
                        </svg>
                        Export ke Excel (.xlsx)
                    </a>
                </div>

                <div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="text-[10px] text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                                <tr>
                                    <th class="px-4 py-4 font-bold min-w-[150px]">Nama Lengkap</th>
                                    <th class="px-4 py-4 font-bold min-w-[120px]">Instansi</th>
                                    <th class="px-4 py-4 font-bold min-w-[200px]">Lomba & Bidang</th>
                                    <th class="px-4 py-4 font-bold text-center">Jalur</th>
                                    <th class="px-4 py-4 font-bold text-right min-w-[150px]">Status / Aksi</th>
                                </tr>
                            </thead>

                            <tbody x-show="activeTab === 'valid'" class="text-sm">
                                @forelse($validRegistrations as $reg)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                        <td class="px-4 py-5">
                                            <p class="font-bold text-slate-900">{{ $reg->user->profile->nama_lengkap ?? 'User Baru' }}</p>
                                            <p class="text-xs text-blue-600 font-medium">{{ $reg->user->profile->no_wa ?? '-' }}</p>
                                        </td>
                                        <td class="px-4 py-5 text-slate-600 font-medium">
                                            {{ $reg->user->profile->asal_instansi ?? '-' }}
                                        </td>
                                        <td class="px-4 py-5 max-w-[200px]">
                                            <p class="text-[11px] font-black text-slate-900 mb-1.5 line-clamp-2 leading-tight" title="{{ $reg->field->competition->judul_lomba ?? '-' }}">
                                                {{ $reg->field->competition->judul_lomba ?? '-' }}
                                            </p>
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[9px] font-bold border border-slate-200">
                                                {{ $reg->field->nama_bidang ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-center">
                                            <span class="text-[10px] font-black uppercase {{ $reg->jalur_pendaftaran === 'gratis' ? 'text-emerald-600' : 'text-blue-600' }}">
                                                {{ $reg->jalur_pendaftaran }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-right">
                                            <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black inline-block mt-1">
                                                TERVERIFIKASI ✅
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-20 text-center text-slate-400 font-medium italic">
                                            <span class="text-4xl block mb-3">📭</span>
                                            Belum ada peserta yang berstatus Valid.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tbody x-show="activeTab === 'pending'" x-cloak class="text-sm">
                                @forelse($pendingRegistrations as $reg)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                        <td class="px-4 py-5">
                                            <p class="font-bold text-slate-900">{{ $reg->user->profile->nama_lengkap ?? 'User' }}</p>
                                            <p class="text-xs text-blue-600 font-medium">{{ $reg->user->profile->no_wa ?? '-' }}</p>
                                        </td>
                                        <td class="px-4 py-5 text-slate-600 font-medium">
                                            {{ $reg->user->profile->instansi ?? '-' }}
                                        </td>
                                        <td class="px-4 py-5 max-w-[200px]">
                                            <p class="text-[11px] font-black text-slate-900 mb-1.5 line-clamp-2 leading-tight" title="{{ $reg->field->competition->judul_lomba ?? '-' }}">
                                                {{ $reg->field->competition->judul_lomba ?? '-' }}
                                            </p>
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[9px] font-bold border border-slate-200">
                                                {{ $reg->field->nama_bidang ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-center">
                                            <span class="text-[10px] font-black uppercase {{ $reg->jalur_pendaftaran === 'gratis' ? 'text-emerald-600' : 'text-blue-600' }}">
                                                {{ $reg->jalur_pendaftaran }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-right" x-data="{ showModal: false }">
                                            @if ($reg->status_pembayaran === 'menunggu')
                                                <span class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-wider inline-block mt-1">
                                                    Menunggu Pembayaran ⏳
                                                </span>
                                            @elseif($reg->status_pembayaran === 'menunggu_verifikasi')
                                                <button @click="showModal = true" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-full text-[10px] font-black transition-colors uppercase mt-1">
                                                    Cek Bukti 🔍
                                                </button>

                                                <template x-teleport="body">
                                                    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                                                        <div @click.away="showModal = false" x-transition class="bg-white rounded-[24px] w-full max-w-3xl max-h-[90vh] shadow-2xl flex flex-col text-left overflow-hidden">
                                                            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                                                                <div>
                                                                    <h3 class="text-xl font-extrabold text-slate-900">Verifikasi Bukti Pendaftaran</h3>
                                                                    <p class="text-sm text-slate-500 font-medium mt-1">Peserta: {{ $reg->user->profile->nama_lengkap ?? 'User' }}</p>
                                                                </div>
                                                                <button @click="showModal = false" class="w-8 h-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-500 rounded-full shadow-sm">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="p-6 overflow-y-auto flex-1">
                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                                                    <div>
                                                                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Bukti Follow</p>
                                                                        @if ($reg->bukti_follow)
                                                                            <a href="{{ asset('storage/' . $reg->bukti_follow) }}" target="_blank">
                                                                                <img src="{{ asset('storage/' . $reg->bukti_follow) }}" class="w-full h-48 object-cover rounded-xl border border-slate-200 hover:opacity-80 transition">
                                                                            </a>
                                                                        @else
                                                                            <div class="w-full h-48 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-sm font-medium border border-slate-200">Tidak ada foto</div>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Bukti Share</p>
                                                                        @if ($reg->bukti_share)
                                                                            <a href="{{ asset('storage/' . $reg->bukti_share) }}" target="_blank">
                                                                                <img src="{{ asset('storage/' . $reg->bukti_share) }}" class="w-full h-48 object-cover rounded-xl border border-slate-200 hover:opacity-80 transition">
                                                                        </a>
                                                                        @else
                                                                            <div class="w-full h-48 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-sm font-medium border border-slate-200">Tidak ada foto</div>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-xs font-bold text-slate-500 uppercase mb-2">Bukti Komentar</p>
                                                                        @if ($reg->bukti_komentar)
                                                                            <a href="{{ asset('storage/' . $reg->bukti_komentar) }}" target="_blank">
                                                                                <img src="{{ asset('storage/' . $reg->bukti_komentar) }}" class="w-full h-48 object-cover rounded-xl border border-slate-200 hover:opacity-80 transition">
                                                                            </a>
                                                                        @else
                                                                            <div class="w-full h-48 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-sm font-medium border border-slate-200">Tidak ada foto</div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                                                                <form action="{{ route('penyelenggara.pendaftaran.verify', $reg->id) }}" method="POST">
                                                                    @csrf 
                                                                    <input type="hidden" name="status" value="gagal">
                                                                    <button type="submit" class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 font-bold rounded-xl transition text-sm">Tolak Pendaftaran</button>
                                                                </form>
                                                                <form action="{{ route('penyelenggara.pendaftaran.verify', $reg->id) }}" method="POST">
                                                                    @csrf 
                                                                    <input type="hidden" name="status" value="sukses">
                                                                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transition text-sm flex items-center gap-2">Verifikasi Peserta</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-20 text-center text-slate-400 font-medium italic">
                                            <span class="text-4xl block mb-3">👻</span>
                                            Antrean kosong, tidak ada data pending.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-6">
                        <div x-show="activeTab === 'valid'">
                            {{ $validRegistrations->appends(['pending_page' => request('pending_page')])->links() }}
                        </div>
                        
                        <div x-show="activeTab === 'pending'" x-cloak>
                            {{ $pendingRegistrations->appends(['valid_page' => request('valid_page')])->links() }}
                        </div>
                    </div>
                    
                </div>
            </div>

        </main>
    </div>

</body>
</html>
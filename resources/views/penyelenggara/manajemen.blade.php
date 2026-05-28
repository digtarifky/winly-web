<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyelenggara - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col relative">

    <x-nav />

    <main class="flex-grow pt-28 px-4 md:px-8 w-full max-w-7xl mx-auto mb-20">

        <div
            class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div
                    class="w-16 h-16 bg-blue-900 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Portal Penyelenggara</h1>
                    <p class="text-slate-500 mt-1">Kelola dan pantau kompetisi Anda dari satu tempat.</p>
                </div>
            </div>

            <div class="bg-[#F4F9FF] border border-blue-100 rounded-2xl p-4 flex items-center gap-4 min-w-[250px]">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Sisa Kuota Gratis</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-black text-blue-700">{{ $user->kuota_gratis }}</span>
                        <span class="text-sm font-semibold text-blue-500">lomba (Umum/Kota)</span>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl font-bold text-sm shadow-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-extrabold text-slate-900">Kompetisi Anda</h2>
            <a href="{{ route('penyelenggara.create') }}"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-blue-200 active:scale-95 flex items-center gap-2">
                <span>+</span> Tambah Lomba Baru
            </a>
        </div>

        <!-- BUNGKUSAN GRID (Pastikan ini ada agar tidak berderet ke bawah!) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">

            @forelse($competitions as $lomba)
                @php
                    // LOGIKA 3 GEMBOK WINLY & PERBAIKAN TOTAL PENDAFTAR
                    $totalPendaftar = $lomba->registrations_count ?? ($lomba->registrations()->count() ?? 0);

                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                    $tglTutup = $lomba->tgl_tutup_pendaftaran
                        ? \Carbon\Carbon::parse($lomba->tgl_tutup_pendaftaran)->endOfDay()
                        : $hariIni->copy()->addDays(30);
                    $kuota = $lomba->kuota_peserta ?? 100;

                    $sudahPenuh = $totalPendaftar >= $kuota;
                    $tutupManual = $lomba->is_pendaftaran_tutup ?? false;
                    $lewatTanggal = $hariIni->gt($tglTutup);

                    // Cek apakah lomba ini berstatus tutup
                    $isClosed = $tutupManual || $sudahPenuh || $lewatTanggal;

                    // Bikin alasan kenapa tutup (agar panitia tahu)
                    $alasanTutup = '';
                    if ($tutupManual) {
                        $alasanTutup = 'Tutup Manual';
                    } elseif ($sudahPenuh) {
                        $alasanTutup = 'Kuota Penuh';
                    } elseif ($lewatTanggal) {
                        $alasanTutup = 'Waktu Habis';
                    }

                    // PERBAIKAN: LOGIKA MENGHITUNG HARGA
                    $minPrice = $lomba->fields->min('harga') ?? 0;
                    $maxPrice = $lomba->fields->max('harga') ?? 0;

                    if ($minPrice == 0 && $maxPrice > 0) {
                        $priceText = 'FREE - Rp ' . number_format($maxPrice, 0, ',', '.');
                    } elseif ($minPrice == 0 && $maxPrice == 0) {
                        $priceText = 'FREE';
                    } else {
                        $priceText = 'Rp ' . number_format($minPrice, 0, ',', '.');
                    }
                @endphp

                <div
                    class="bg-white rounded-[24px] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col relative z-0 overflow-hidden transition-all duration-300">

                    <div class="relative w-full aspect-[1/1] bg-slate-100 overflow-hidden">
                        {{-- BANNER MERAH KEMBALI KE WARNA ASLINYA --}}
                        @if ($isClosed)
                            <div
                                class="absolute top-0 left-0 w-full bg-red-600/95 backdrop-blur-sm text-white text-[10px] font-black text-center py-2.5 z-20 shadow-md tracking-widest uppercase border-b border-red-700">
                                Pendaftaran Ditutup 🔒 ({{ $alasanTutup }})
                            </div>
                        @endif

                        {{-- EFEK ABU-ABU HANYA PADA POSTER --}}
                        <img src="{{ $lomba->poster ? asset('storage/' . $lomba->poster) : 'https://via.placeholder.com/400x500?text=Poster' }}"
                            alt="Poster Lomba"
                            class="w-full h-full object-cover {{ $isClosed ? 'opacity-70 grayscale' : '' }}">
                    </div>

                    <div class="p-6 flex flex-col flex-grow">

                        {{-- EFEK ABU-ABU UNTUK KONTEN TEKS TENGAH --}}
                        <div class="flex flex-col flex-grow {{ $isClosed ? 'opacity-70 grayscale' : '' }}">
                            <h3 class="text-lg font-black text-slate-900 leading-tight mb-4 line-clamp-2 h-[3.5rem]"
                                title="{{ $lomba->judul_lomba }}">
                                {{ $lomba->judul_lomba }}
                            </h3>

                            <div class="space-y-3 mb-5">
                                <div class="flex items-start gap-3 text-sm text-slate-600 font-medium">
                                    <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</span>
                                </div>

                                <div class="flex items-center gap-3 text-sm font-medium">
                                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-slate-600 flex flex-wrap items-center gap-1.5">
                                        <span>Daftar:</span>
                                        <span class="text-amber-600 text-xs font-bold">
                                            {{ $lomba->tgl_buka_pendaftaran ? date('d M', strtotime($lomba->tgl_buka_pendaftaran)) : '-' }}
                                            -
                                            {{ $lomba->tgl_tutup_pendaftaran ? date('d M Y', strtotime($lomba->tgl_tutup_pendaftaran)) : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 border-t border-slate-100 mb-2">
                                <span class="text-lg font-black text-slate-900">{{ $priceText }}</span>
                            </div>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-slate-500">Total Pendaftar:</span>
                                <div
                                    class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-indigo-100 flex-shrink-0 whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    {{ $totalPendaftar }} / {{ $kuota }}
                                </div>
                            </div>

                            <!-- AREA SAKLAR REM DARURAT (TOGGLE) -->
                            <div class="flex items-center justify-between mb-5">
                                <span class="text-xs font-bold text-slate-500">Status Pendaftaran:</span>

                                @php
                                    // Cek apakah lomba ini dikunci paksa oleh SISTEM (bukan manual)
                                    $terkunciSistem = $sudahPenuh || $lewatTanggal;
                                @endphp

                                <form action="{{ route('penyelenggara.toggle-status', $lomba->id) }}" method="POST"
                                    class="m-0 flex items-center">
                                    @csrf
                                    @method('PATCH')

                                    <label
                                        class="relative inline-flex items-center {{ $terkunciSistem ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}">

                                        <input type="checkbox" name="is_pendaftaran_tutup" class="sr-only peer"
                                            {{ $isClosed ? 'checked' : '' }} {{ $terkunciSistem ? 'disabled' : '' }}
                                            onchange="if(confirm('Yakin ingin merubah status pendaftaran lomba ini?')) { this.form.submit(); } else { this.checked = !this.checked; }">

                                        <div
                                            class="w-9 h-5 bg-green-500 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-500 shadow-inner">
                                        </div>

                                        <span
                                            class="ml-2 text-[10px] font-black uppercase {{ $isClosed ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $isClosed ? 'TUTUP' : 'BUKA' }}
                                        </span>
                                    </label>
                                </form>
                            </div>
                        </div>

                        <!-- AREA TOMBOL ACTION KEMBALI KE WARNA ASLI -->
                        <div class="flex justify-between items-center pt-3 border-t border-slate-100/70">
                            <a href="{{ route('penyelenggara.edit', $lomba->id) }}"
                                class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                                Kelola Lomba &rarr;
                            </a>

                            <button type="button" onclick="confirmDelete('{{ $lomba->id }}')"
                                class="text-red-600 hover:text-red-900 font-bold text-sm transition-colors">
                                Hapus Lomba
                            </button>

                            <form id="delete-form-{{ $lomba->id }}"
                                action="{{ route('penyelenggara.destroy', $lomba->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div
                    class="col-span-full bg-white rounded-[32px] border border-dashed border-slate-300 py-16 flex flex-col items-center justify-center text-center">
                    <span class="text-5xl mb-4">🚀</span>
                    <h3 class="text-xl font-extrabold text-slate-800">Belum Ada Kompetisi</h3>
                    <p class="text-slate-500 mt-2 mb-6 max-w-md">Anda belum mempublikasikan lomba apapun. Gunakan kuota
                        gratis Anda untuk mulai menjangkau ribuan peserta di Winly!</p>
                    <a href="{{ route('penyelenggara.create') }}"
                        class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-full transition-all shadow-lg">
                        Buat Kompetisi Pertama Anda
                    </a>
                </div>
            @endforelse

        </div>
        <!-- AKHIR BUNGKUSAN GRID -->

    </main>

    <x-footer />

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data lomba ini akan dihapus permanen dan tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus saja!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

</body>

</html>

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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($competitions as $lomba)
                @php
                    // --- LOGIKA CERDAS HARGA & BADGE ---
                    // Ambil semua bidang yang terhubung dengan lomba ini
                    $fields = $lomba->fields ?? collect();
                    $minPrice = $fields->min('harga') ?? 0;
                    $maxPrice = $fields->max('harga') ?? 0;

                    // Cek apakah ada bidang gratis dan bidang berbayar
                    $hasFree = $fields->where('harga', 0)->count() > 0;
                    $hasPaid = $fields->where('harga', '>', 0)->count() > 0;

                    // Format Teks Harga (Contoh: "FREE - Rp 50.000")
                    if ($fields->isEmpty()) {
                        $priceText = 'Rp 0';
                    } elseif ($minPrice == $maxPrice) {
                        // Jika semua bidang harganya sama (misal: semua gratis, atau semua 50rb)
                        $priceText = $minPrice == 0 ? 'FREE' : 'Rp ' . number_format($minPrice, 0, ',', '.');
                    } else {
                        // Jika harga bervariasi
                        $minText = $minPrice == 0 ? 'FREE' : 'Rp ' . number_format($minPrice, 0, ',', '.');
                        $maxText = 'Rp ' . number_format($maxPrice, 0, ',', '.');
                        $priceText = $minText . ' - ' . $maxText;
                    }
                @endphp

                <div
                    class="bg-white rounded-[24px] border border-slate-100 shadow-xl overflow-hidden flex flex-col relative">
                    <div class="relative h-60 w-full bg-slate-100">
                        <img src="{{ $lomba->poster ? asset('storage/' . $lomba->poster) : 'https://via.placeholder.com/600x400?text=Tanpa+Poster' }}"
                            class="w-full h-full object-cover">

                        <div class="absolute top-4 left-4">
                            @if ($lomba->status === 'aktif')
                                <span
                                    class="bg-green-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-md">Aktif</span>
                            @else
                                <span
                                    class="bg-amber-400 text-amber-900 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-md">Draf</span>
                            @endif
                        </div>

                        <div class="absolute top-4 right-4 flex gap-1.5">
                            @if ($hasFree)
                                <span
                                    class="bg-green-100/95 text-green-600 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm border border-green-200">FREE</span>
                            @endif
                            @if ($hasPaid)
                                <span
                                    class="bg-blue-100/95 text-blue-600 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm border border-blue-200">PREMIUM</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tingkat
                            {{ $lomba->tingkat_lomba }}</div>
                        <h3 class="text-lg font-black text-slate-900 leading-snug mb-4 line-clamp-2">
                            {{ $lomba->judul_lomba }}</h3>

                        <div class="space-y-2.5 mb-5">
                            <div class="flex items-start gap-3 text-sm text-slate-600">
                                <svg class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>

                        <div class="mb-5 mt-auto">
                            <span class="text-lg font-black text-slate-900">{{ $priceText }}</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                            <a href="{{ route('penyelenggara.edit', $lomba->id) }}"
                                class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                Kelola Lomba &rarr;
                            </a>

                            <button type="button" onclick="confirmDelete('{{ $lomba->id }}')"
                                class="text-red-600 hover:text-red-900 font-bold text-sm">
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Competitions - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-gradient-blur {
            background: radial-gradient(circle at 80% 50%, rgba(253, 224, 71, 0.35) 0%, transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(186, 230, 253, 0.4) 0%, transparent 40%);
        }

        .modal-open {
            overflow: hidden;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        /* Animasi Filter CSS */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col overflow-x-hidden relative">

    <div class="fixed inset-0 bg-gradient-blur -z-10"></div>
    <x-nav />

    <main class="flex-grow pt-28 px-4 md:px-8 w-full mx-auto mb-20">

        <div class="relative w-full max-w-7xl mx-auto rounded-[32px] overflow-hidden p-8 md:p-12 shadow-2xl flex flex-col items-start mb-16"
            style="background: linear-gradient(135deg, #1860D4 0%, #104AB2 100%);">
            <div class="absolute top-0 right-1/4 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col items-start w-full">
                <div class="flex items-center gap-3 md:gap-5 mb-8">
                    <span class="text-5xl md:text-6xl drop-shadow-md">☀️</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight">
                        Hai,
                        @auth
                            <span class="relative inline-block text-white">
                                {{ implode(' ', array_slice(explode(' ', auth()->user()->name), 0, 2)) }}!
                                <svg class="absolute w-full h-3 md:h-4 -bottom-1 md:-bottom-2 left-0 text-blue-300 opacity-90"
                                    viewBox="0 0 200 20" preserveAspectRatio="none">
                                    <path d="M0,10 Q50,20 100,10 T200,10" fill="none" stroke="currentColor"
                                        stroke-width="4" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        @else
                            <span class="relative inline-block text-white">
                                Sobat Winly!
                                <svg class="absolute w-full h-3 md:h-4 -bottom-1 md:-bottom-2 left-0 text-blue-300 opacity-90"
                                    viewBox="0 0 200 20" preserveAspectRatio="none">
                                    <path d="M0,10 Q50,20 100,10 T200,10" fill="none" stroke="currentColor"
                                        stroke-width="4" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        @endauth
                    </h1>
                </div>

                <div class="flex flex-col items-start pr-10 md:pl-28">
                    <span class="text-blue-200 text-sm md:text-base font-bold tracking-widest uppercase mb-1">Total
                        Point</span>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-5xl md:text-6xl font-black text-white tracking-tight drop-shadow-sm">1.350</span>
                        <span class="text-xl md:text-2xl font-semibold text-blue-200">pts</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="{
            showModal: false,
            compName: '',
            bidang: '',
            price: '',
            modalType: 'pilihan',
            activeTab: 'gratis',
            fieldId: null
        }" class="w-full max-w-7xl mx-auto">

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Kompetisi Tersedia</h2>
            </div>

            @if ($errors->any())
                <div
                    class="mb-8 bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-xl font-bold text-sm shadow-sm">
                    <p class="mb-2">⚠️ Terjadi Kesalahan:</p>
                    <ul class="list-disc pl-5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8 items-start relative">

                <x-sidebar-filter />

                <div class="flex-grow w-full min-w-0">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 w-full">

                        @forelse($competitions as $lomba)
                            @php
                                $hasGratis =
                                    $lomba->fields->contains('tipe_pendaftaran', 'gratis') ||
                                    $lomba->fields->contains('tipe_pendaftaran', 'pilihan');
                                $hasPremium =
                                    $lomba->fields->contains('tipe_pendaftaran', 'berbayar') ||
                                    $lomba->fields->contains('tipe_pendaftaran', 'pilihan');
                                $minPrice = $lomba->fields->min('harga');
                                $maxPrice = $lomba->fields->max('harga');

                                if ($minPrice == 0 && $maxPrice > 0) {
                                    $priceSummary = 'FREE - Rp ' . number_format($maxPrice, 0, ',', '.');
                                } elseif ($minPrice == 0 && $maxPrice == 0) {
                                    $priceSummary = 'FREE';
                                } else {
                                    $priceSummary = 'Rp ' . number_format($minPrice, 0, ',', '.');
                                }

                                $benefits = is_array($lomba->benefits)
                                    ? $lomba->benefits
                                    : json_decode($lomba->benefits, true) ?? [];
                            @endphp

                            <div <div data-tingkat="{{ strtolower($lomba->tingkat_sekolah ?? '') }}"
                                data-kategori="{{ strtolower($lomba->kategori ?? '') }}"
                                data-biaya="{{ $hasGratis ? 'gratis' : '' }} {{ $hasPremium ? 'premium' : '' }}"
                                class="lomba-card bg-white rounded-[24px] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col group hover:-translate-y-1 transition-all duration-300 relative z-0">

                                <div class="relative w-full aspect-[1/1] bg-red-100 rounded-t-[24px] overflow-hidden">
                                    <img src="{{ $lomba->poster ? asset('storage/' . $lomba->poster) : 'https://via.placeholder.com/400x500?text=Poster' }}"
                                        alt="Poster Lomba"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute top-4 right-4 flex gap-1.5">
                                        @if ($hasGratis)
                                            <span
                                                class="bg-green-100/90 text-green-600 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm border border-green-200 shadow-sm">FREE</span>
                                        @endif
                                        @if ($hasPremium)
                                            <span
                                                class="bg-blue-100/90 text-blue-600 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm border border-blue-200 shadow-sm">PREMIUM</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow rounded-b-[24px]">
                                    <h3 class="text-lg font-black text-slate-900 leading-tight mb-4 line-clamp-2"
                                        title="{{ $lomba->judul_lomba }}">{{ $lomba->judul_lomba }}</h3>

                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-start gap-3 text-sm text-slate-600 font-medium">
                                            <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                                        @forelse($benefits as $ben)
                                            <span
                                                class="px-3 py-1.5 bg-indigo-50/50 text-indigo-600 text-[11px] font-bold rounded-lg border border-indigo-100 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $ben }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400 italic">Fasilitas belum tersedia</span>
                                        @endforelse
                                    </div>

                                    <div class="flex items-center justify-between mb-6">
                                        <span class="text-xl font-black text-slate-900">{{ $priceSummary }}</span>
                                        <div
                                            class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-indigo-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            {{ $lomba->registrations_count ?? 0 }} Peserta
                                        </div>
                                    </div>

                                    <div class="pt-5 border-t border-slate-100 flex items-center justify-between relative"
                                        x-data="{ showDropdown: false }">
                                        <a href="{{ $lomba->link_panduan ?? '#' }}" target="_blank"
                                            class="flex items-center gap-2 text-slate-400 hover:text-indigo-600 transition-colors font-bold text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                </path>
                                            </svg>
                                            Panduan
                                        </a>

                                        <div class="relative">
                                            @auth
                                                <button @click="showDropdown = !showDropdown"
                                                    @click.away="showDropdown = false"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all active:scale-95">
                                                    Daftar
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 transition-transform"
                                                        :class="showDropdown ? 'rotate-180' : ''" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </button>

                                                <div x-show="showDropdown" style="display: none;"
                                                    class="absolute bottom-full right-0 mb-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50 overflow-hidden">
                                                    <div
                                                        class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 mb-1 bg-slate-50/50">
                                                        Pilih Bidang</div>
                                                    @forelse($lomba->fields as $bidang)
                                                        @php
                                                            if ($bidang->tipe_pendaftaran === 'gratis') {
                                                                $mType = 'gratis_only';
                                                                $aTab = 'gratis';
                                                                $pText = 'Gratis';
                                                                $color = 'green';
                                                            } elseif ($bidang->tipe_pendaftaran === 'berbayar') {
                                                                $mType = 'berbayar_only';
                                                                $aTab = 'berbayar';
                                                                $pText =
                                                                    'Rp ' . number_format($bidang->harga, 0, ',', '.');
                                                                $color = 'blue';
                                                            } else {
                                                                $mType = 'pilihan';
                                                                $aTab = 'gratis';
                                                                $pText =
                                                                    'Rp ' . number_format($bidang->harga, 0, ',', '.');
                                                                $color = 'indigo';
                                                            }
                                                        @endphp
                                                        <button
                                                            @click="compName = '{{ addslashes($lomba->judul_lomba) }}'; bidang = '{{ addslashes($bidang->nama_bidang) }}'; price = '{{ $pText }}'; modalType = '{{ $mType }}'; activeTab = '{{ $aTab }}'; fieldId = '{{ $bidang->id }}'; showModal = true; showDropdown = false;"
                                                            class="block w-full flex justify-between items-center px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-{{ $color }}-50 hover:text-{{ $color }}-600 transition-colors border-t border-slate-50 first:border-t-0">
                                                            <span>{{ $bidang->nama_bidang }}</span>
                                                            <span
                                                                class="text-xs font-black text-{{ $color }}-500">{{ $pText }}</span>
                                                        </button>
                                                    @empty
                                                        <div class="px-4 py-3 text-xs text-slate-500 text-center">Belum ada
                                                            bidang</div>
                                                    @endforelse
                                                </div>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all active:scale-95">
                                                    Daftar
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div
                                    class="col-span-full py-20 text-center flex flex-col items-center bg-white rounded-[32px] shadow-sm border border-slate-100">
                                    <span class="text-6xl mb-4 block">📭</span>
                                    <h3 class="text-xl font-bold text-slate-800">Belum ada kompetisi yang aktif</h3>
                                    <p class="text-slate-500 mt-2">Coba kembali lagi nanti ya, Sobat Winly!</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div x-show="showModal" style="display: none;"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">

                    <div x-show="showModal" @click="showModal = false"
                        class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

                    <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data"
                        x-show="showModal"
                        class="bg-white w-full max-w-2xl rounded-[24px] overflow-hidden shadow-2xl relative z-10 border border-slate-100 flex flex-col max-h-[90vh]">

                        @csrf
                        <input type="hidden" name="field_id" :value="fieldId">
                        <input type="hidden" name="jalur" :value="price === 'Gratis' ? 'gratis' : 'berbayar'">

                        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-start bg-slate-50/50">
                            <div>
                                <h2 class="text-xl font-extrabold text-slate-900">Registrasi Kompetisi</h2>
                                <p class="text-sm font-semibold text-slate-500 mt-1"><span x-text="compName"></span> -
                                    <span class="text-blue-600" x-text="bidang"></span></p>
                            </div>
                            <button type="button" @click="showModal = false"
                                class="p-2 bg-white hover:bg-slate-200 rounded-full transition-colors">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                            <div x-show="price !== 'Gratis'" style="display: none;">
                                <div class="bg-blue-50/40 border border-blue-100 rounded-xl p-5 mb-2">
                                    <h4 class="font-extrabold text-slate-800 mb-3 text-sm">Keuntungan Registrasi Berbayar:
                                    </h4>
                                    <ul class="space-y-2.5">
                                        <li class="flex items-start gap-2.5 text-sm text-slate-600 font-medium">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Pembayaran otomatis terverifikasi via sistem
                                        </li>
                                        <li class="flex items-start gap-2.5 text-sm text-slate-600 font-medium">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tidak perlu repot upload bukti Follow/Share
                                        </li>
                                        <li class="flex items-start gap-2.5 text-sm text-slate-600 font-medium">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Proses registrasi lebih cepat & prioritas
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div x-show="price === 'Gratis'" style="display: none;" class="space-y-4">
                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 mb-2">
                                    <p class="text-sm text-amber-800 font-semibold">⚠️ Jalur gratis mewajibkan Anda untuk
                                        mengupload 3 bukti persyaratan di bawah ini.</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">1. Bukti Follow IG
                                            <span class="text-red-500">*</span></label>
                                        <input type="file" name="bukti_follow" :required="price === 'Gratis'"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">2. Bukti Share Poster
                                            <span class="text-red-500">*</span></label>
                                        <input type="file" name="bukti_share" :required="price === 'Gratis'"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">3. Bukti Tag/Komen di
                                            Postingan <span class="text-red-500">*</span></label>
                                        <input type="file" name="bukti_komentar" :required="price === 'Gratis'"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">*Format file wajib JPG, PNG, atau PDF (Maks. 2MB
                                    per file).</p>
                            </div>
                        </div>

                        <div
                            class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between rounded-b-[24px]">

                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-slate-500">Total:</span>
                                <span class="text-2xl font-black"
                                    :class="price === 'Gratis' ? 'text-green-600' : 'text-slate-900'"
                                    x-text="price"></span>
                            </div>

                            <div class="flex gap-3">
                                <button type="button" @click="showModal = false"
                                    class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition-colors">Batal</button>

                                <button type="submit"
                                    class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-lg transition-all active:scale-95 flex items-center gap-2"
                                    :class="price === 'Gratis' ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' :
                                        'bg-[#10B981] hover:bg-[#059669] shadow-green-200'">
                                    <span x-text="price === 'Gratis' ? 'Kirim Pendaftaran' : 'Lanjut Bayar'"></span>
                                    <svg x-show="price !== 'Gratis'" class="w-4 h-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            </div>
        </main>

        <x-footer />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterBtns = document.querySelectorAll('.filter-btn');
                const cards = document.querySelectorAll('.lomba-card');

                filterBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const group = btn.getAttribute('data-group');

                        document.querySelectorAll(`.filter-btn[data-group="${group}"]`).forEach(b => {
                            b.classList.remove('bg-blue-50', 'text-blue-700');
                            b.classList.add('text-slate-600', 'hover:bg-slate-50');
                        });

                        btn.classList.remove('text-slate-600', 'hover:bg-slate-50');
                        btn.classList.add('bg-blue-50', 'text-blue-700');

                        filterCards();
                    });
                });

                function filterCards() {
                    const activeTingkat = document.querySelector('.filter-btn[data-group="tingkat"].bg-blue-50')
                        .getAttribute('data-filter');
                    const activeKategori = document.querySelector('.filter-btn[data-group="kategori"].bg-blue-50')
                        .getAttribute('data-filter');
                    const activeBiaya = document.querySelector('.filter-btn[data-group="biaya"].bg-blue-50')
                        .getAttribute('data-filter');

                    cards.forEach(card => {
                        const cardTingkat = card.getAttribute('data-tingkat') || '';
                        const cardKategori = card.getAttribute('data-kategori') || '';
                        const cardBiaya = card.getAttribute('data-biaya') || '';

                        const matchTingkat = (activeTingkat === 'semua') || cardTingkat.includes(activeTingkat);
                        const matchKategori = (activeKategori === 'semua') || cardKategori.includes(
                            activeKategori);
                        const matchBiaya = (activeBiaya === 'semua') || cardBiaya.includes(activeBiaya);

                        if (matchTingkat && matchKategori && matchBiaya) {
                            card.style.display = 'flex';
                            card.style.animation = 'fadeIn 0.4s ease-in-out';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        </script>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "Mantap!",
                    confirmButtonColor: "#2563eb",
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-2.5 font-bold'
                    }
                });
            </script>
        @endif
    </body>

    </html>

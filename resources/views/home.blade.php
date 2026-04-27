<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-gradient-blur {
            /* Warna kuning pastel (253, 224, 71) */
            background: radial-gradient(circle at 80% 50%, rgba(253, 224, 71, 0.35) 0%, transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(186, 230, 253, 0.4) 0%, transparent 40%);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col overflow-x-hidden relative">

    <div class="fixed inset-0 bg-gradient-blur -z-10"></div>

    <x-nav />

    <main class="flex-grow flex items-center justify-center py-36">
        <section class="max-w-4xl mx-auto px-6 text-center">
            <div class="flex justify-center mb-6">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/70 backdrop-blur-md border border-slate-200 text-xs font-medium text-slate-600 shadow-sm">
                    🏆 Find Your Competitions in Here
                </span>
            </div>

            <section>
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
                    Jadilah juara sekolah lewat olimpiade! 🏆
                </h1>
            </section>

            <p class="text-slate-600 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl mx-auto">
                Bayangkan namamu dipanggil saat upacara sekolah, fotomu terpampang di papan pengumuman,
                dan semua orang mengenalimu sebagai pemenang Olimpiade. Mulailah perjalananmu di sini!
            </p>

            <div class="flex flex-wrap justify-center gap-4 mb-16">
                @php
                    if (auth()->check()) {
                        if (auth()->user()->role === 'penyelenggara') {
                            $teks_tombol = 'Tambahkan Lombamu Sekarang';
                            $url_tujuan = route('penyelenggara.dashboard');
                        } else {
                            $teks_tombol = 'Daftar Lomba Sekarang';
                            $url_tujuan = route('competitions');
                        }
                    } else {
                        $teks_tombol = 'Daftar Lomba Sekarang';
                        $url_tujuan = route('login');
                    }
                @endphp

                <a href="{{ $url_tujuan }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-semibold transition-all shadow-lg shadow-indigo-200 active:scale-95">
                    {{ $teks_tombol }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                        <path d="M18 9H19.5a2.5 2.5 0 0 0 0-5H18"></path>
                        <path d="M4 22h16"></path>
                        <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                    </svg>
                </a>

            </div>

            <div class="flex flex-wrap justify-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-green-100/80 rounded-full border border-green-200">
                    <span class="text-green-600">✅</span>
                    <span class="text-sm font-bold text-green-800">10,000+ Peserta</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-blue-100/80 rounded-full border border-blue-200">
                    <span class="text-blue-600">🏆</span>
                    <span class="text-sm font-bold text-blue-800">200+ Kompetisi</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-purple-100/80 rounded-full border border-purple-200">
                    <span class="text-purple-600">🚀</span>
                    <span class="text-sm font-bold text-purple-800">50+ Sekolah Mitra</span>
                </div>
            </div>
        </section>

    </main>


    {{-- card informasi h-7 --}}
    <div class="max-w-screen-2xl mx-auto text-left w-full px-4">

        <div class="flex items-center justify-between mb-6 px-2">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Upcoming Deadlines (H-7)</h2>
            <a href="#"
                class="text-base md:text-lg font-bold text-blue-600 hover:text-blue-700 transition-colors">View all</a>
        </div>

        <div
            class="bg-blue-200 backdrop-blur-xl border border-white/60 rounded-[32px] p-6 md:p-8 flex items-center justify-between shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:scale-[1.02] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 cursor-pointer">

            <div class="flex items-center gap-6 md:gap-8">

                <div
                    class="w-20 h-20 md:w-24 md:h-24 rounded-2xl shrink-0 shadow-sm overflow-hidden bg-white/80 border border-white">
                    <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                        alt="Poster Global Innovation Challenge" class="w-full h-full object-cover">
                </div>

                <div>
                    <h3 class="text-xl md:text-3xl font-extrabold text-slate-900 mb-1 tracking-tight">Global Innovation
                        Challenge</h3>
                    <p class="text-base md:text-lg font-medium text-slate-700/80">Submission deadline in 3 days</p>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2 md:gap-3 shrink-0">
                <span
                    class="bg-red-500 backdrop-blur-sm text-white text-xs md:text-sm font-bold px-4 py-2 rounded-full tracking-wider uppercase shadow-sm border border-[#71530E]/20">
                    Urgent
                </span>
                <span class="text-base md:text-xl font-extrabold text-slate-900">
                    Oct 24, 2026
                </span>
            </div>

        </div>

    </div>
    {{-- card informasi poster --}}
    <section class="mt-32 max-w-7xl mx-auto px-6 mb-24 w-full">

        <div class="text-center mb-14">
            <div
                class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-sm font-bold mb-5 shadow-sm">
                🏆 Kompetisi Seru
            </div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-5 tracking-tight">
                Kompetisi Mendatang!
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto font-medium leading-relaxed">
                Ikuti kompetisi olimpiade sains dan tunjukkan potensimu bersama ribuan pelajar dari seluruh Indonesia.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <div
                class="bg-white rounded-[28px] border border-slate-200 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col group">

                <div class="relative h-[450px] w-full bg-[#f8fafc] overflow-hidden rounded-t-[28px]">
                    <img src="https://i.pinimg.com/736x/05/2b/6e/052b6eee9ed668347dcff784f356f784.jpg"
                        alt="Poster Lomba"
                        class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 right-6 bg-blue-100/80 rounded-full border border-blue-200 text-blue-500 text-[11px] font-extrabold px-3 py-1.5 uppercase tracking-wider shadow-md">
                        PREMIUM
                    </div>
                    <div
                        class="absolute top-4 left-48 bg-green-100/80 rounded-full border border-green-200 text-green-500 text-[11px] font-extrabold px-6 py-1.5 uppercase tracking-wider shadow-md">
                        FREE
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-extrabold text-slate-900 leading-snug mb-5 line-clamp-2">
                        PESTA SAINS NASIONAL (PSN) TAHUN 2026
                    </h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                            <span class="font-medium mt-0.5">Minggu, 12 April 2026</span>
                        </div>
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span class="font-medium mt-0.5 leading-relaxed">Pendaftaran: Kamis, 19 Februari 2026 -
                                Jumat, 10 April 2026</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 text-[11px] font-bold rounded-lg border border-blue-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            </svg> E-Sertifikat
                        </span>
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-600 text-[11px] font-bold rounded-lg border border-purple-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9H19.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                            </svg> E-money
                        </span>
                    </div>

                    <div class="mt-auto pt-5 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-2xl font-black text-slate-900 tracking-tight">Rp 50.000</span>
                            <span
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> 179 Peserta
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="#"
                                class="flex items-center gap-1.5 text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" x2="12" y1="15" y2="3"></line>
                                </svg> Panduan
                            </a>
                            <a href="#"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[15px] font-bold rounded-full transition-all shadow-lg shadow-blue-200 active:scale-95 flex items-center gap-2">
                                Daftar <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[28px] border border-slate-200 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                <div class="relative h-[450px] w-full bg-[#f8fafc] overflow-hidden rounded-t-[28px]">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Poster Lomba"
                        class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 right-6 bg-blue-100/80 rounded-full border border-blue-200 text-blue-500 text-[11px] font-extrabold px-3 py-1.5 uppercase tracking-wider shadow-md">
                        PREMIUM
                    </div>
                    <div
                        class="absolute top-4 left-48 bg-green-100/80 rounded-full border border-green-200 text-green-500 text-[11px] font-extrabold px-6 py-1.5 uppercase tracking-wider shadow-md">
                        FREE
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-extrabold text-slate-900 leading-snug mb-5 line-clamp-2">
                        Senior High School Olympiad (SHSO) 2026 Provinsi Maluku Utara
                    </h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2">
                                </rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                            <span class="font-medium mt-0.5">Sabtu, 18 April 2026</span>
                        </div>
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span class="font-medium mt-0.5 leading-relaxed">Pendaftaran: Selasa, 20 Januari 2026 -
                                Senin, 6 April 2026</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 text-[11px] font-bold rounded-lg border border-blue-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            </svg> E-Sertifikat
                        </span>
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-600 text-[11px] font-bold rounded-lg border border-amber-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg> Pembahasan
                        </span>
                    </div>
                    <div class="mt-auto pt-5 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-2xl font-black text-slate-900 tracking-tight">FREE</span>
                            <span
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> 10 Peserta
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="#"
                                class="flex items-center gap-1.5 text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" x2="12" y1="15" y2="3"></line>
                                </svg> Panduan
                            </a>
                            <a href="#"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[15px] font-bold rounded-full transition-all shadow-lg shadow-blue-200 active:scale-95 flex items-center gap-2">
                                Daftar <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[28px] border border-slate-200 overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                <div class="relative h-[450px] w-full bg-[#f8fafc] overflow-hidden rounded-t-[28px]">
                    <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Poster Lomba"
                        class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                    <div
                        class="absolute top-4 right-6 bg-blue-100/80 rounded-full border border-blue-200 text-blue-500 text-[11px] font-extrabold px-3 py-1.5 uppercase tracking-wider shadow-md">
                        PREMIUM
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-extrabold text-slate-900 leading-snug mb-5 line-clamp-2">
                        MADRASAH SCIENCE COMPETITION (MASCO) TAHUN 2026
                    </h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2">
                                </rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                            <span class="font-medium mt-0.5">Minggu, 19 April 2026</span>
                        </div>
                        <div class="flex items-start gap-3 text-slate-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-blue-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span class="font-medium mt-0.5 leading-relaxed">Pendaftaran: Senin, 23 Februari 2026 -
                                Jumat, 17 April 2026</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 text-[11px] font-bold rounded-lg border border-blue-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            </svg> E-Sertifikat
                        </span>
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-600 text-[11px] font-bold rounded-lg border border-amber-100/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg> Pembahasan
                        </span>
                    </div>
                    <div class="mt-auto pt-5 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-2xl font-black text-slate-900 tracking-tight">Rp 50.000</span>
                            <span
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> 54 Peserta
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="#"
                                class="flex items-center gap-1.5 text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" x2="12" y1="15" y2="3"></line>
                                </svg> Panduan
                            </a>
                            <a href="#"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[15px] font-bold rounded-full transition-all shadow-lg shadow-blue-200 active:scale-95 flex items-center gap-2">
                                Daftar <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</body>

<x-footer />

</html>

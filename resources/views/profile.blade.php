    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Profil Saya - Winly</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
            rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>

    <body class="bg-slate-50 min-h-screen">
        <x-nav />

        <main class="pt-32 pb-20 px-6 max-w-4xl mx-auto" x-data="{ editMode: false }">

            @if (session('success'))
                <div class="mb-6 bg-green-50 text-green-600 font-bold px-5 py-4 rounded-2xl border border-green-200">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (!auth()->user()->isProfileComplete())
                <div
                    class="mb-6 bg-amber-50 text-amber-700 font-bold px-5 py-4 rounded-2xl border border-amber-200 flex items-start gap-3">
                    <span class="text-xl">⚠️</span>
                    <p>Profil kamu belum lengkap! Lengkapi <b>Nama Lengkap, No WA, Tingkat Pendidikan, dan Asal
                            Instansi</b> untuk bisa mendaftar lomba.</p>
                </div>
            @endif

            <div class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm border border-slate-200 relative overflow-hidden">
                <div class="flex justify-between items-end mb-8 border-b border-slate-100 pb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Diri Peserta</h1>
                        <p class="text-slate-500 mt-2 font-medium">Informasi ini akan digunakan untuk e-sertifikat dan
                            pengiriman hadiah.</p>
                    </div>
                    <button @click="editMode = !editMode"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors text-sm flex items-center gap-2">
                        <span x-text="editMode ? 'Batal Edit' : 'Edit Profil'"></span>
                    </button>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Username /
                                Email</label>
                            <input type="text" value="{{ $user->email }}" disabled
                                class="w-full bg-slate-100 text-slate-500 font-bold rounded-xl p-3 border-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" :disabled="!editMode"
                                required
                                :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' :
                                    'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                                class="w-full font-bold rounded-xl p-3 border transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor WhatsApp
                                *</label>
                            <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}"
                                :disabled="!editMode" required placeholder="08123456789"
                                :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' :
                                    'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                                class="w-full font-bold rounded-xl p-3 border transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Asal Sekolah / Instansi
                                *</label>
                            <input type="text" name="asal_instansi"
                                value="{{ old('asal_instansi', $profile->asal_instansi) }}" :disabled="!editMode"
                                required placeholder="Cth: SMAN 1 Surabaya"
                                :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' :
                                    'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                                class="w-full font-bold rounded-xl p-3 border transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tingkat Pendidikan
                                *</label>
                            <select name="tingkat_pendidikan" :disabled="!editMode" required
                                :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' :
                                    'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                                class="w-full font-bold rounded-xl p-3 border transition-all">
                                <option value="">Pilih Tingkat</option>
                                <option value="SD" {{ $profile->tingkat_pendidikan == 'SD' ? 'selected' : '' }}>
                                    Sekolah Dasar (SD)</option>
                                <option value="SMP" {{ $profile->tingkat_pendidikan == 'SMP' ? 'selected' : '' }}>SMP
                                    / Sederajat</option>
                                <option value="SMA" {{ $profile->tingkat_pendidikan == 'SMA' ? 'selected' : '' }}>SMA
                                    / SMK / Sederajat</option>
                                <option value="Mahasiswa"
                                    {{ $profile->tingkat_pendidikan == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                </option>
                                <option value="Umum" {{ $profile->tingkat_pendidikan == 'Umum' ? 'selected' : '' }}>
                                    Umum</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="editMode" x-collapse class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg shadow-blue-200 transition-all active:scale-95">
                            Simpan Perubahan Data
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <div class="w-full max-w-7xl mx-auto mt-16 pt-10 border-t border-slate-200/60">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-inner">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Lomba Tersimpan</h2>
                    </div>
                    <p class="text-slate-500 font-medium text-sm ml-14">Daftar kompetisi yang kamu tandai untuk diikuti.</p>
                </div>
                
                <div class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2">
                    <span class="text-blue-600">{{ $bookmarkedCompetitions->count() }}</span> Lomba
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                @forelse($bookmarkedCompetitions as $lomba)
                    @php
                        // Logika Harga (Sama seperti halaman depan)
                        $hasGratis = $lomba->fields->contains('tipe_pendaftaran', 'gratis') || $lomba->fields->contains('tipe_pendaftaran', 'pilihan');
                        $hasPremium = $lomba->fields->contains('tipe_pendaftaran', 'berbayar') || $lomba->fields->contains('tipe_pendaftaran', 'pilihan');

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

                    <div class="bg-white rounded-[24px] border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col group hover:-translate-y-1 transition-all duration-300 relative z-0">
                        
                        <div class="relative w-full aspect-[1/1] bg-slate-100 rounded-t-[24px] overflow-hidden">
                            <img src="{{ $lomba->poster ? asset('storage/' . $lomba->poster) : 'https://via.placeholder.com/400x500?text=Poster' }}"
                                alt="Poster Lomba" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-4 right-4 flex gap-1.5">
                                @if ($hasGratis)
                                    <span class="bg-green-100/95 text-green-700 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm border border-green-200 shadow-sm">FREE</span>
                                @endif
                                @if ($hasPremium)
                                    <span class="bg-blue-100/95 text-blue-700 text-[10px] font-extrabold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm border border-blue-200 shadow-sm">PREMIUM</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow rounded-b-[24px]">
                            
                            <div class="flex items-start justify-between gap-2 mb-4" x-data="{ showMenu: false }">
                                <h3 class="text-lg font-black text-slate-900 leading-tight line-clamp-2 h-[3.5rem] flex-grow" title="{{ $lomba->judul_lomba }}">
                                    {{ $lomba->judul_lomba }}
                                </h3>

                                <div class="relative flex-shrink-0 mt-1">
                                    <button @click="showMenu = !showMenu" @click.away="showMenu = false" 
                                        class="p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors focus:outline-none">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                        </svg>
                                    </button>

                                    <div x-show="showMenu" style="display: none;"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-30">
                                        
                                        <a href="https://wa.me/?text=Halo!%20Cek%20lomba%20menarik%20ini%20di%20Winly:%20{{ urlencode($lomba->judul_lomba) }}%20-%20{{ url()->current() }}" 
                                            target="_blank"
                                            class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-600 hover:text-green-600 hover:bg-green-50 transition-colors w-full text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                            Bagikan ke WA
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 mb-5">
                                <div class="flex items-start gap-3 text-sm text-slate-600 font-medium">
                                    <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</span>
                                </div>

                                <div class="flex items-center gap-3 text-sm font-medium">
                                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div class="text-slate-600 flex flex-wrap items-center gap-1.5">
                                        <span>Daftar:</span>
                                        <span class="text-amber-600 text-xs font-bold">
                                            {{ date('d M', strtotime($lomba->tgl_buka_pendaftaran)) }} - {{ date('d M Y', strtotime($lomba->tgl_tutup_pendaftaran)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md border border-indigo-100 bg-indigo-50/50 text-indigo-600 text-[10px] font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    E-Sertifikat
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md border border-indigo-100 bg-indigo-50/50 text-indigo-600 text-[10px] font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Medali Fisik
                                </span>
                            </div>

                            @php
                                $totalPendaftar = $lomba->registrations_count ?? $lomba->registrations()->count() ?? 0;
                            @endphp
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-lg font-black text-slate-900">{{ $priceText }}</span>
                                <div class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-indigo-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $totalPendaftar }} Peserta
                                </div>
                            </div>

                            <div class="border-t border-slate-100 pt-4 mt-auto flex items-center justify-between gap-3">
                                
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('bookmark.toggle', $lomba->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors border border-red-100" title="Hapus dari simpanan">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    <a href="#" class="text-xs font-bold text-slate-400 hover:text-slate-600 flex items-center gap-1.5 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Panduan
                                    </a>
                                </div>

                                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 transition-all active:scale-95 flex items-center gap-1.5">
                                    Daftar
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center flex flex-col items-center bg-white/50 backdrop-blur-sm rounded-[32px] border border-dashed border-slate-300">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800">Belum Ada Lomba Disimpan</h3>
                        <p class="text-slate-500 mt-2 max-w-sm">Kamu belum menyimpan kompetisi apa pun. Jelajahi halaman utama dan temukan lomba impianmu!</p>
                        <a href="{{ route('home') }}" class="mt-6 px-6 py-2.5 bg-white border border-slate-200 hover:border-blue-300 hover:text-blue-600 text-slate-600 font-bold rounded-full transition-all shadow-sm text-sm">
                            Jelajahi Lomba
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </body>

    </html>

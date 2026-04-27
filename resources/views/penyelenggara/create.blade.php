<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Lomba Baru - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen relative pb-20">

    <x-nav />

    <main x-data="lombaBuilder()"
        class="pt-28 px-4 md:px-8 w-full max-w-7xl mx-auto flex flex-col lg:flex-row gap-8 items-start">

        <div class="w-full lg:w-3/5 bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
            <div class="mb-6 border-b border-slate-100 pb-4">
                <h1 class="text-2xl font-extrabold text-slate-900">Buat Lomba Baru</h1>
                <p class="text-slate-500 text-sm mt-1">Lengkapi data di bawah ini. Tampilan kartu lomba akan terupdate
                    otomatis di sebelah kanan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-5 py-3 rounded-xl text-sm font-bold">
                    ⚠️ Terjadi Kesalahan:
                    <ul class="list-disc ml-5 mt-1 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penyelenggara.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <div class="space-y-4">
                    <h3
                        class="text-sm font-bold text-slate-800 uppercase tracking-widest border-l-4 border-blue-500 pl-3">
                        Aset & Link Utama</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Upload Poster *</label>
                            <input type="file" name="poster" accept="image/*" @change="handlePoster" required
                                class="w-full text-sm text-slate-500 border border-slate-200 rounded-xl p-2.5 bg-slate-50 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Link Google Drive Juknis
                                *</label>
                            <input type="url" name="link_panduan" x-model="gdrive" required
                                placeholder="https://drive.google.com/..."
                                class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl p-2.5 bg-white focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3
                        class="text-sm font-bold text-slate-800 uppercase tracking-widest border-l-4 border-blue-500 pl-3 mb-2">
                        Informasi Dasar</h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Lomba *</label>
                        <input type="text" name="judul_lomba" x-model="judul" required
                            placeholder="Contoh: Science Olympiad 2026"
                            class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl p-2.5 bg-white focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Kategori Lomba <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            @php
                                $categories = [
                                    'akademik' => 'Olimpiade & Akademik',
                                    'teknologi_it' => 'Teknologi & IT',
                                    'ekonomi_bisnis' => 'Ekonomi & Bisnis',
                                    'karya_tulis' => 'Karya Tulis & Riset',
                                    'seni_desain' => 'Seni & Desain',
                                    'kesehatan' => 'Kesehatan & Medis',
                                    'soshum_hukum' => 'Soshum & Hukum'
                                ];
                            @endphp

                            @foreach($categories as $value => $label)
                            <label class="relative cursor-pointer h-full">
                                <input type="radio" name="kategori" value="{{ $value }}" class="peer sr-only" required>
                                <div class="h-full p-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:bg-slate-50 transition-all flex items-center justify-center text-center">
                                    <span class="block text-xs font-bold text-slate-800 peer-checked:text-blue-700 leading-tight">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Tingkat Pendidikan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            @php
                                $levels = [
                                    'sd' => 'Sekolah Dasar (SD)',
                                    'smp' => 'SMP / Sederajat',
                                    'sma' => 'SMA / SMK',
                                    'mahasiswa' => 'Mahasiswa / Umum'
                                ];
                            @endphp

                            @foreach($levels as $value => $label)
                            <label class="relative cursor-pointer h-full">
                                <input type="radio" name="tingkat_sekolah" value="{{ $value }}" class="peer sr-only" required>
                                <div class="h-full p-3 rounded-xl border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:bg-slate-50 transition-all flex items-center justify-center text-center">
                                    <span class="block text-xs font-bold text-slate-800 peer-checked:text-indigo-700 leading-tight">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Wilayah Lomba *</label>
                            <select name="tingkat_lomba" x-model="tingkat"
                                class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl p-2.5 bg-white">
                                <option value="kota">Tingkat Kota / Kabupaten</option>
                                <option value="umum">Umum</option>
                                <option value="provinsi">Tingkat Provinsi</option>
                                <option value="nasional">Tingkat Nasional</option>
                                <option value="internasional">Tingkat Internasional</option>
                            </select>
                            <p class="text-[10px] text-blue-500 mt-1" x-show="tingkat === 'kota' || tingkat === 'umum'">
                                *Promo Gratis Berlaku (Potong Kuota)</p>
                            <p class="text-[10px] text-amber-500 mt-1"
                                x-show="tingkat !== 'kota' && tingkat !== 'umum'">*Berbayar (Via Midtrans)</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pelaksanaan (Hari H)
                                *</label>
                            <input type="date" name="tanggal_pelaksanaan" x-model="tanggal" required
                                class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl p-2.5 bg-white">
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3
                        class="text-sm font-bold text-slate-800 uppercase tracking-widest border-l-4 border-blue-500 pl-3">
                        Fasilitas Lomba</h3>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" name="benefits[]" value="E-Sertifikat" x-model="benefits"
                                class="w-4 h-4 rounded text-blue-600"> E-Sertifikat
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" name="benefits[]" value="E-Money" x-model="benefits"
                                class="w-4 h-4 rounded text-blue-600"> E-Money
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" name="benefits[]" value="Medali Fisik" x-model="benefits"
                                class="w-4 h-4 rounded text-blue-600"> Medali Fisik
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" name="benefits[]" value="Pembahasan" x-model="benefits"
                                class="w-4 h-4 rounded text-blue-600"> Video Pembahasan
                        </label>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center">
                        <h3
                            class="text-sm font-bold text-slate-800 uppercase tracking-widest border-l-4 border-blue-500 pl-3">
                            Daftar Bidang & Grup WA</h3>
                        <button type="button" @click="addBidang"
                            class="text-xs font-bold bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-200">+
                            Tambah Bidang</button>
                    </div>

                    <template x-for="(item, index) in bidangs" :key="item.id">
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group">
                            <button type="button" @click="removeBidang(item.id)" x-show="bidangs.length > 1"
                                class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Nama
                                        Bidang</label>
                                    <input type="text" :name="`bidang[${index}][nama_bidang]`" x-model="item.nama"
                                        required placeholder="Cth: Matematika"
                                        class="w-full text-sm border border-slate-200 rounded-lg p-2 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Harga
                                        Pendaftaran (Rp)</label>
                                    <input type="number" :name="`bidang[${index}][harga]`" x-model="item.harga"
                                        required min="0" placeholder="0 jika gratis"
                                        class="w-full text-sm border border-slate-200 rounded-lg p-2 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Link Grup
                                        WA</label>
                                    <input type="url" :name="`bidang[${index}][link_wa]`" x-model="item.wa"
                                        required placeholder="https://chat.whatsapp..."
                                        class="w-full text-sm border border-slate-200 rounded-lg p-2 bg-white">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('penyelenggara.dashboard') }}"
                        class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-full">Batal</a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-full shadow-lg transition-transform active:scale-95">
                        Terbitkan Lomba Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full lg:w-2/5 lg:sticky lg:top-32">
            <div class="text-sm font-bold text-slate-400 mb-4 text-center uppercase tracking-widest">Live Preview Kartu
            </div>

            <div
                class="bg-white rounded-[24px] border border-slate-100 shadow-xl overflow-hidden flex flex-col relative w-full max-w-sm mx-auto">
                <div class="relative h-60 w-full bg-slate-100">
                    <img :src="posterPreview || 'https://via.placeholder.com/400x500?text=Preview+Poster'"
                        class="w-full h-full object-cover">
                    <div class="absolute top-4 right-4 flex gap-2">
                        <span x-show="tingkat === 'kota' || tingkat === 'umum'"
                            class="bg-green-100/95 text-green-600 text-[10px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm border border-green-200">FREE</span>
                        <span x-show="tingkat !== 'kota' && tingkat !== 'umum'"
                            class="bg-blue-100/95 text-blue-600 text-[10px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm shadow-sm border border-blue-200">PREMIUM</span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-lg font-black text-slate-900 leading-snug mb-4 line-clamp-2"
                        x-text="judul || 'Nama Lomba Akan Tampil Di Sini'"></h3>

                    <div class="space-y-2.5 mb-5">
                        <div class="flex items-start gap-3 text-sm text-slate-600">
                            <svg class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span
                                x-text="tanggal ? new Date(tanggal).toLocaleDateString('id-ID', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'}) : 'Pilih Tanggal Pelaksanaan'"></span>
                        </div>
                        <div class="flex items-start gap-3 text-sm text-slate-600">
                            <svg class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Pendaftaran: Segera Dibuka</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6 min-h-[30px]">
                        <template x-for="ben in benefits">
                            <span
                                class="px-3 py-1.5 bg-[#F8FAFC] text-blue-600 text-[11px] font-bold rounded-lg border border-slate-200 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span x-text="ben"></span>
                            </span>
                        </template>
                    </div>

                    <div class="flex items-center justify-between mb-5 mt-auto">
                        <div>
                            <span class="text-xl font-black text-slate-900"
                                x-text="
                                bidangs.length > 0 
                                ? (Math.min(...bidangs.map(b => b.harga || 0)) == 0 ? 'FREE' : 'Rp ' + Math.min(...bidangs.map(b => b.harga || 0)).toLocaleString('id-ID'))
                                : 'Rp 0'
                            "></span>
                        </div>
                        <div
                            class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-indigo-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            0 Peserta
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2 cursor-pointer transition-colors"
                            :class="gdrive ? 'text-slate-700 hover:text-blue-600' : 'text-slate-300'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="text-sm font-bold">Panduan</span>
                        </div>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all active:scale-95">
                            Daftar
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function lombaBuilder() {
            return {
                judul: '',
                tingkat: 'umum',
                tanggal: '',
                gdrive: '',
                posterPreview: null,
                benefits: [],

                bidangs: [{
                    id: Date.now(),
                    nama: '',
                    harga: '',
                    wa: ''
                }],

                addBidang() {
                    this.bidangs.push({
                        id: Date.now(),
                        nama: '',
                        harga: '',
                        wa: ''
                    });
                },

                removeBidang(idToRemove) {
                    if (this.bidangs.length > 1) {
                        this.bidangs = this.bidangs.filter(b => b.id !== idToRemove);
                    }
                },

                handlePoster(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.posterPreview = URL.createObjectURL(file);
                    }
                }
            }
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Verifikasi - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    </style>
</head>

<body class="min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-white rounded-[24px] p-6 ring-1 ring-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] sticky top-32">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 px-2">Menu Navigasi</h3>
                
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('penyelenggara.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60">🏠</span> Ringkasan Utama
                    </a>
                    
                    <a href="{{ route('penyelenggara.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60">📊</span> Analytics & Insights
                    </a>

                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-bold rounded-xl transition-all ring-1 ring-blue-100/50">
                        <span class="text-xl">⚙️</span> Profil & Verifikasi
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil Penyelenggara</h1>
                <p class="text-slate-500 mt-2 font-medium text-sm">Lengkapi data instansi dan unggah dokumen legalitas untuk verifikasi akun.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl border border-emerald-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[24px] p-8 ring-1 ring-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)]">
                
                <div class="mb-8 p-6 rounded-2xl border border-slate-100 bg-slate-50 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-800 mb-1">Status Keamanan Akun</h4>
                        <p class="text-xs text-slate-500 font-medium">Akun terverifikasi mendapatkan akses penuh untuk mempublikasikan lomba.</p>
                    </div>
                    <div>
                        @if($user->isVerified())
                            <span class="px-4 py-2 bg-emerald-100 text-emerald-700 font-black rounded-full text-xs flex items-center gap-2">✅ TERVERIFIKASI</span>
                        @elseif($user->isPendingVerification())
                            <span class="px-4 py-2 bg-amber-100 text-amber-700 font-black rounded-full text-xs flex items-center gap-2">⏳ MENUNGGU TINJAUAN ADMIN</span>
                        @elseif($user->isRejected())
                            <span class="px-4 py-2 bg-red-100 text-red-700 font-black rounded-full text-xs flex items-center gap-2">❌ DITOLAK (Periksa Kembali)</span>
                        @else
                            <span class="px-4 py-2 bg-slate-200 text-slate-600 font-black rounded-full text-xs flex items-center gap-2">⚠️ BELUM TERVERIFIKASI</span>
                        @endif
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Penanggung Jawab</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none font-medium text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">No. WhatsApp Aktif</label>
                            <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none font-medium text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Instansi / Sekolah</label>
                            <input type="text" name="asal_instansi" value="{{ old('asal_instansi', $profile->asal_instansi) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none font-medium text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kategori Instansi</label>
                            <select name="tingkat_pendidikan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none font-medium text-slate-800">
                                <option value="" disabled {{ !$profile->tingkat_pendidikan ? 'selected' : '' }}>Pilih Kategori...</option>
                                @foreach(['Universitas', 'Sekolah', 'Komunitas/Organisasi', 'Perusahaan', 'Instansi Pemerintah'] as $level)
                                    <option value="{{ $level }}" {{ old('tingkat_pendidikan', $profile->tingkat_pendidikan) === $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Unggah Identitas Verifikasi (KTP / Surat Organisasi)</label>
                        <p class="text-xs text-slate-400 mb-4 font-medium">Format didukung: JPG, PNG, PDF. Maks 2MB. Mengunggah ulang akan memicu peninjauan ulang oleh Admin.</p>
                        
                        <input type="file" name="dokumen_verifikasi" accept=".jpg,.jpeg,.png,.pdf"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                        
                        @error('dokumen_verifikasi')
                            <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100 mt-8">
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.23)] transition-all">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

</body>
</html>
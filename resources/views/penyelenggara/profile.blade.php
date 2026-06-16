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
                        <svg class="w-5 h-5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                        Ringkasan Utama
                    </a>
                    
                    <a href="{{ route('penyelenggara.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-slate-700 font-bold rounded-xl transition-all">
                        <svg class="w-5 h-5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                        Analytics & Insights
                    </a>

                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-bold rounded-xl transition-all ring-1 ring-blue-100/50">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                        Profil & Verifikasi
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
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl border border-emerald-100 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
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
                            <span class="px-4 py-2 bg-emerald-100 text-emerald-700 font-black rounded-full text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> TERVERIFIKASI
                            </span>
                        @elseif($user->isPendingVerification())
                            <span class="px-4 py-2 bg-amber-100 text-amber-700 font-black rounded-full text-xs flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin-slow" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg> MENUNGGU TINJAUAN ADMIN
                            </span>
                        @elseif($user->isRejected())
                            <span class="px-4 py-2 bg-red-100 text-red-700 font-black rounded-full text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg> DITOLAK (Periksa Kembali)
                            </span>
                        @else
                            <span class="px-4 py-2 bg-slate-200 text-slate-600 font-black rounded-full text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> BELUM TERVERIFIKASI
                            </span>
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
                        <div class="mb-6">
                            <h3 class="text-sm font-extrabold text-slate-800">Dokumen Verifikasi Akun</h3>
                            <p class="text-xs text-slate-500 font-medium mt-1">Unggah dokumen secara terpisah. Mengunggah ulang akan memicu peninjauan ulang oleh Admin.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">1. Identitas Pribadi (KTP/KTM)</label>
                                <p class="text-[11px] text-slate-400 mb-4 font-medium">Sebagai bukti penanggung jawab acara. (Maks 2MB)</p>
                                
                                <div class="relative">
                                    <input type="file" name="dokumen_ktp" id="dokumen_ktp" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                                        onchange="document.getElementById('file-name-ktp').textContent = this.files.length > 0 ? this.files[0].name : 'Pilih file KTP...'">
                                    
                                    <label for="dokumen_ktp" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 hover:ring-1 hover:ring-blue-100 transition-all group">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <span id="file-name-ktp" class="text-xs font-medium text-slate-500 truncate">Pilih file KTP...</span>
                                        </div>
                                        <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg shrink-0 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">Browse</span>
                                    </label>
                                </div>
                                
                                @error('dokumen_ktp')
                                    <span class="text-red-500 text-[10px] font-bold mt-2 block">{{ $message }}</span>
                                @enderror

                                @if($user->dokumen_ktp && !$user->isRejected())
                                    <p class="mt-3 text-[10px] font-bold text-emerald-600 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Dokumen KTP sudah terunggah
                                    </p>
                                @endif
                            </div>

                            <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">2. Surat Organisasi</label>
                                <p class="text-[11px] text-slate-400 mb-4 font-medium">Bukti bahwa Anda mewakili instansi terkait. (Maks 2MB)</p>
                                
                                <div class="relative">
                                    <input type="file" name="dokumen_legalitas" id="dokumen_legalitas" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                                        onchange="document.getElementById('file-name-legalitas').textContent = this.files.length > 0 ? this.files[0].name : 'Pilih surat legalitas...'">
                                    
                                    <label for="dokumen_legalitas" class="flex items-center justify-between w-full px-4 py-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 hover:ring-1 hover:ring-blue-100 transition-all group">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <span id="file-name-legalitas" class="text-xs font-medium text-slate-500 truncate">Pilih surat legalitas...</span>
                                        </div>
                                        <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg shrink-0 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">Browse</span>
                                    </label>
                                </div>
                                
                                @error('dokumen_legalitas')
                                    <span class="text-red-500 text-[10px] font-bold mt-2 block">{{ $message }}</span>
                                @enderror

                                @if($user->dokumen_legalitas && !$user->isRejected())
                                    <p class="mt-3 text-[10px] font-bold text-emerald-600 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Surat Legalitas sudah terunggah
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100 mt-8">
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] hover:shadow-[0_6px_20px_rgba(37,99,235,0.23)] transition-all flex items-center gap-2">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

</body>
</html>
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Profil Saya - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">
    <x-nav />

    <main class="pt-32 pb-20 px-6 max-w-4xl mx-auto" x-data="{ editMode: false }">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 text-green-600 font-bold px-5 py-4 rounded-2xl border border-green-200">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @if(!auth()->user()->isProfileComplete())
            <div class="mb-6 bg-amber-50 text-amber-700 font-bold px-5 py-4 rounded-2xl border border-amber-200 flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <p>Profil kamu belum lengkap! Lengkapi <b>Nama Lengkap, No WA, Tingkat Pendidikan, dan Asal Instansi</b> untuk bisa mendaftar lomba.</p>
            </div>
        @endif

        <div class="bg-white rounded-[32px] p-8 md:p-10 shadow-sm border border-slate-200 relative overflow-hidden">
            <div class="flex justify-between items-end mb-8 border-b border-slate-100 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Diri Peserta</h1>
                    <p class="text-slate-500 mt-2 font-medium">Informasi ini akan digunakan untuk e-sertifikat dan pengiriman hadiah.</p>
                </div>
                <button @click="editMode = !editMode" 
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors text-sm flex items-center gap-2">
                    <span x-text="editMode ? 'Batal Edit' : 'Edit Profil'"></span>
                </button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Username / Email</label>
                        <input type="text" value="{{ $user->email }}" disabled class="w-full bg-slate-100 text-slate-500 font-bold rounded-xl p-3 border-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" :disabled="!editMode" required
                            :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' : 'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                            class="w-full font-bold rounded-xl p-3 border transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor WhatsApp *</label>
                        <input type="text" name="no_wa" value="{{ old('no_wa', $profile->no_wa) }}" :disabled="!editMode" required placeholder="08123456789"
                            :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' : 'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                            class="w-full font-bold rounded-xl p-3 border transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Asal Sekolah / Instansi *</label>
                        <input type="text" name="asal_instansi" value="{{ old('asal_instansi', $profile->asal_instansi) }}" :disabled="!editMode" required placeholder="Cth: SMAN 1 Surabaya"
                            :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' : 'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                            class="w-full font-bold rounded-xl p-3 border transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tingkat Pendidikan *</label>
                        <select name="tingkat_pendidikan" :disabled="!editMode" required
                            :class="!editMode ? 'bg-slate-50 border-slate-100 text-slate-600' : 'bg-white border-blue-200 focus:ring-2 focus:ring-blue-100 text-slate-900'"
                            class="w-full font-bold rounded-xl p-3 border transition-all">
                            <option value="">Pilih Tingkat</option>
                            <option value="SD" {{ $profile->tingkat_pendidikan == 'SD' ? 'selected' : '' }}>Sekolah Dasar (SD)</option>
                            <option value="SMP" {{ $profile->tingkat_pendidikan == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                            <option value="SMA" {{ $profile->tingkat_pendidikan == 'SMA' ? 'selected' : '' }}>SMA / SMK / Sederajat</option>
                            <option value="Mahasiswa" {{ $profile->tingkat_pendidikan == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Umum" {{ $profile->tingkat_pendidikan == 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>
                    
                    <div x-show="editMode" x-collapse>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Upload Kartu Pelajar (Opsional)</label>
                        <input type="file" name="foto_kartu_pelajar" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 p-1 border border-slate-200 rounded-xl">
                    </div>
                </div>

                <div x-show="editMode" x-collapse class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg shadow-blue-200 transition-all active:scale-95">
                        Simpan Perubahan Data
                    </button>
                </div>
            </form>
            
        </div>
    </main>
</body>
</html>
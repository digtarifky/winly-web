<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Panitia - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
    </style>
</head>

<body class="min-h-screen pb-20">

    <x-nav />

    <div class="pt-28 px-4 md:px-8 w-full max-w-[90rem] mx-auto flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-[280px] shrink-0">
            <div class="bg-slate-900 rounded-[24px] p-6 shadow-xl sticky top-32">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 px-2">Admin Control</h3>
                
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60"></span> Dashboard Utama
                    </a>
                    
                    <a href="{{ route('admin.verifikasi') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl transition-all shadow-md shadow-blue-900/20">
                        <span class="text-xl"></span> Verifikasi Panitia
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white font-bold rounded-xl transition-all">
                        <span class="text-xl opacity-60"></span> Laporan Keuangan
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi Akun Penyelenggara</h1>
                <p class="text-slate-500 mt-2 font-medium text-sm">Tinjau dokumen legalitas dan berikan hak akses penerbitan lomba kepada panitia.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl border border-emerald-100 flex items-center gap-3">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Menunggu Tinjauan</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Akun yang baru saja mengunggah dokumen.</p>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-black">{{ $panitiaPending->count() }} Antrean</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                <th class="p-5">Nama & Instansi</th>
                                <th class="p-5">Kontak</th>
                                <th class="p-5">Dokumen Bukti</th>
                                <th class="p-5 text-right">Aksi Keputusan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-slate-600 divide-y divide-slate-50">
                            @forelse($panitiaPending as $panitia)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800">{{ $panitia->profile->nama_lengkap ?? 'Belum isi profil' }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $panitia->profile->asal_instansi ?? '-' }}</p>
                                    </td>
                                    <td class="p-5">
                                        <p class="text-slate-700">{{ $panitia->email }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $panitia->profile->no_wa ?? '-' }}</p>
                                    </td>
                                    <td class="p-5">
                                        <div class="flex flex-col gap-2 items-start">
                                            @if($panitia->dokumen_ktp)
                                                <button type="button" onclick="openModal('{{ asset('storage/' . $panitia->dokumen_ktp) }}')" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                    Lihat KTP
                                                </button>
                                            @else
                                                <span class="text-xs text-slate-400">KTP Kosong</span>
                                            @endif
                                            
                                            @if($panitia->dokumen_legalitas)
                                                <button type="button" onclick="openModal('{{ asset('storage/' . $panitia->dokumen_legalitas) }}')" class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                    Lihat Legalitas
                                                </button>
                                            @else
                                                <span class="text-xs text-slate-400">Surat Kosong</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.verifikasi.proses', $panitia->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" onclick="return confirm('Yakin ingin menolak akun ini?')" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white font-bold rounded-lg transition-colors text-xs">
                                                    Tolak
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.verifikasi.proses', $panitia->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" onclick="return confirm('Yakin ingin memverifikasi akun ini? Mereka akan bisa membuat lomba.')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg transition-colors text-xs shadow-sm shadow-emerald-500/30">
                                                    Setujui
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400">
                                        Tidak ada panitia yang menunggu verifikasi saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-[24px] ring-1 ring-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800">Riwayat Verifikasi</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1">Daftar akun yang sudah Anda setujui atau tolak.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-[11px] font-extrabold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                <th class="p-5">Nama & Instansi</th>
                                <th class="p-5">Kontak</th>
                                <th class="p-5">Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-slate-600 divide-y divide-slate-50">
                            @forelse($panitiaRiwayat as $riwayat)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800">{{ $riwayat->profile->nama_lengkap ?? 'Belum isi profil' }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $riwayat->profile->asal_instansi ?? '-' }}</p>
                                    </td>
                                    <td class="p-5">
                                        <p class="text-slate-700">{{ $riwayat->email }}</p>
                                    </td>
                                    <td class="p-5">
                                        @if($riwayat->status_verifikasi === 'verified')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black inline-flex items-center gap-1">
                                                ✅ Disetujui
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-black inline-flex items-center gap-1">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-slate-400">
                                        Belum ada riwayat verifikasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <div id="documentModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm items-center justify-center p-4 opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            
            <div class="flex justify-between items-center p-5 border-b border-slate-100 bg-white">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span class="text-xl"></span> Pratinjau Dokumen
                </h3>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-auto p-6 bg-slate-50/50 flex justify-center items-center relative">
                <div id="modalLoader" class="absolute inset-0 flex items-center justify-center bg-slate-50 z-10">
                    <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                </div>

                <img id="modalImage" src="" alt="Dokumen Verifikasi" class="max-w-full max-h-[70vh] rounded-xl shadow-sm hidden" onload="document.getElementById('modalLoader').classList.add('hidden')">
                
                <iframe id="modalPdf" src="" class="w-full h-[70vh] rounded-xl border border-slate-200 hidden" onload="document.getElementById('modalLoader').classList.add('hidden')"></iframe>
            </div>

        </div>
    </div>

    <script>
        function openModal(url) {
            const modal = document.getElementById('documentModal');
            const img = document.getElementById('modalImage');
            const pdf = document.getElementById('modalPdf');
            const content = document.getElementById('modalContent');
            const loader = document.getElementById('modalLoader');

            // Tampilkan loader setiap kali buka
            loader.classList.remove('hidden');

            // Cek apakah file berupa PDF atau Gambar
            if (url.toLowerCase().endsWith('.pdf')) {
                img.classList.add('hidden');
                pdf.classList.remove('hidden');
                pdf.src = url;
            } else {
                pdf.classList.add('hidden');
                img.classList.remove('hidden');
                img.src = url;
            }

            // Munculkan Modal
            modal.classList.remove('hidden');
            
            // Beri jeda 10ms agar animasi transisi Tailwind berjalan
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('documentModal');
            const content = document.getElementById('modalContent');
            const pdf = document.getElementById('modalPdf');
            
            // Animasi menghilang
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            
            // Setelah animasi selesai (300ms), sembunyikan sepenuhnya
            setTimeout(() => {
                modal.classList.add('hidden');
                pdf.src = ''; // Kosongkan iframe agar proses PDF terhenti
                document.getElementById('modalImage').src = '';
            }, 300);
        }

        // Tutup modal jika meng-klik area gelap di luar kotak putih
        document.getElementById('documentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>
</html>
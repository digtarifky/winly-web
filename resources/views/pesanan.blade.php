<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pesanan Saya - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <x-nav />

    <main class="pt-32 pb-20 px-4 md:px-8 max-w-4xl mx-auto">
        
        <div class="bg-[#F4F9FF] rounded-[24px] p-8 border border-blue-100 mb-6 shadow-sm">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Pesanan Saya</h1>
            <p class="text-slate-500 font-medium">Kelola dan pantau status pesanan lomba Anda</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl px-5 py-3 mb-6 shadow-sm text-sm text-slate-600">
            Menampilkan <span class="font-bold text-slate-900">{{ $pesanan->count() }}</span> pesanan
        </div>

        <div class="space-y-6">
            @forelse($pesanan as $item)
                @php
                    // Ambil harga dari relasi field
                    $harga = $item->field->harga ?? 0;
                @endphp

                <div class="bg-white rounded-[24px] border border-slate-200 p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-slate-100 pb-4 mb-4 gap-4">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-lg">#INV-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</h3>
                            <div class="flex items-center gap-3 text-sm text-slate-500 mt-1">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $item->created_at->translatedFormat('d F Y') }}</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg> 1 item</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2">
                            <!-- LOGIKA STATUS BADGE YANG DIPERLENGKAP -->
                            @if($item->status_pembayaran === 'sukses' || $item->status_pembayaran === 'lolos' || $item->status_pembayaran === 'lunas')
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Verifikasi Berhasil
                                </span>
                            @elseif($item->status_pembayaran === 'gagal')
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak / Gagal
                                </span>
                            @else
                                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Menunggu Verifikasi
                                </span>
                            @endif
                            <!-- HARGA -->
                            <span class="text-2xl font-black text-blue-600">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-slate-800 font-medium uppercase tracking-wide text-sm">
                            {{ $item->field->competition->judul_lomba ?? 'Kompetisi Winly' }} - {{ $item->field->nama_bidang ?? 'Umum' }}
                        </p>
                        <p class="text-slate-500 text-sm mt-1">x1</p>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mb-6 space-y-2 text-sm">
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Subtotal:</span>
                            <span class="font-medium">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-900 font-extrabold text-base">
                            <span>Total:</span>
                            <span>Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center pt-4 border-t border-slate-100 gap-4">
                        <div class="text-xs text-slate-500 font-medium">
                            @if($item->status_pembayaran === 'menunggu')
                                Kadaluarsa: {{ $item->created_at->addDays(1)->translatedFormat('d M Y, H:i') }}
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 w-full md:w-auto">
                            @if($item->status_pembayaran === 'menunggu' && $harga > 0)
                                <a href="{{ route('peserta.payment', $item->id) }}" 
                                   class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-blue-200 w-full md:w-auto text-center">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if($item->status_pembayaran === 'sukses' || $item->status_pembayaran === 'lolos' || $item->status_pembayaran === 'lunas')
                                <a href="{{ $item->field->link_wa ?? '#' }}" target="_blank" 
                                   class="px-6 py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-green-200 w-full md:w-auto text-center flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    Gabung Grup WA
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- ALERT DITOLAK (Hanya muncul jika statusnya gagal) -->
                    @if($item->status_pembayaran === 'gagal')
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4 flex flex-col md:flex-row md:items-start gap-4 shadow-sm animate-pulse">
                            <div class="bg-red-100 text-red-600 p-2 rounded-full flex-shrink-0 w-max">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-sm font-black text-red-800 mb-1">Verifikasi Ditolak!</h4>
                                <p class="text-xs text-red-600 font-medium mb-3">
                                    Mohon maaf, pendaftaran/pembayaranmu tidak lolos verifikasi panitia. Silakan cek kembali persyaratan dan ajukan daftar ulang.
                                </p>
                                <a href="{{ route('competitions') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Ajukan Daftar Ulang
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            @empty
                <div class="bg-white rounded-[24px] border border-slate-200 p-12 text-center shadow-sm">
                    <span class="text-4xl block mb-4">🛒</span>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Belum ada pesanan</h3>
                    <p class="text-slate-500">Anda belum mendaftar di kompetisi apapun. Yuk, cari lomba yang menarik!</p>
                </div>
            @endforelse
        </div>

    </main>

</body>
</html>
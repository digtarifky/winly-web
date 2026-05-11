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
                            @if($item->status_pembayaran === 'sukses')
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Pembayaran Sukses
                                </span>
                            @else
                                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Menunggu Pembayaran
                                </span>
                            @endif
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
                            @if($item->status_pembayaran !== 'sukses')
                                Kadaluarsa: {{ $item->created_at->addDays(1)->translatedFormat('d M Y, H:i') }}
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            @if($item->status_pembayaran !== 'sukses')
                                <a href="{{ route('peserta.payment', $item->id) }}" 
                                   class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-blue-200 w-full md:w-auto text-center">
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
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
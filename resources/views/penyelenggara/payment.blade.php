<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Publikasi - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-xl border border-slate-100 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>

        <h1 class="text-2xl font-extrabold text-slate-900 mb-2">Selesaikan Pembayaran</h1>
        <p class="text-sm text-slate-500 mb-6">Untuk menerbitkan lomba tingkat <span class="font-bold text-slate-800 capitalize">{{ $lomba->tingkat_lomba }}</span>, silakan lakukan pembayaran biaya publikasi.</p>

        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-6">
            <span class="block text-xs font-bold text-blue-600 uppercase tracking-widest mb-1">Total Tagihan</span>
            <span class="text-3xl font-black text-blue-700">Rp {{ number_format($harga, 0, ',', '.') }}</span>
        </div>

        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-4 mb-8 mx-auto w-48 h-48 flex items-center justify-center bg-slate-50">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PembayaranWinly&color=0f172a" alt="QRIS" class="w-full h-full object-contain mix-blend-multiply">
        </div>

        <div class="space-y-3">
            <form action="{{ route('penyelenggara.confirmPayment', $lomba->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-full shadow-lg shadow-blue-200 transition-transform active:scale-95">
                    Konfirmasi Sudah Bayar
                </button>
            </form>
            
            <a href="{{ route('penyelenggara.dashboard') }}" class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3.5 rounded-full transition-colors">
                Batal & Bayar Nanti
            </a>
        </div>
    </div>

</body>
</html>
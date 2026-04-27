<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Registrasi - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="bg-blue-600 p-6 text-center">
            <h1 class="text-xl font-black text-white tracking-tighter">Pembayaran Registrasi</h1>
            <p class="text-blue-100 text-sm mt-1">Selesaikan pembayaran untuk bergabung.</p>
        </div>

        <div class="p-8 text-center">
            <h2 class="text-lg font-bold text-slate-800 mb-1">{{ $registration->field->competition->judul_lomba ?? 'Kompetisi' }}</h2>
            <p class="text-sm font-medium text-slate-500 mb-6 border-b border-slate-100 pb-4">
                Bidang: <span class="text-indigo-600 font-bold">{{ $registration->field->nama_bidang ?? 'Bidang Lomba' }}</span>
            </p>

            <div class="bg-slate-100 p-4 rounded-2xl inline-block mb-4 border-2 border-dashed border-slate-300">
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS" class="w-48 h-48 opacity-80 mix-blend-multiply">
            </div>
            
            <p class="text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Total Tagihan</p>
            <p class="text-3xl font-black text-slate-900 mb-8">
                Rp {{ number_format($registration->field->harga, 0, ',', '.') }}
            </p>

            <form action="{{ route('peserta.payment.confirm', $registration->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition-all active:scale-95">
                    Konfirmasi Sudah Bayar
                </button>
            </form>
            
            <a href="{{ route('competitions') }}" class="block mt-4 text-sm font-bold text-slate-400 hover:text-slate-600">
                Batal & Bayar Nanti
            </a>
        </div>
    </div>

</body>
</html>
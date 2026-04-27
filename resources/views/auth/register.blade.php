<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="bg-blue-600 p-8 text-center">
            <h1 class="text-3xl font-black text-white tracking-tighter mb-2">WINLY</h1>
            <p class="text-blue-100 text-sm">Mulai perjalanan prestasimu dari sini.</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold">
                    <ul class="list-disc ml-5 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Mendaftar Sebagai *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="peserta" class="peer sr-only" checked>
                            <div class="text-center px-4 py-3 border border-slate-200 rounded-xl text-sm font-bold text-slate-500 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-600 transition-all">
                                🎓 Peserta
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="penyelenggara" class="peer sr-only">
                            <div class="text-center px-4 py-3 border border-slate-200 rounded-xl text-sm font-bold text-slate-500 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-600 transition-all">
                                🏢 Penyelenggara
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap / Instansi</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        class="w-full text-sm border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full text-sm border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required 
                        class="w-full text-sm border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full text-sm border border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 mt-2">
                    Buat Akun Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6 font-medium">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
            </p>

            <a href="{{ url('/') }}" class="absolute top-6 right-6 md:top-8 md:right-8 flex items-center gap-2 px-10 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 hover:text-slate-900 hover:bg-red-100 transition-all shadow-md group">
        <span class="text-base font-bold">Keluar</span>
    </a>
        </div>
    </div>

</body>
</html>
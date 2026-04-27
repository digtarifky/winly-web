<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Winly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-50 via-indigo-50/30 to-white relative">

    <a href="{{ url('/') }}" class="absolute top-6 right-6 md:top-8 md:right-8 flex items-center gap-2 px-10 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 hover:text-slate-900 hover:bg-red-100 transition-all shadow-md group">
        <span class="text-base font-bold">Keluar</span>
    </a>

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Halo, Selamat Datang 👋
        </h1>
    </div>

    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Masuk</h2>
            <p class="text-slate-500 text-sm font-medium leading-relaxed px-4">
                Masukkan email dan password Anda untuk masuk ke akun
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="flex items-center gap-2 text-sm font-semibold text-slate-800 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                    </svg>
                    Email
                </label>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </div>
                    
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-400" 
                        placeholder="nama@email.com" 
                        required 
                        autofocus
                    />
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Password
                    </label>
                </div>
                
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-400 tracking-widest" 
                        placeholder="••••••••" 
                        required
                    />
                    
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-600 hover:text-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-base font-bold rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95"
                >
                    Masuk
                </button>
            </div>

            <p class="text-center text-sm text-slate-500 mt-6 font-medium">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
            </p>

        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a10.07 10.07 0 0 1 2.18-3.18"></path><path d="M9.88 9.88A3 3 0 1 0 14.12 14.12"></path><path d="M2.1 2.1l19.8 19.8"></path><path d="M22 12s-3-7-10-7a10.07 10.07 0 0 0-4.18.94"></path>';
            } else {
                eyeIcon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    </script>

</body>
</html>
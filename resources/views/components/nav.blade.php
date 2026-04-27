@php
    $competitionsUrl = route('competitions'); // Default URL (Katalog Umum) untuk Guest/belum login

    if (auth()->check()) {
        if (auth()->user()->role === 'peserta') {
            $competitionsUrl = route('competitions'); 
        } elseif (auth()->user()->role === 'penyelenggara') {
            // Sementara diarahkan ke dashboard penyelenggara
            $competitionsUrl = route('penyelenggara.dashboard'); 
        }
    }
@endphp

<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100 shadow-sm transition-all duration-300">
    <div class="w-full px-4 md:px-8 lg:px-16 py-4 md:py-5 flex items-center justify-between">

        <div class="flex items-center gap-6 xl:gap-12">

            <button id="mobile-menu-btn" class="lg:hidden text-slate-600 hover:text-blue-600 focus:outline-none p-2 bg-slate-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 5h-2V3a1 1 0 00-1-1H8a1 1 0 00-1 1v2H5C3.346 5 2 6.346 2 8v1c0 2.456 1.705 4.512 4.021 4.928C6.671 15.659 8.24 17 10 17v2H8a1 1 0 000 2h8a1 1 0 000-2h-2v-2c1.76 0 3.329-1.341 3.979-3.072C20.295 13.512 22 11.456 22 9V8c0-1.654-1.346-3-3-3zM4 9V7h3v5.856C5.268 12.185 4 10.74 4 9zm10 6c-1.654 0-3-1.346-3-3V3h6v9c0 1.654-1.346 3-3 3zm6-6c0 1.74-1.268 3.185-3 3.856V7h3v2z" />
                </svg>
                <span class="text-3xl font-black text-blue-700 tracking-tighter">WINLY</span>
            </a>

            <div class="hidden lg:flex items-center bg-[#F4F7FE] rounded-full px-5 py-3 w-[250px] xl:w-[350px] border border-transparent focus-within:border-blue-200 focus-within:bg-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search competitions ..." class="bg-transparent border-none focus:outline-none focus:ring-0 text-sm w-full ml-3 text-slate-700 placeholder-slate-400">
            </div>

            <div class="hidden lg:flex items-center space-x-2 absolute left-1/2 transform -translate-x-1/2">
                
                <a href="{{ route('home') }}"
                    class="{{ request()->is('/') ? 'bg-blue-600 text-white px-6 shadow-lg shadow-blue-500/20' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50 px-5' }} py-3 rounded-full font-bold text-base transition-all duration-300">
                    Dashboard
                </a>
                
                <a href="{{ $competitionsUrl }}"
                    class="{{ request()->is('competitions*') ? 'bg-blue-600 text-white px-6 shadow-lg shadow-blue-500/20' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50 px-5' }} py-3 rounded-full font-bold text-base transition-all duration-300">
                    Competitions
                </a>
                
                <a href="{{ route('news') }}"
                    class="{{ request()->is('news*') ? 'bg-blue-600 text-white px-6 shadow-lg shadow-blue-500/20' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50 px-5' }} py-3 rounded-full font-bold text-base transition-all duration-300">
                    News
                </a>
            </div>

        </div>

        <div class="flex items-center space-x-2 md:space-x-4">
            @guest
                <a href="{{ route('login') }}" class="hidden md:block px-6 py-3 text-slate-700 hover:text-blue-600 transition font-bold text-base">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex items-center gap-2 px-6 md:px-8 py-2 md:py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition font-bold text-sm md:text-base shadow-xl shadow-blue-500/30">
                    Daftar
                </a>
            @endguest

            @auth
                <div class="flex items-center space-x-2 md:space-x-4">
                    @php
                        $dashboardUrl = auth()->user()->role === 'peserta' ? route('home') : route('penyelenggara.dashboard');
                    @endphp
                    <a href="{{ $dashboardUrl }}" class="flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition font-bold text-xs md:text-base whitespace-nowrap">
                        Halo, {{ explode(' ', auth()->user()->name)[0] }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="px-4 md:px-6 py-2 md:py-3 bg-red-50 text-red-600 rounded-full hover:bg-red-500 hover:text-white transition font-bold text-xs md:text-base border border-red-100">
                            Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <div id="mobile-menu-panel" class="hidden lg:hidden bg-white border-t border-slate-100 shadow-xl absolute w-full left-0 top-full">
        <div class="flex flex-col px-6 py-5 space-y-2">
            
            <div class="mb-4 flex items-center bg-[#F4F7FE] rounded-xl px-4 py-3 border border-transparent focus-within:border-blue-200 transition-all w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search competitions ..." class="bg-transparent border-none focus:outline-none focus:ring-0 text-sm w-full ml-3 text-slate-700 placeholder-slate-400">
            </div>

            <a href="{{ route('home') }}"
                class="{{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50' }} px-4 py-3 rounded-xl font-bold text-[15px] transition-colors block">
                Dashboard
            </a>
            
            <a href="{{ $competitionsUrl }}"
                class="{{ request()->is('competitions*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50' }} px-4 py-3 rounded-xl font-bold text-[15px] transition-colors block">
                Competitions
            </a>
            
            <a href="{{ route('news') }}"
                class="{{ request()->is('news*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:text-blue-600 hover:bg-blue-50' }} px-4 py-3 rounded-xl font-bold text-[15px] transition-colors block">
                News
            </a>

            @guest
                <div class="pt-4 mt-2 border-t border-slate-100 md:hidden">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 bg-slate-50 text-slate-700 rounded-xl font-bold text-[15px]">Masuk</a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const panel = document.getElementById('mobile-menu-panel');

        btn.addEventListener('click', function() {
            panel.classList.toggle('hidden');
        });
    });
</script>
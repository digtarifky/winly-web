<aside class="w-full lg:w-64 flex-shrink-0 bg-white rounded-[24px] p-6 border border-slate-100 shadow-xl shadow-slate-200/40 lg:sticky lg:top-32 z-10">
    <div class="flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
        </svg>
        <h3 class="text-lg font-black text-slate-900">Filter Lomba</h3>
    </div>

    <div class="flex lg:flex-col gap-6 overflow-x-auto custom-scrollbar pb-4 lg:pb-0 snap-x">
        
        <div class="min-w-[180px] lg:min-w-0 snap-start">
            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-3">Tingkat Pendidikan</h4>
            <div class="flex flex-col gap-1.5">
                <button data-group="tingkat" data-filter="semua" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold bg-blue-50 text-blue-700 transition-colors">Semua Tingkat</button>
                <button data-group="tingkat" data-filter="sd" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Sekolah Dasar (SD)</button>
                <button data-group="tingkat" data-filter="smp" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">SMP / Sederajat</button>
                <button data-group="tingkat" data-filter="sma" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">SMA / SMK</button>
                <button data-group="tingkat" data-filter="mahasiswa" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Mahasiswa / Umum</button>
            </div>
        </div>

        <div class="min-w-[180px] lg:min-w-0 snap-start">
            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-3">Kategori Lomba</h4>
            <div class="flex flex-col gap-1.5">
                <button data-group="kategori" data-filter="semua" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold bg-blue-50 text-blue-700 transition-colors">Semua Kategori</button>
                <button data-group="kategori" data-filter="akademik" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Akademik</button>
                <button data-group="kategori" data-filter="teknologi_it" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Teknologi & IT</button>
                <button data-group="kategori" data-filter="ekonomi_bisnis" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Ekonomi & Bisnis</button>
                <button data-group="kategori" data-filter="karya_tulis" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Karya Tulis & Riset</button>
                <button data-group="kategori" data-filter="seni_desain" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Seni & Desain</button>
                <button data-group="kategori" data-filter="kesehatan" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Kesehatan & Medis</button>
                <button data-group="kategori" data-filter="soshum_hukum" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">Soshum & Hukum</button>
            </div>
        </div>

        <div class="min-w-[180px] lg:min-w-0 snap-start">
            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-3">Biaya Masuk</h4>
            <div class="flex flex-col gap-1.5">
                <button data-group="biaya" data-filter="semua" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold bg-blue-50 text-blue-700 transition-colors">Semua Biaya</button>
                <button data-group="biaya" data-filter="gratis" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors flex items-center justify-between">
                    Gratis (Free) <span class="w-2 h-2 rounded-full bg-green-500"></span>
                </button>
                <button data-group="biaya" data-filter="premium" class="filter-btn w-full text-left px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors flex items-center justify-between">
                    Premium <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </button>
            </div>
        </div>

    </div>
</aside>
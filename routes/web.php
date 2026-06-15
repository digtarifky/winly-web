<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// ==========================================
// AREA PUBLIK (Bisa diakses siapa saja)
// ==========================================


Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/competitions', [PublicController::class, 'competitions'])->name('competitions');

// ==========================================
// AREA GUEST (Hanya untuk yang BELUM login)
// ==========================================
Route::middleware('guest')->group(function () {
    // Rute Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Rute Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});


// ==========================================
// AREA AUTH (Harus Login - Peserta)
// ==========================================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Dashboard Peserta (Halaman SETELAH LOGIN)
    Route::get('/home', function () {
        $hariIni = \Carbon\Carbon::now()->startOfDay();
        $batasH7 = $hariIni->copy()->addDays(7)->endOfDay();

        // 1. Saring Lomba 
        $queryLombaBuka = \App\Models\Competition::with('fields')
            ->withCount('registrations')
            ->where('status', 'aktif')
            ->where('is_pendaftaran_tutup', false)
            ->where(function($query) use ($hariIni) {
                $query->whereNull('tgl_tutup_pendaftaran')
                      ->orWhere('tgl_tutup_pendaftaran', '>=', $hariIni);
            })
            ->latest()
            ->get();

        $semuaLombaAman = $queryLombaBuka->filter(function ($lomba) {
            $kuota = $lomba->kuota_peserta ?? 100;
            return $lomba->registrations_count < $kuota;
        });

        $upcomingDeadlines = $semuaLombaAman->filter(function ($lomba) use ($hariIni, $batasH7) {
            if (!$lomba->tgl_tutup_pendaftaran) return false;
            $tglTutup = \Carbon\Carbon::parse($lomba->tgl_tutup_pendaftaran)->endOfDay();
            return $tglTutup->between($hariIni, $batasH7);
        })->sortBy('tgl_tutup_pendaftaran')->take(3);

        $latestCompetitions = $semuaLombaAman->take(3);

        // KODE TAMBAHAN KHUSUS SETELAH LOGIN (Mengambil data pendaftaran user)
        $registrations = \App\Models\Registration::where('user_id', Auth::id())
            ->with('field.competition')
            ->latest()
            ->get();

        // Kirim semua variabel ke view
        return view('home', compact('latestCompetitions', 'upcomingDeadlines', 'registrations'));
        
    })->name('dashboard');

    // Profil, Bookmark, & Pesanan
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pesanan', [ProfileController::class, 'pesanan'])->name('pesanan');
    Route::post('/lomba/{id}/bookmark', [ProfileController::class, 'toggleBookmark'])->name('bookmark.toggle');
    
    // Pendaftaran & Pembayaran
    Route::post('/registrations/store', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::get('/peserta/pembayaran/{id}', [RegistrationController::class, 'payment'])->name('peserta.payment');
    Route::post('/peserta/pembayaran/{id}/konfirmasi', [RegistrationController::class, 'confirmPayment'])->name('peserta.payment.confirm');

});


// ==========================================
// AREA PENYELENGGARA (Panitia)
// ==========================================
// Semua di dalam sini otomatis diawali url /penyelenggara/ dan nama rute penyelenggara.
Route::prefix('penyelenggara')->name('penyelenggara.')->middleware('auth')->group(function () {
    
    Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
    Route::get('/manajemen', [OrganizerController::class, 'manajemen'])->name('manajemen');
    Route::get('/penyelenggara/statistik', [OrganizerController::class, 'statistik'])->name('statistik');
    
    // Manajemen Lomba
    Route::get('/buat-lomba', [OrganizerController::class, 'create'])->name('create');
    Route::post('/buat-lomba', [OrganizerController::class, 'store'])->name('store');
    Route::get('/edit-lomba/{id}', [OrganizerController::class, 'edit'])->name('edit');
    Route::put('/update-lomba/{id}', [OrganizerController::class, 'update'])->name('update');
    Route::delete('/hapus-lomba/{id}', [OrganizerController::class, 'destroy'])->name('destroy');
    
    // Route untuk Toggle Buka/Tutup Pendaftaran Manual
    Route::patch('/lomba/{id}/toggle-status', [OrganizerController::class, 'toggleStatus'])->name('toggle-status');

    // Pembayaran QRIS Penyelenggara
    Route::get('/pembayaran-lomba/{id}', [OrganizerController::class, 'payment'])->name('payment');
    Route::post('/pembayaran-lomba/{id}/konfirmasi', [OrganizerController::class, 'confirmPayment'])->name('confirmPayment');
    
    // Export Excel
    Route::get('/export-peserta', [OrganizerController::class, 'exportExcel'])->name('export.excel');

    // VERIFIKASI BUKTI PENDAFTARAN 
    Route::post('/pendaftaran/{id}/verifikasi', [OrganizerController::class, 'verify'])->name('pendaftaran.verify');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
    Route::post('/verifikasi/{id}/proses', [AdminController::class, 'prosesVerifikasi'])->name('verifikasi.proses');
    Route::get('/keuangan', [AdminController::class, 'keuangan'])->name('keuangan');

});
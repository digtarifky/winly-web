<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RegistrationController;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;

// ==========================================
// AREA PUBLIK (Bisa diakses siapa saja)
// ==========================================
Route::get('/', function () {
    $latestCompetitions = \App\Models\Competition::with('fields')
        ->withCount('registrations')
        ->where('status', 'aktif')
        ->latest() 
        ->take(3)
        ->get();
   return view('home', ['latestCompetitions' => $latestCompetitions]);
})->name('home');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/competitions', [PublicController::class, 'competitions'])->name('competitions');


// ==========================================
// AREA GUEST (Hanya untuk yang BELUM login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});


// ==========================================
// AREA AUTH (Harus Login - Peserta)
// ==========================================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Dashboard Peserta
    Route::get('/home', function () {
        $registrations = Registration::where('user_id', Auth::id())
                                     ->with('field.competition')
                                     ->latest()
                                     ->get();
        return view('home', ['registrations' => $registrations]);
    })->name('dashboard');

    // Profil & Pesanan
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pesanan', [ProfileController::class, 'pesanan'])->name('pesanan');
    
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
    
    // Manajemen Lomba
    Route::get('/buat-lomba', [OrganizerController::class, 'create'])->name('create');
    Route::post('/buat-lomba', [OrganizerController::class, 'store'])->name('store');
    Route::get('/edit-lomba/{id}', [OrganizerController::class, 'edit'])->name('edit');
    Route::put('/update-lomba/{id}', [OrganizerController::class, 'update'])->name('update');
    Route::delete('/hapus-lomba/{id}', [OrganizerController::class, 'destroy'])->name('destroy');
    // Route untuk Toggle Buka/Tutup Pendaftaran Manual
    Route::patch('/penyelenggara/lomba/{id}/toggle-status', [App\Http\Controllers\OrganizerController::class, 'toggleStatus'])->name('toggle-status');
    
    // Pembayaran QRIS Penyelenggara
    Route::get('/pembayaran-lomba/{id}', [OrganizerController::class, 'payment'])->name('payment');
    Route::post('/pembayaran-lomba/{id}/konfirmasi', [OrganizerController::class, 'confirmPayment'])->name('confirmPayment');
    
    // Export Excel
    Route::get('/export-peserta', [OrganizerController::class, 'exportExcel'])->name('export.excel');

    // VERIFIKASI BUKTI PENDAFTARAN 
    Route::post('/pendaftaran/{id}/verifikasi', [OrganizerController::class, 'verify'])->name('pendaftaran.verify');
});
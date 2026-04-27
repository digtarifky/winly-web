<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RegistrationController;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PublicController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/news', function () {
    return view('news');
})->name('news');


// Hanya untuk yang BELUM login
Route::middleware('guest')->group(function () {
    // Rute Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Rute Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//login
Route::middleware('auth')->group(function () {

    // Route untuk memproses form pendaftaran (Controller yang baru kita buat)
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

    // Route khusus Penyelenggara
    Route::get('/penyelenggara/dashboard', function () {
        return view('penyelenggara.index');
    })->name('penyelenggara.dashboard');
    
});

// Route daftar kompetisi
Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions');

// Route untuk Dashboard Peserta
Route::get('/home', function () {
    $registrations = Registration::where('user_id', Auth::id())
                                 ->with('field.competition')
                                 ->latest()
                                 ->get();
    
    return view('home', [
        'registrations' => $registrations
    ]);
})->name('dashboard');

//pembayaran peserta
Route::middleware('auth')->group(function () {
    Route::controller(RegistrationController::class)->group(function () {
        Route::get('/peserta/pembayaran/{id}', 'payment')->name('peserta.payment');
        Route::post('/peserta/pembayaran/{id}/konfirmasi', 'confirmPayment')->name('peserta.payment.confirm');
    });

});

// AREA PENYELENGGARA
// ==========================================
Route::prefix('penyelenggara')->name('penyelenggara.')->group(function () {
    Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
    Route::get('/buat-lomba', [OrganizerController::class, 'create'])->name('create');
    Route::post('/buat-lomba', [OrganizerController::class, 'store'])->name('store');
    Route::get('/edit-lomba/{id}', [OrganizerController::class, 'edit'])->name('edit');
    Route::put('/update-lomba/{id}', [OrganizerController::class, 'update'])->name('update');
    Route::delete('/hapus-lomba/{id}', [OrganizerController::class, 'destroy'])->name('destroy');
    // Rute Pembayaran QRIS Mockup
    Route::get('/pembayaran-lomba/{id}', [OrganizerController::class, 'payment'])->name('payment');
    Route::post('/pembayaran-lomba/{id}/konfirmasi', [OrganizerController::class, 'confirmPayment'])->name('confirmPayment');
});

Route::get('/competitions', [PublicController::class, 'competitions'])->name('competitions');

// AREA PESERTA (Pendaftaran & Pembayaran Tiket Lomba)
// ========================================================
Route::middleware(['auth'])->group(function () {

    // Route::get('/registrations/store', function () {
    //     return redirect()->route('competitions');
    // });
    Route::post('/registrations/store', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::get('/payment/{id}', [RegistrationController::class, 'payment'])->name('peserta.payment');
    Route::post('/payment/{id}/confirm', [RegistrationController::class, 'confirmPayment'])->name('peserta.payment.confirm');
    
});




<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 2. Memproses Data Register
    public function register(Request $request)
    {
        // Validasi ketat ala Laravel
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Harus ada input password_confirmation di HTML
            'role' => 'required|in:penyelenggara,peserta',
        ]);

        // Simpan ke Database (Password otomatis dienkripsi)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Langsung otomatis Login setelah berhasil daftar
        Auth::login($user);

        // Arahkan ke halaman yang tepat sesuai Role mereka
        if ($user->role === 'penyelenggara') {
            return redirect()->route('penyelenggara.dashboard')->with('success', 'Selamat datang, Penyelenggara!');
        }

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Silakan cari lombamu.');
    }

    // 3. Menampilkan Halaman Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 4. Memproses Data Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan ke halaman sesuai Role
            if (Auth::user()->role === 'penyelenggara') {
                return redirect()->route('penyelenggara.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    // 5. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil keluar.');
    }
}

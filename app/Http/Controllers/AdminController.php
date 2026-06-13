<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin yang bisa mengakses ini
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = Auth::user();

        // 1. Hitung Panitia yang butuh diverifikasi (Status: pending)
        $pendingVerificationCount = User::where('role', 'penyelenggara')
                                        ->where('status_verifikasi', 'pending')
                                        ->count();
                                        
        // 2. Hitung Total Uang Masuk ke Winly (Dari pembayaran publikasi lomba)
        $totalRevenue = Transaction::where('tipe_transaksi', 'publikasi_lomba')
                                   ->where('status_pembayaran', 'berhasil')
                                   ->sum('total_bayar');

        // 3. Hitung Total Panitia yang sudah aktif (Status: verified)
        $activeOrganizers = User::where('role', 'penyelenggara')
                                ->where('status_verifikasi', 'verified')
                                ->count();

        // Lempar data ini ke view
        return view('admin.dashboard', compact('user', 'pendingVerificationCount', 'totalRevenue', 'activeOrganizers'));
    }

    // Halaman Daftar Verifikasi Panitia
    public function verifikasi()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // 1. Ambil daftar panitia yang sedang antre (Pending)
        $panitiaPending = User::where('role', 'penyelenggara')
                              ->where('status_verifikasi', 'pending')
                              ->with('profile') // Ambil data profilnya juga
                              ->latest()
                              ->get();

        // 2. Ambil riwayat panitia yang sudah diproses (Verified / Rejected)
        $panitiaRiwayat = User::where('role', 'penyelenggara')
                              ->whereIn('status_verifikasi', ['verified', 'rejected'])
                              ->with('profile')
                              ->latest()
                              ->get();

        return view('admin.verifikasi', compact('panitiaPending', 'panitiaRiwayat'));
    }

    // Fungsi untuk Memproses Persetujuan / Penolakan
    public function prosesVerifikasi(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $panitia = User::findOrFail($id);
        
        // Update statusnya
        $panitia->update([
            'status_verifikasi' => $request->status
        ]);

        $pesan = $request->status === 'verified' 
            ? 'Akun panitia berhasil disetujui dan diverifikasi!' 
            : 'Akun panitia telah ditolak.';

        return back()->with('success', $pesan);
    }
}
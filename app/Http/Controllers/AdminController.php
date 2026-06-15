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
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 1. Hitung 3 Statistik Utama
        $pendingVerificationCount = User::where('role', 'penyelenggara')->where('status_verifikasi', 'pending')->count();
        $totalRevenue = Transaction::where('tipe_transaksi', 'publikasi_lomba')->where('status_pembayaran', 'berhasil')->sum('total_bayar');
        $activeOrganizers = User::where('role', 'penyelenggara')->where('status_verifikasi', 'verified')->count();

        // 2. Ambil Data Verifikasi
        $panitiaPending = User::where('role', 'penyelenggara')->where('status_verifikasi', 'pending')->with('profile')->latest()->get();
        
        // PAGINATION: Riwayat Keputusan (Max 5, nama custom: riwayatPage)
        $panitiaRiwayat = User::where('role', 'penyelenggara')
                              ->whereIn('status_verifikasi', ['verified', 'rejected'])
                              ->with('profile')
                              ->latest()
                              ->paginate(5, ['*'], 'riwayatPage');

        // 3. Ambil Data Laporan Keuangan (Hanya Publikasi)
        // PAGINATION: Laporan Keuangan (Max 10, nama custom: keuanganPage)
        $transaksi = Transaction::with('user')
                                ->where('tipe_transaksi', 'publikasi_lomba')
                                ->latest()
                                ->paginate(10, ['*'], 'keuanganPage');

        return view('admin.dashboard', compact(
            'pendingVerificationCount', 
            'totalRevenue', 
            'activeOrganizers',
            'panitiaPending',
            'panitiaRiwayat',
            'transaksi'
        ));
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
        
        $panitia->update([
            'status_verifikasi' => $request->status
        ]);

        $pesan = $request->status === 'verified' 
            ? 'Akun panitia berhasil disetujui dan diverifikasi!' 
            : 'Akun panitia telah ditolak.';

        return back()->with('success', $pesan);
    }

    // Halaman Laporan Keuangan
    public function keuangan()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // 1. Ambil data transaksi HANYA untuk Publikasi Lomba
        $transaksi = Transaction::with('user')
                                ->where('tipe_transaksi', 'publikasi_lomba')
                                ->latest()
                                ->get();

        // 2. Hitung total pendapatan sukses HANYA dari Publikasi Lomba
        $totalPendapatan = Transaction::where('tipe_transaksi', 'publikasi_lomba')
                                      ->where('status_pembayaran', 'berhasil')
                                      ->sum('total_bayar');

        return view('admin.keuangan', compact('transaksi', 'totalPendapatan'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate([]); 
        $bookmarkedCompetitions = $user->bookmarkedCompetitions;
        return view('profile', compact('user', 'profile', 'bookmarkedCompetitions'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'tingkat_pendidikan' => 'required|in:SD,SMP,SMA,Mahasiswa,Umum',
            'asal_instansi' => 'required|string|max:255',

        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], 
            [
                'nama_lengkap' => $request->nama_lengkap,
                'no_wa' => $request->no_wa,
                'tingkat_pendidikan' => $request->tingkat_pendidikan,
                'asal_instansi' => $request->asal_instansi,
            ]
        );

        return back()->with('success', 'Profil berhasil disimpan!');

    }

    public function pesanan()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil semua riwayat pendaftaran/pesanan milik peserta ini
        $pesanan = \App\Models\Registration::with('field.competition')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pesanan', compact('user', 'pesanan'));
    }

    public function toggleBookmark($id)
    {
        $user = User::find(Auth::id());
        
        // Fitur sakti 'toggle' dari Laravel
        $user->bookmarkedCompetitions()->toggle($id);

        return back()->with('success', 'Daftar simpanan lomba berhasil diperbarui!');
    }
}
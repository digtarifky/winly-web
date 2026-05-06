<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate([]); 
        
        return view('peserta.profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'no_wa' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tingkat_pendidikan' => 'required|in:SD,SMP,SMA,Mahasiswa,Umum',
            'asal_instansi' => 'required|string|max:255',
            'nisn_nim' => 'nullable|string|max:50',

        ]);

        $profile = $user->profile;

        if ($request->hasFile('foto_kartu_pelajar')) {
            $path = $request->file('foto_kartu_pelajar')->store('kartu_pelajar', 'public');
            $profile->foto_kartu_pelajar = $path;
        }

        $profile->update($request->except(['foto_kartu_pelajar', '_token']));

        return back()->with('success', 'Profil berhasil diperbarui! Sekarang kamu bisa mendaftar lomba.');
    }
}
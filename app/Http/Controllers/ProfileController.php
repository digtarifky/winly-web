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
        
        return view('profile', compact('user', 'profile'));
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
}
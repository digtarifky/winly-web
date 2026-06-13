<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate([]); 

        // Pengecekan cerdas: Jika dia penyelenggara, arahkan ke halaman profil khusus
        if ($user->isPenyelenggara()) {
            return view('penyelenggara.profile', compact('user', 'profile'));
        }

        // Jika peserta, arahkan ke halaman profil biasa
        $bookmarkedCompetitions = $user->bookmarkedCompetitions;
        return view('profile', compact('user', 'profile', 'bookmarkedCompetitions'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi Dasar
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'asal_instansi' => 'required|string|max:255',
        ];

        // 2. Bedakan validasi 'tingkat_pendidikan' dan tambah validasi berkas
        // 2. Tambahan Validasi Khusus Penyelenggara (Berkas Terpisah)
        if ($user->isPenyelenggara()) {
            $rules['tingkat_pendidikan'] = 'required|in:Universitas,Sekolah,Komunitas/Organisasi,Perusahaan,Instansi Pemerintah';
            $rules['dokumen_ktp'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['dokumen_legalitas'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        } else {
            $rules['tingkat_pendidikan'] = 'required|in:SD,SMP,SMA,Mahasiswa,Umum';
        }

        $request->validate($rules);

        // 3. Simpan Profil Dasar ke tabel peserta_profiles
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], 
            [
                'nama_lengkap' => $request->nama_lengkap,
                'no_wa' => $request->no_wa,
                'tingkat_pendidikan' => $request->tingkat_pendidikan,
                'asal_instansi' => $request->asal_instansi,
            ]
        );

        // 4. Eksekusi Berkas Verifikasi Khusus Penyelenggara ke tabel users
        if ($user->isPenyelenggara()) {
            $hasNewUpload = false;

            // Proses Upload KTP
            if ($request->hasFile('dokumen_ktp')) {
                if ($user->dokumen_ktp) Storage::disk('public')->delete($user->dokumen_ktp);
                $user->dokumen_ktp = $request->file('dokumen_ktp')->store('verifikasi/ktp', 'public');
                $hasNewUpload = true;
            }

            // Proses Upload Surat Organisasi/Legalitas
            if ($request->hasFile('dokumen_legalitas')) {
                if ($user->dokumen_legalitas) Storage::disk('public')->delete($user->dokumen_legalitas);
                $user->dokumen_legalitas = $request->file('dokumen_legalitas')->store('verifikasi/legalitas', 'public');
                $hasNewUpload = true;
            }

            // Jika ada file baru yang diunggah, ubah status jadi pending agar di-review Admin
            if ($hasNewUpload) {
                $user->status_verifikasi = 'pending';
                $user->save();
            }
        }

        return back()->with('success', 'Data profil dan verifikasi berhasil disimpan!');
    }

    public function pesanan()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pesanan = \App\Models\Registration::with('field.competition')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pesanan', compact('user', 'pesanan'));
    }

    public function toggleBookmark($id)
    {
        $user = User::find(Auth::id());
        $user->bookmarkedCompetitions()->toggle($id);

        return back()->with('success', 'Daftar simpanan lomba berhasil diperbarui!');
    }
}
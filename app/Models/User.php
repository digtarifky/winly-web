<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PesertaProfile;
use App\Models\Competition;

#[Fillable(['name', 'email', 'password', 'role', 'status_verifikasi', 'dokumen_ktp', 'dokumen_legalitas'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =======================================================
    // RELASI DATABASE
    // =======================================================
    
    // Relasi: Jika User adalah Penyelenggara, dia membuat banyak lomba
    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    // Relasi: Jika User adalah Peserta, dia punya banyak riwayat pendaftaran
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Relasi One-to-One ke tabel profil (Peserta/Penyelenggara)
    public function profile()
    {
        return $this->hasOne(PesertaProfile::class);
    }

    public function bookmarkedCompetitions()
    {
        return $this->belongsToMany(\App\Models\Competition::class, 'bookmarks')->withTimestamps();
    }


    // =========================================================================
    // CUSTOM HELPER METHODS (Untuk Cek Role & Status Verifikasi)
    // =========================================================================

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPenyelenggara()
    {
        return $this->role === 'penyelenggara';
    }

    public function isPeserta()
    {
        return $this->role === 'peserta';
    }

    // HELPER BARU: Untuk cek status verifikasi Penyelenggara
    public function isVerified()
    {
        return $this->status_verifikasi === 'verified';
    }

    public function isPendingVerification()
    {
        return $this->status_verifikasi === 'pending';
    }

    public function isRejected()
    {
        return $this->status_verifikasi === 'rejected';
    }

    public function isProfileComplete()
    {
        $profile = $this->profile;
        if (!$profile) return false;

        // Cek kolom wajib yang tidak boleh kosong
        return !empty($profile->nama_lengkap) && 
               !empty($profile->no_wa) && 
               !empty($profile->asal_instansi) && 
               !empty($profile->tingkat_pendidikan);
    }
}
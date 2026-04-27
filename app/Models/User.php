<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role',])]
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

    // Relasi: Jika User adalah Penyelenggara, dia membuat banyak lomba
    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    // =======================================================
    // WAJIB DITAMBAHKAN: Relasi ke tabel Registrations
    // =======================================================
    // Relasi: Jika User adalah Peserta, dia punya banyak riwayat pendaftaran
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    // =======================================================

    // Relasi lama (Biarkan saja)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // =========================================================================
    // CUSTOM HELPER METHODS (Opsional - Untuk mempermudah pengecekan role)
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

    // Relasi: Satu User bisa punya banyak pendaftaran
    public function registration()
    {
        return $this->hasMany(Registration::class);
    }
}
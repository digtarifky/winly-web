<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registration;
use App\Models\CompetitionField;

class Competition extends Model
{
    use HasFactory;

    // UPDATE: Menyesuaikan dengan kolom di Migration terbaru
    protected $fillable = [
        'user_id',
        'judul_lomba',
        'kategori',
        'tingkat_sekolah',
        'deskripsi',
        'poster',
        'tanggal_pelaksanaan',
        'tanggal_mulai_daftar',
        'tanggal_selesai_daftar',
        'status',
        'tingkat_lomba',
        'link_panduan',
        'status',
        'benefits'
    ];

    protected $casts = [
        'benefits' => 'array',
    ];

    // Relasi: Lomba ini milik Penyelenggara siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =======================================================
    // WAJIB DITAMBAHKAN: Relasi ke tabel Bidang Lomba
    // =======================================================
    public function fields()
    {
        return $this->hasMany(CompetitionField::class);
    }

    // =======================================================
    // Relasi lamamu (Biarkan saja jika tabelnya memang ada)
    // =======================================================
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function registrations()
    {
        return $this->hasManyThrough(
            Registration::class,
            CompetitionField::class,
            'competition_id',
            'competition_field_id',
            'id', // Local key di tabel ini (competitions)
            'id'  // Local key di tabel perantara (competition_fields)
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionField extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi Balik ke Competition (Bidang ini milik lomba mana?)
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    // 2. Relasi ke Registrations (Satu bidang ini bisa diikuti oleh BANYAK pendaftar/peserta)
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
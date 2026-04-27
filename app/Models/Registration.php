<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi ke User (Siapa peserta yang mendaftar ini?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Relasi ke CompetitionField (Peserta ini mendaftar di bidang apa?)
    public function field()
    {
        // Parameter kedua ('competition_field_id') memastikan Laravel mencari kolom foreign key yang tepat
        return $this->belongsTo(CompetitionField::class, 'competition_field_id');
    }

    
}
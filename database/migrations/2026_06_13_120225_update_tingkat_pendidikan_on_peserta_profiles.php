<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Mengubah kolom ENUM menjadi VARCHAR (String biasa) agar fleksibel menerima kategori baru
        DB::statement("ALTER TABLE peserta_profiles MODIFY tingkat_pendidikan VARCHAR(255) NULL");
    }

    public function down()
    {
        // Jika di-rollback, kembalikan ke aturan awal
        DB::statement("ALTER TABLE peserta_profiles MODIFY tingkat_pendidikan ENUM('SD', 'SMP', 'SMA', 'Mahasiswa', 'Umum') NULL");
    }
};
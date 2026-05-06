<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('peserta_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        // Informasi Pribadi
        $table->string('nama_lengkap')->nullable();
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
        
        // Kontak & Alamat
        $table->string('no_wa')->nullable();
        $table->text('alamat')->nullable();
        
        // Akademik
        $table->enum('tingkat_pendidikan', ['SD', 'SMP', 'SMA', 'Mahasiswa', 'Umum'])->nullable();
        $table->string('asal_instansi')->nullable();
        $table->string('nisn_nim')->nullable();
        $table->string('foto_kartu_pelajar')->nullable();
        
        $table->timestamps();
    });
}
};

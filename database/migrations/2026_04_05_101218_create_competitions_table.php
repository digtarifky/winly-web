<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul_lomba');
            $table->string('kategori');
            $table->string('tingkat_sekolah');
            $table->text('deskripsi')->nullable();
            $table->string('poster')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->date('tanggal_mulai_daftar')->nullable();
            $table->date('tanggal_selesai_daftar')->nullable();
            
            $table->enum('status', ['aktif', 'tutup', 'draf'])->default('draf');
            $table->enum('tingkat_lomba', ['kota', 'umum', 'provinsi', 'nasional', 'internasional'])->default('umum');
            $table->string('link_panduan')->nullable();
            $table->json('benefits')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Peserta yang mendaftar)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            // Relasi ke Bidang yang dipilih (misal: Matematika di PSN 2026)
            $table->foreignId('competition_field_id')->constrained('competition_fields')->cascadeOnDelete(); 
            
            $table->enum('jalur_pendaftaran', ['gratis', 'berbayar']); 
            
            // Kolom untuk jalur GRATIS (menyimpan nama file/link gambar)
            $table->string('bukti_follow')->nullable();
            $table->string('bukti_share')->nullable();
            $table->string('bukti_komentar')->nullable();
            
            // Kolom untuk jalur BERBAYAR (Status Midtrans)
            $table->enum('status_pembayaran', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->string('snap_token')->nullable(); // Token dari Midtrans
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};

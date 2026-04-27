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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (Peserta yang mendaftar)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Relasi ke tabel lomba
            $table->foreignId('competition_id')->constrained('competitions')->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status_pembayaran', ['pending', 'berhasil', 'gagal'])->default('pending');
            
            $table->string('tipe_transaksi')->default('publikasi_lomba');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

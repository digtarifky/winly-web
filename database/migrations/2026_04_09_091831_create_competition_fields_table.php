<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->string('nama_bidang');
            $table->enum('tipe_pendaftaran', ['gratis', 'berbayar', 'pilihan'])->default('gratis');
            $table->integer('harga')->default(0);
            $table->string('link_wa')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competition_fields');
    }
};
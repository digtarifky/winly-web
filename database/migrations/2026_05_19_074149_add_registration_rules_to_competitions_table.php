<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            // Kita letakkan kolom baru setelah kolom tanggal_pelaksanaan
            $table->date('tgl_buka_pendaftaran')->nullable()->after('tanggal_pelaksanaan');
            $table->date('tgl_tutup_pendaftaran')->nullable()->after('tgl_buka_pendaftaran');
            $table->integer('kuota_peserta')->default(100)->after('tgl_tutup_pendaftaran');
            $table->boolean('is_pendaftaran_tutup')->default(false)->after('kuota_peserta');
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn(['tgl_buka_pendaftaran', 'tgl_tutup_pendaftaran', 'kuota_peserta', 'is_pendaftaran_tutup']);
        });
    }
};
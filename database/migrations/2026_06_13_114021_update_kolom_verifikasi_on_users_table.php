<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom lama yang digabung
            $table->dropColumn('dokumen_verifikasi');
            
            // Buat 2 kolom baru yang terpisah
            $table->string('dokumen_ktp')->nullable()->after('status_verifikasi');
            $table->string('dokumen_legalitas')->nullable()->after('dokumen_ktp');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dokumen_verifikasi')->nullable();
            $table->dropColumn(['dokumen_ktp', 'dokumen_legalitas']);
        });
    }
};


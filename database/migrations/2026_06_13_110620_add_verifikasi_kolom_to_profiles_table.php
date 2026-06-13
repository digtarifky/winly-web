<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // KITA UBAH MENJADI TABEL USERS
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified');
            $table->string('dokumen_verifikasi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'dokumen_verifikasi']);
        });
    }
};
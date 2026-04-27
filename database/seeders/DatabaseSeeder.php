<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Competition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Penyelenggara
        $admin = User::firstOrCreate(
            ['email' => 'admin@winly.com'],
            [
                'name' => 'Admin POSI',
                'password' => Hash::make('password'),
                'role' => 'penyelenggara'
            ]
        );

        $peserta = User::firstOrCreate(
            ['email' => 'peserta@winly.com'],
            [
                'name' => 'Peserta Uji Coba',
                'password' => Hash::make('password'),
                'role' => 'peserta'
            ]
        );

        // 4. Buat Lomba 1: PSN 2026 (Hanya Berbayar)
        $psn = Competition::create([
            'user_id' => $admin->id,
            'judul_lomba' => 'PESTA SAINS NASIONAL (PSN) TAHUN 2026',
            'kategori' => 'akademik',
            'tingkat_sekolah' => 'SMA',
            'deskripsi' => 'Ikuti kompetisi olimpiade sains dan tunjukkan potensimu bersama ribuan pelajar dari seluruh Indonesia.',
            'poster' => 'https://i.pinimg.com/736x/05/2b/6e/052b6eee9ed668347dcff784f356f784.jpg',
            'tanggal_pelaksanaan' => '2026-04-12',
            'tanggal_mulai_daftar' => '2026-02-19',
            'tanggal_selesai_daftar' => '2026-04-10',
            'status' => 'aktif'
        ]);

        $psn->fields()->createMany([
            ['nama_bidang' => 'Matematika', 'tipe_pendaftaran' => 'berbayar', 'harga' => 50000],
            ['nama_bidang' => 'Biologi', 'tipe_pendaftaran' => 'berbayar', 'harga' => 50000],
        ]);

        // 5. Buat Lomba 2: SHSO 2026 (Gratis & Berbayar)
        $shso = Competition::create([
            'user_id' => $admin->id,
            'judul_lomba' => 'Sistem Hukum dan Sosial Humaniora (SHSO) 2026',
            'kategori' => 'soshum_hukum',
            'tingkat_sekolah' => 'mahasiswa',
            'deskripsi' => 'Kompetisi eksklusif untuk pelajar mahasiswa.',
            'poster' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'tanggal_pelaksanaan' => '2026-04-18',
            'tanggal_mulai_daftar' => '2026-01-20',
            'tanggal_selesai_daftar' => '2026-04-06',
            'status' => 'aktif'
        ]);

        $shso->fields()->createMany([
            ['nama_bidang' => 'Ekonomi', 'tipe_pendaftaran' => 'gratis', 'harga' => 0],
            ['nama_bidang' => 'Geografi', 'tipe_pendaftaran' => 'berbayar', 'harga' => 75000],
            ['nama_bidang' => 'Fisika', 'tipe_pendaftaran' => 'pilihan', 'harga' => 75000],
        ]);

        $this->command->info('Data Dummy (User, Kategori, Lomba) Berhasil Dibuat!');
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Competition;

class PublicController extends Controller
{
    public function index()
    {
        $hariIni = \Carbon\Carbon::now()->startOfDay();
        $batasH7 = $hariIni->copy()->addDays(7)->endOfDay();

        // 1. Saring dari Database
        $queryLombaBuka = \App\Models\Competition::with('fields')
            ->withCount('registrations')
            ->where('status', 'aktif')
            ->where('is_pendaftaran_tutup', false)
            ->where(function($query) use ($hariIni) {
                $query->whereNull('tgl_tutup_pendaftaran')
                      ->orWhere('tgl_tutup_pendaftaran', '>=', $hariIni);
            })
            ->latest()
            ->get();

        // 2. Saring Kuota Penuh
        $semuaLombaAman = $queryLombaBuka->filter(function ($lomba) {
            $kuota = $lomba->kuota_peserta ?? 100;
            return $lomba->registrations_count < $kuota;
        });

        // 3. Data Upcoming Deadlines
        $upcomingDeadlines = $semuaLombaAman->filter(function ($lomba) use ($hariIni, $batasH7) {
            if (!$lomba->tgl_tutup_pendaftaran) return false;
            $tglTutup = \Carbon\Carbon::parse($lomba->tgl_tutup_pendaftaran)->endOfDay();
            return $tglTutup->between($hariIni, $batasH7);
        })->sortBy('tgl_tutup_pendaftaran')->take(3);

        // 4. Data Kompetisi Seru
        $latestCompetitions = $semuaLombaAman->take(3);

        return view('home', compact('latestCompetitions', 'upcomingDeadlines'));
    }

    public function competitions()
    {
        $hariIni = Carbon::now()->startOfDay();
        $batasH7 = $hariIni->copy()->addDays(7)->endOfDay();

        // Reminder H-7 di halaman competitions
        $upcomingDeadlines = Competition::withCount('registrations')
            ->where('status', 'aktif')
            ->where('is_pendaftaran_tutup', false)
            ->whereNotNull('tgl_tutup_pendaftaran')
            ->whereBetween('tgl_tutup_pendaftaran', [$hariIni, $batasH7])
            ->orderBy('tgl_tutup_pendaftaran', 'asc')
            ->get()
            ->filter(function ($lomba) {
                $kuota = $lomba->kuota_peserta ?? 100;
                return $lomba->registrations_count < $kuota;
            });

        // Semua daftar kompetisi (Kode aslimu)
        $competitions = Competition::with('fields')
            ->withCount('registrations')
            ->where('status', 'aktif')
            ->latest()
            ->get();

        return view('competitions', compact('competitions', 'upcomingDeadlines'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class CompetitionController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data lomba yang statusnya 'aktif'
        $competitions = Competition::with('fields')
                                   ->where('status', 'aktif')
                                   ->orderBy('tanggal_pelaksanaan', 'asc')
                                   ->get();

        // 2. Kirim data tersebut ke file 'competitions.blade.php'
        return view('competitions', [
            'competitions' => $competitions
        ]);
    }
}
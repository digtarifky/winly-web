<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class CompetitionController extends Controller
{
    public function index()
    {

        $competitions = Competition::with('fields')
            ->where('status', 'aktif')
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->get();

        return view('competitions', [
            'competitions' => $competitions
        ]);
    }
}
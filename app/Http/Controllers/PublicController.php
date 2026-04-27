<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class PublicController extends Controller
{
    public function competitions()
    {
       $competitions = Competition::with('fields')
            ->withCount('registrations')
            ->where('status', 'aktif')
            ->latest()
            ->get();

        return view('competitions', compact('competitions'));
    }
}
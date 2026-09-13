<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenugasanController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        $penugasans = $guru->guru_mapels()
            ->with(['mata_pelajaran', 'penugasan_rombels.rombel'])
            ->get();

        return view('guru.penugasan', compact('penugasans'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use App\Models\Kriteria;
use App\Models\Wisata;

class RekomendasiController extends Controller
{
    protected $sawService;

    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Tampilkan halaman rekomendasi untuk wisatawan
     */
    public function index()
    {
        $ranking = $this->sawService->getRanking();
        $kriterias = Kriteria::all();
        $wisatas = Wisata::all();

        return view('wisatawan.rekomendasi', compact('ranking', 'kriterias', 'wisatas'));
    }

    /**
     * Tampilkan detail perbandingan
     */
    public function compare()
    {
        $wisatas = Wisata::all();
        $kriterias = Kriteria::all();
        $ranking = $this->sawService->getRanking();

        return view('wisatawan.compare', compact('wisatas', 'kriterias', 'ranking'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    /**
     * Display penilaian matrix (hanya untuk C3, C4, C5)
     */
    public function index()
    {
        // Ambil semua wisata
        $wisatas = Wisata::orderBy('nama_wisata')->get();

        // Ambil hanya kriteria C3, C4, C5 (kriteria yang diisi admin)
        $kriterias = Kriteria::whereIn('kode_kriteria', ['C3', 'C4', 'C5'])
            ->orderBy('kode_kriteria')
            ->get();

        // Ambil data penilaian yang sudah ada
        $penilaians = Penilaian::whereIn('kriteria_id', $kriterias->pluck('id'))
            ->get()
            ->keyBy(function ($item) {
                return $item->wisata_id . '_' . $item->kriteria_id;
            });

        return view('admin.penilaian.index', compact('wisatas', 'kriterias', 'penilaians'));
    }

    /**
     * Store or update penilaian
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penilaian' => 'required|array',
            'penilaian.*.*' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $penilaianData = $request->input('penilaian', []);

        foreach ($penilaianData as $wisataId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                if ($nilai !== null && $nilai !== '') {
                    Penilaian::updateOrCreate(
                        [
                            'wisata_id' => $wisataId,
                            'kriteria_id' => $kriteriaId
                        ],
                        [
                            'nilai' => $nilai
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('admin.penilaian.index')
            ->with('success', 'Data penilaian berhasil disimpan!');
    }

    /**
     * Get nilai untuk API (opsional)
     */
    public function getNilai($wisataId)
    {
        $penilaians = Penilaian::where('wisata_id', $wisataId)
            ->with('kriteria')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->kriteria->kode_kriteria => $item->nilai];
            });

        return response()->json($penilaians);
    }
}

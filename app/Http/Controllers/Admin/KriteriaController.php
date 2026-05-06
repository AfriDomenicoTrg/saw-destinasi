<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->paginate(10);
        $totalBobot = Kriteria::sum('bobot');
        return view('admin.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kriteria' => 'required|unique:kriterias|max:10',
            'nama_kriteria' => 'required|max:100',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kriteria::create($request->all());

        // Hitung ulang total bobot
        $totalBobot = Kriteria::sum('bobot');

        if ($totalBobot > 1) {
            $this->command->warn('Total bobot melebihi 100%');
        }

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        return view('admin.kriteria.show', compact('kriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $validator = Validator::make($request->all(), [
            'kode_kriteria' => 'required|max:10|unique:kriterias,kode_kriteria,' . $kriteria->id,
            'nama_kriteria' => 'required|max:100',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kriteria->update($request->all());

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()
            ->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil dihapus!');
    }
    public function getTotalBobot()
{
    $totalBobot = Kriteria::sum('bobot');
    return response()->json(['total' => $totalBobot]);
}
}

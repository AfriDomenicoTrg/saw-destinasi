<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{

    public function index()
    {
        $wisata = Wisata::latest()->get();

        return view('admin.wisata.index', compact('wisata'));
    }


    public function create()
    {
        return view('admin.wisata.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'harga_tiket' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'fasilitas' => 'nullable|string',
        ]);

        Wisata::create($request->all());

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil ditambahkan');
    }


    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);

        return view('admin.wisata.edit', compact('wisata'));
    }


    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);

        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'harga_tiket' => 'required|numeric',
        ]);

        $wisata->update($request->all());

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil diupdate');
    }

    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);
        $wisata->delete();

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil dihapus');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wisata extends Model
{
    protected $table = 'wisatas';

    protected $fillable = [
        'kode_wisata',
        'nama_wisata',
        'deskripsi',
        'lokasi',
        'gambar'
        // HAPUS fasilitas, keindahan, harga_tiket karena pindah ke tabel penilaian
    ];

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    // Helper untuk mendapatkan nilai kriteria tertentu
    public function getNilaiKriteria($kriteriaKode)
    {
        $kriteria = Kriteria::where('kode_kriteria', $kriteriaKode)->first();
        if (!$kriteria) return null;

        $penilaian = $this->penilaians()->where('kriteria_id', $kriteria->id)->first();
        return $penilaian ? $penilaian->nilai : null;
    }
}

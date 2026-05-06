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
    ];

    /**
     * Relasi ke tabel penilaian
     */
    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }
}

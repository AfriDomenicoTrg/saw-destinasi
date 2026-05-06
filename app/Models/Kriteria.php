<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriterias';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'tipe',
        'bobot'
    ];

    protected $casts = [
        'bobot' => 'float'
    ];

    /**
     * Relasi ke tabel penilaian
     */
    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    /**
     * Cek apakah tipe kriteria benefit
     */
    public function isBenefit(): bool
    {
        return $this->tipe === 'benefit';
    }

    /**
     * Cek apakah tipe kriteria cost
     */
    public function isCost(): bool
    {
        return $this->tipe === 'cost';
    }
}

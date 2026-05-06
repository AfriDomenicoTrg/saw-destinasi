<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = [
        'wisata_id',
        'kriteria_id',
        'nilai'
    ];

    protected $casts = [
        'nilai' => 'float'
    ];

    public function wisata(): BelongsTo
    {
        return $this->belongsTo(Wisata::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}

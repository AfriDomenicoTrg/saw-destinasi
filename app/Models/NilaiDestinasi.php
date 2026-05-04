<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiDestinasi extends Model
{
    protected $table = 'nilai_destinasis';
    protected $fillable = ['id_destinasis', 'id_kriteria', 'nilai'];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasis');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}

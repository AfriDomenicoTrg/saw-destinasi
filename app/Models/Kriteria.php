<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriterias';
    protected $fillable = ['nama_kriterias', 'satuan', 'atribut', 'is_active'];

    public function nilaiDestinasi()
    {
        return $this->hasMany(NilaiDestinasi::class, 'id_kriterias');
    }
}

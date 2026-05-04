<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $table = 'destinasis';
    protected $fillable = ['nama_destinasis', 'lokasi', 'deskripsi', 'gambar', 'is_active'];

    public function nilai()
    {
        return $this->hasMany(NilaiDestinasi::class, 'id_destinasis');
    }
}

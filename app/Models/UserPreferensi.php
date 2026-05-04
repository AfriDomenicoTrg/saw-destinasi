<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreferensi extends Model
{
    protected $table = 'user_preferensis';
    protected $fillable = ['user_id', 'nama_sesi', 'bobot_kriteria', 'destinasi_terpilih'];

    protected $casts = [
        'bobot_kriteria' => 'array',
        'destinasi_terpilih' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

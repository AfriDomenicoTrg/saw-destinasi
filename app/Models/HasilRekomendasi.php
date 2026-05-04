<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilRekomendasi extends Model
{
    protected $table = 'hasil_rekomendasis';
    protected $fillable = ['user_id', 'user_preferensi_id', 'hasil_ranking', 'total_bobot'];

    protected $casts = [
        'hasil_ranking' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function preferensi()
    {
        return $this->belongsTo(UserPreferensi::class, 'user_preferensi_id');
    }
}

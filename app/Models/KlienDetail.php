<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlienDetail extends Model
{
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'npwp',
        'alamat_perusahaan',
        'skala_usaha'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

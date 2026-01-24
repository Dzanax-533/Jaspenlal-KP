<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'nama_paket',
        'harga',
        'deskripsi'
    ];
    public function pendaftarans() {
        return $this->hasMany(Pendaftaran::class);
    }
}

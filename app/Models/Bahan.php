<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $fillable = [
        'pendaftaran_id', 'nama_bahan', 'produsen',
        'lembaga_penerbit', 'nomor_sertifikat', 'masa_berlaku','status_validasi','catatan'
    ];

    public function pendaftaran() {
        return $this->belongsTo(Pendaftaran::class);
    }
}

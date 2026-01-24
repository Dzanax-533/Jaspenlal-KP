<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'termin',
        'bukti_transfer',
        'nominal',
        'status_verifikasi',
        'keterangan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}

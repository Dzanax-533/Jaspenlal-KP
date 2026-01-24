<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'nama_dokumen',
        'file_path',
        'status',
        'catatan_revisi'
    ];

    /**
     * Relasi balik ke Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}

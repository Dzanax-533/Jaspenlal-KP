<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'no_telepon'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* -------------------------------------------------------------------------- */
    /* ROLE CHECKERS                               */
    /* -------------------------------------------------------------------------- */

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isKonsultan(): bool {
        return $this->role === 'konsultan';
    }

    public function isKeuangan(): bool {
        return $this->role === 'keuangan';
    }

    public function isKlien(): bool {
        return $this->role === 'klien';
    }

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Relasi untuk Klien: Melihat pendaftaran miliknya sendiri
     */
    public function pendaftarans() {
        return $this->hasMany(Pendaftaran::class, 'user_id');
    }
    
    /**
     * Relasi untuk Konsultan: Melihat pendaftaran yang didampinginya
     */
    public function pendampingans() {
        return $this->hasMany(Pendaftaran::class, 'konsultan_id');
    }

    /**
     * Relasi ke profil perusahaan klien
     */
    public function klienDetail() {
        return $this->hasOne(KlienDetail::class, 'user_id');
    }
}

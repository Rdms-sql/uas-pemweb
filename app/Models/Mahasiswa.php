<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    protected $table = 'mahasiswas';
    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'nim', 'nama', 'email', 'password',
        'program_studi', 'semester', 'no_telepon',
        'foto_profil', 'is_active',
    ];

    protected $hidden = ['password'];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agen extends Authenticatable
{
    protected $table = 'agens';
    protected $primaryKey = 'id_agen';

    protected $fillable = [
        'nama', 'email', 'password', 'level_agen',
        'unit_kerja', 'no_telepon', 'foto_profil',
        'is_active', 'is_verified',
    ];

    protected $hidden = ['password'];
}
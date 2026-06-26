<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumens';
    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'id_admin', 'judul', 'isi', 'is_active',
    ];
}
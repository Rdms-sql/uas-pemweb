<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentars';

    protected $primaryKey = 'id_komentar';

    protected $fillable = [
        'id_tiket',
        'pengirim_tipe',
        'id_pengirim',
        'pesan',
        'lampiran',
        'waktu_kirim',
        'is_internal',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';

    protected $primaryKey = 'id_notif';

    protected $fillable = [
        'penerima_tipe',
        'id_penerima',
        'id_tiket',
        'judul_notif',
        'pesan',
        'tipe_notif',
        'is_read',
        'waktu'
    ];
}
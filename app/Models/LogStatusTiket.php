<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatusTiket extends Model
{
    protected $table = 'log_status_tikets';

    protected $fillable = [
        'id_tiket',
        'status_lama',
        'status_baru',
        'level_lama',
        'level_baru',
        'changed_by_tipe',
        'changed_by_id',
        'catatan',
        'waktu',
    ];
}
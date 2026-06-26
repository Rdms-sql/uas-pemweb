<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'lapoans';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_admin', 'periode', 'total_tiket', 'total_tiket_urgent',
        'tiket_level1', 'tiket_level2', 'tiket_level3',
        'rata_sla_jam', 'rata_rating', 'tanggal_buat',
    ];
}
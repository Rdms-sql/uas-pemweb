<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori', 'deskripsi', 'level_agen_default',
        'sla_jam_normal', 'sla_jam_urgent', 'is_active',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_kategori', 'id_kategori');
    }
}
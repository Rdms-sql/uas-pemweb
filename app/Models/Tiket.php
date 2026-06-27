<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tikets';
    protected $primaryKey = 'id_tiket';

    protected $fillable = [
        'id_mahasiswa', 'id_agen', 'id_kategori',
        'judul', 'deskripsi', 'is_urgent', 'alasan_urgent',
        'prioritas', 'level_saat_ini', 'status',
        'lampiran', 'sla_deadline', 'rating', 'ulasan', 'closed_at',
    ];

    protected $casts = [
        'is_urgent'    => 'boolean',
        'sla_deadline' => 'datetime',
        'closed_at'    => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function agen()
    {
        return $this->belongsTo(Agen::class, 'id_agen', 'id_agen');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_tiket', 'id_tiket');
    }

    public function logStatus()
    {
        return $this->hasMany(LogStatusTiket::class, 'id_tiket', 'id_tiket');
    }
}
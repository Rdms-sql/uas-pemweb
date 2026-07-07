<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori'      => 'Akademik',
                'deskripsi'          => 'Masalah nilai, KRS, transkrip, dan akademik lainnya',
                'level_agen_default' => '1',
                'sla_jam_normal'     => 24,
                'sla_jam_urgent'     => 12,
            ],
            [
                'nama_kategori'      => 'Keuangan',
                'deskripsi'          => 'Masalah pembayaran UKT, beasiswa, tagihan',
                'level_agen_default' => '2',
                'sla_jam_normal'     => 48,
                'sla_jam_urgent'     => 24,
            ],
            [
                'nama_kategori'      => 'Fasilitas Kampus',
                'deskripsi'          => 'Perpustakaan, laboratorium, ruang kelas',
                'level_agen_default' => '1',
                'sla_jam_normal'     => 24,
                'sla_jam_urgent'     => 12,
            ],
            [
                'nama_kategori'      => 'Umum',
                'deskripsi'          => 'Laporan umum yang tidak masuk kategori lain',
                'level_agen_default' => '1',
                'sla_jam_normal'     => 24,
                'sla_jam_urgent'     => 12,
            ],
        ];

        foreach ($kategoris as $kat) {
            DB::table('kategoris')->insert([
                'nama_kategori'      => $kat['nama_kategori'],
                'deskripsi'          => $kat['deskripsi'],
                'level_agen_default' => $kat['level_agen_default'],
                'sla_jam_normal'     => $kat['sla_jam_normal'],
                'sla_jam_urgent'     => $kat['sla_jam_urgent'],
                'is_active'          => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}
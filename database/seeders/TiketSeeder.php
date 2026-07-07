<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        $judulTiket = [
            ['judul' => 'Nilai UAS belum keluar', 'urgent' => true],
            ['judul' => 'Tidak bisa login ke portal akademik', 'urgent' => true],
            ['judul' => 'KRS bermasalah saat pengisian', 'urgent' => true],
            ['judul' => 'Pertanyaan seputar jadwal kuliah', 'urgent' => false],
            ['judul' => 'Permintaan surat keterangan aktif kuliah', 'urgent' => false],
            ['judul' => 'Kesalahan data di transkrip nilai', 'urgent' => true],
            ['judul' => 'Ingin pindah kelas mata kuliah', 'urgent' => false],
            ['judul' => 'Pembayaran UKT gagal terverifikasi', 'urgent' => true],
            ['judul' => 'Tanya prosedur cuti akademik', 'urgent' => false],
            ['judul' => 'Perpustakaan: buku hilang tidak sengaja', 'urgent' => false],
        ];

        $statuses = ['baru', 'diproses', 'menunggu_info', 'selesai', 'ditutup'];

        $mahasiswaIds = DB::table('mahasiswas')->pluck('id_mahasiswa')->toArray();
        $kategoriIds  = DB::table('kategoris')->pluck('id_kategori')->toArray();
        $agenIds      = DB::table('agens')->pluck('id_agen')->toArray();

        if (empty($mahasiswaIds) || empty($kategoriIds)) {
            $this->command->warn('Jalankan MahasiswaSeeder dan KategoriSeeder terlebih dahulu.');
            return;
        }

        foreach ($judulTiket as $item) {

            $status = $statuses[array_rand($statuses)];
            $level = rand(1, 3);

            // Jika status baru, tiket belum memiliki agen
            if ($status == 'baru') {
                $idAgen = null;
            } else {
                $idAgen = !empty($agenIds)
                    ? $agenIds[array_rand($agenIds)]
                    : null;
            }

            DB::table('tikets')->insert([
                'id_mahasiswa'   => $mahasiswaIds[array_rand($mahasiswaIds)],
                'id_agen'        => $idAgen,
                'id_kategori'    => $kategoriIds[array_rand($kategoriIds)],
                'judul'          => $item['judul'],
                'deskripsi'      => 'Ini adalah deskripsi contoh untuk laporan: ' . $item['judul'] . '. Mohon segera ditindaklanjuti.',
                'is_urgent'      => $item['urgent'],
                'alasan_urgent'  => $item['urgent'] ? 'Terdeteksi otomatis oleh sistem' : null,
                'prioritas'      => $item['urgent'] ? 'tinggi' : 'rendah',
                'level_saat_ini' => $level,
                'status'         => $status,
                'sla_deadline'   => now()->addHours($item['urgent'] ? 12 : 24),
                'rating'         => $status == 'selesai' ? rand(3, 5) : null,
                'created_at'     => now()->subDays(rand(0, 20)),
                'updated_at'     => now(),
            ]);
        }
    }
}
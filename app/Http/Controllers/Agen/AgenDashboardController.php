<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Notifikasi;
use App\Models\LogStatusTiket;
use App\Models\Komentar;
use Illuminate\Http\Request;

class AgenDashboardController extends Controller
{
    public function index()
    {
        $total = Tiket::where('level_saat_ini', '3')->count();

        $pending = Tiket::where('level_saat_ini', '3')
                        ->where('status', 'baru')
                        ->count();

        $diproses = Tiket::where('level_saat_ini', '3')
                        ->where('status', 'diproses')
                        ->count();

        $selesai = Tiket::where('level_saat_ini', '3')
                        ->where('status', 'selesai')
                        ->count();

        $tikets = Tiket::where('level_saat_ini', '3')
                        ->latest()
                        ->take(5)
                        ->get();

        return view('agen.dashboard', compact(
            'total',
            'pending',
            'diproses',
            'selesai',
            'tikets'
        ));
    }

    // Tambahkan di bawah index()
    public function show($id)
    {
        $tiket = Tiket::with([
            'mahasiswa',
            'agen',
            'kategori'
        ])
        ->where('level_saat_ini', '3')
        ->findOrFail($id);

        $komentars = Komentar::where('id_tiket', $id)
                        ->orderBy('waktu_kirim', 'asc')
                        ->get();

        return view('agen.tiket.show', compact(
            'tiket',
            'komentars'
        ));
    }

    public function proses($id)
    {
        $tiket = Tiket::findOrFail($id);

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => $tiket->status,
            'status_baru'     => 'diproses',

            'level_lama'      => $tiket->level_saat_ini,
            'level_baru'      => $tiket->level_saat_ini,

            'changed_by_tipe' => 'agen',
            'changed_by_id'   => 1, // sementara

            'catatan'         => 'Tiket mulai diproses',
            'waktu'           => now(),
        ]);

        $tiket->status = 'diproses';
        $tiket->save();     

        Notifikasi::create([
            'penerima_tipe' => 'mahasiswa',
            'id_penerima'   => $tiket->id_mahasiswa,
            'id_tiket'      => $tiket->id_tiket,
            'judul_notif'   => 'Tiket Diproses',
            'pesan'         => 'Tiket Anda sedang diproses oleh Agen Level 3.',
            'tipe_notif'    => 'status_berubah',
            'is_read'       => 0,
            'waktu'         => now(),
        ]);

        return back()->with('success','Tiket berhasil diproses.');
    }

    public function selesai($id)
   {
        $tiket = Tiket::findOrFail($id);

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => $tiket->status,
            'status_baru'     => 'selesai',

            'level_lama'      => $tiket->level_saat_ini,
            'level_baru'      => $tiket->level_saat_ini,

            'changed_by_tipe' => 'agen',
            'changed_by_id'   => 1, // sementara

            'catatan'         => 'Tiket selesai',
            'waktu'           => now(),
        ]);

        $tiket->status = 'selesai';
        $tiket->closed_at = now();
        $tiket->save();

        Notifikasi::create([
            'penerima_tipe' => 'mahasiswa',
            'id_penerima'   => $tiket->id_mahasiswa,
            'id_tiket'      => $tiket->id_tiket,
            'judul_notif'   => 'Tiket Diselesaikan',
            'pesan'         => 'Tiket Anda telah berhasil diselesaikan oleh Agen Level 3.',
            'tipe_notif'    => 'status_berubah',
            'is_read'       => 0,
            'waktu'         => now(),
        ]);

        return back()->with('success', 'Tiket berhasil diselesaikan.');
    }

    public function komentar(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required'
        ]);

        $tiket = Tiket::findOrFail($id);

        Komentar::create([
            'id_tiket'       => $tiket->id_tiket,
            'pengirim_tipe'  => 'agen',
            'id_pengirim'    => 1, // sementara
            'pesan'          => $request->pesan,
            'lampiran'       => null,
            'waktu_kirim'    => now(),
            'is_internal'    => 0,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }
}
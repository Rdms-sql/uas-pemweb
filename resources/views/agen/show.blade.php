<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Notifikasi;
use App\Models\LogStatusTiket;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenDashboardController extends Controller
{
    // Method untuk menampilkan halaman utama dashboard agen
    public function index()
    {
        $tikets = Tiket::where('id_agen', Auth::guard('agen')->id())
                        ->orWhereNull('id_agen')
                        ->get();
                        
        return view('agen.dashboard', compact('tikets'));
    }

    // METHOD SHOW: Sudah diperbaiki untuk mengambil data $komentars agar tidak error
    public function show($id)
    {
        $tiket = Tiket::with(['mahasiswa', 'kategori', 'agen'])->findOrFail($id);
        
        $komentars = Komentar::where('id_tiket', $id)
                              ->orderBy('waktu_kirim', 'asc')
                              ->get();

        return view('agen.tiket.show', compact('tiket', 'komentars'));
    }

    // Method untuk mengambil dan memproses tiket
    public function proses($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->id_agen = Auth::guard('agen')->id();
        $tiket->status = 'diproses';
        $tiket->save();

        return back()->with('success', 'Tiket berhasil diproses.');
    }

    // Method untuk menambah komentar/balasan di tiket
    public function komentar(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string',
        ]);

        Komentar::create([
            'id_tiket'      => $id,
            'pengirim_tipe' => 'agen',
            'id_pengirim'   => Auth::guard('agen')->id(),
            'pesan'         => $request->pesan,
            'waktu_kirim'   => now(),
            'is_internal'   => 0,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    // STEP 4: Method Eskalasi Tiket
    public function eskalasi(Request $request, $id)
    {
        $agen  = Auth::guard('agen')->user();
        $tiket = Tiket::findOrFail($id);

        $request->validate([
            'level_tujuan' => 'required|in:2,3',
            'alasan_eskalasi' => 'required|string',
        ]);

        $levelLama  = $tiket->level_saat_ini;
        $levelBaru  = $request->level_tujuan;
        $statusBaru = $levelBaru == '2' ? 'dieskalasi_l2' : 'dieskalasi_l3';

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => $tiket->status,
            'status_baru'     => $statusBaru,
            'level_lama'      => $levelLama,
            'level_baru'      => $levelBaru,
            'changed_by_tipe' => 'agen',
            'changed_by_id'   => $agen->id_agen,
            'catatan'         => $request->alasan_eskalasi,
            'waktu'           => now(),
        ]);

        $tiket->level_saat_ini = $levelBaru;
        $tiket->status = $statusBaru;
        $tiket->id_agen = null;
        $tiket->save();

        Komentar::create([
            'id_tiket'      => $tiket->id_tiket,
            'pengirim_tipe' => 'agen',
            'id_pengirim'   => $agen->id_agen,
            'pesan'         => 'Tiket dieskalasi ke Level ' . $levelBaru . '. Alasan: ' . $request->alasan_eskalasi,
            'lampiran'      => null,
            'waktu_kirim'   => now(),
            'is_internal'   => 1,
        ]);

        Notifikasi::create([
            'penerima_tipe' => 'mahasiswa',
            'id_penerima'   => $tiket->id_mahasiswa,
            'id_tiket'      => $tiket->id_tiket,
            'judul_notif'   => 'Tiket Dieskalasi',
            'pesan'         => 'Tiket Anda dieskalasi ke Level ' . $levelBaru . ' untuk penanganan lebih lanjut.',
            'tipe_notif'    => 'status_berubah',
            'is_read'       => 0,
            'waktu'         => now(),
        ]);

        return redirect()->route('agen.dashboard')->with('success', 'Tiket berhasil dieskalasi ke Level ' . $levelBaru);
    }

    // STEP 5: Method Selesaikan / Tutup Tiket
    public function selesai($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->status = 'selesai';
        $tiket->save();

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => 'diproses',
            'status_baru'     => 'selesai',
            'level_lama'      => $tiket->level_saat_ini,
            'level_baru'      => $tiket->level_saat_ini,
            'changed_by_tipe' => 'agen',
            'changed_by_id'   => Auth::guard('agen')->id(),
            'catatan'         => 'Tiket telah diselesaikan oleh agen.',
            'waktu'           => now(),
        ]);

        return back()->with('success', 'Tiket berhasil ditandai selesai.');
    }
}
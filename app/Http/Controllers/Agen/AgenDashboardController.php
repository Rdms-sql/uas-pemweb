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
    public function index()
    {
        $agen = Auth::guard('agen')->user();

        // Tiket yang belum ada agen-nya, sesuai level agen yang login
        $tiketBaru = Tiket::whereNull('id_agen')
            ->whereIn('status', ['baru', 'menunggu_penugasan'])
            ->where('level_saat_ini', $agen->level_agen)
            ->latest()
            ->get();

        // Tiket yang lagi dipegang agen ini
        $tiketSaya = Tiket::where('id_agen', $agen->id_agen)
            ->whereNotIn('status', ['selesai', 'ditutup', 'dibatalkan'])
            ->latest()
            ->get();

        // Statistik ringkas buat kartu di dashboard
        $total    = Tiket::where('level_saat_ini', $agen->level_agen)->count();
        $pending  = Tiket::where('level_saat_ini', $agen->level_agen)->where('status', 'baru')->count();
        $diproses = Tiket::where('level_saat_ini', $agen->level_agen)->where('status', 'diproses')->count();
        $selesai  = Tiket::where('level_saat_ini', $agen->level_agen)->where('status', 'selesai')->count();

        return view('agen.dashboard', compact(
            'tiketBaru', 'tiketSaya', 'total', 'pending', 'diproses', 'selesai'
        ));
    }

    public function show($id)
    {
        $tiket = Tiket::with(['mahasiswa', 'agen', 'kategori'])
            ->findOrFail($id);

        $komentars = Komentar::where('id_tiket', $id)
            ->orderBy('waktu_kirim', 'asc')
            ->get();

        return view('agen.tiket.show', compact('tiket', 'komentars'));
    }

    public function proses($id)
    {
        $agen  = Auth::guard('agen')->user();
        $tiket = Tiket::findOrFail($id);

        // Kalau tiket belum ada agen-nya, ambil otomatis jadi milik agen ini
        if (is_null($tiket->id_agen)) {
            $tiket->id_agen = $agen->id_agen;
        }

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => $tiket->status,
            'status_baru'     => 'diproses',
            'level_lama'      => $tiket->level_saat_ini,
            'level_baru'      => $tiket->level_saat_ini,
            'changed_by_tipe' => 'agen',
            'changed_by_id'   => $agen->id_agen,
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
            'pesan'         => 'Tiket Anda sedang diproses oleh Agen.',
            'tipe_notif'    => 'status_berubah',
            'is_read'       => 0,
            'waktu'         => now(),
        ]);

        return back()->with('success', 'Tiket berhasil diproses.');
    }

    public function selesai($id)
    {
        $agen  = Auth::guard('agen')->user();
        $tiket = Tiket::findOrFail($id);

        LogStatusTiket::create([
            'id_tiket'        => $tiket->id_tiket,
            'status_lama'     => $tiket->status,
            'status_baru'     => 'selesai',
            'level_lama'      => $tiket->level_saat_ini,
            'level_baru'      => $tiket->level_saat_ini,
            'changed_by_tipe' => 'agen',
            'changed_by_id'   => $agen->id_agen,
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
            'pesan'         => 'Tiket Anda telah berhasil diselesaikan.',
            'tipe_notif'    => 'status_berubah',
            'is_read'       => 0,
            'waktu'         => now(),
        ]);

        return back()->with('success', 'Tiket berhasil diselesaikan.');
    }

    public function komentar(Request $request, $id)
    {
        $agen = Auth::guard('agen')->user();

        $request->validate([
            'pesan' => 'required',
        ]);

        $tiket = Tiket::findOrFail($id);

        Komentar::create([
            'id_tiket'      => $tiket->id_tiket,
            'pengirim_tipe' => 'agen',
            'id_pengirim'   => $agen->id_agen,
            'pesan'         => $request->pesan,
            'lampiran'      => null,
            'waktu_kirim'   => now(),
            'is_internal'   => 0,
        ]);

  return back()->with('success', 'Komentar berhasil dikirim.');
    }

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
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', now()->format('Y-m'));

        $startDate = $periode . '-01';
        $endDate   = date('Y-m-t', strtotime($startDate));

        $tikets = Tiket::whereBetween('created_at', [$startDate, $endDate]);

        $data = [
            'periode'            => $periode,
            'total_tiket'        => (clone $tikets)->count(),
            'total_urgent'       => (clone $tikets)->where('is_urgent', true)->count(),
            'total_selesai'      => (clone $tikets)->where('status', 'selesai')->count(),
            'total_dibatalkan'   => (clone $tikets)->where('status', 'dibatalkan')->count(),
            'tiket_level1'       => (clone $tikets)->where('level_saat_ini', '1')->count(),
            'tiket_level2'       => (clone $tikets)->where('level_saat_ini', '2')->count(),
            'tiket_level3'       => (clone $tikets)->where('level_saat_ini', '3')->count(),
            'rata_rating'        => round((clone $tikets)->whereNotNull('rating')->avg('rating'), 1) ?? 0,
        ];

        $riwayat = Laporan::latest()->paginate(5);

        return view('admin.laporan.index', compact('data', 'riwayat'));
    }

    public function store(Request $request)
    {
        $periode   = $request->get('periode', now()->format('Y-m'));
        $startDate = $periode . '-01';
        $endDate   = date('Y-m-t', strtotime($startDate));

        $tikets = Tiket::whereBetween('created_at', [$startDate, $endDate]);

        Laporan::create([
            'id_admin'           => 1,
            'periode'            => $periode,
            'total_tiket'        => (clone $tikets)->count(),
            'total_tiket_urgent' => (clone $tikets)->where('is_urgent', true)->count(),
            'tiket_level1'       => (clone $tikets)->where('level_saat_ini', '1')->count(),
            'tiket_level2'       => (clone $tikets)->where('level_saat_ini', '2')->count(),
            'tiket_level3'       => (clone $tikets)->where('level_saat_ini', '3')->count(),
            'rata_sla_jam'       => 0,
            'rata_rating'        => round((clone $tikets)->whereNotNull('rating')->avg('rating'), 1) ?? 0,
            'tanggal_buat'       => now()->toDateString(),
        ]);

        return redirect()->route('admin.laporan')->with('success', 'Laporan berhasil disimpan');
    }
}
<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Tiket;

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

        return view('agen.tiket.show', compact('tiket'));
    }

    public function proses($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->status = 'diproses';

        $tiket->save();

        return redirect()
            ->route('agen.tiket.show', $id)
            ->with('success', 'Tiket berhasil diproses.');
    }

        public function selesai($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->status = 'selesai';
        $tiket->closed_at = now();

        $tiket->save();

        return back()->with('success', 'Tiket berhasil diselesaikan.');
    }
}
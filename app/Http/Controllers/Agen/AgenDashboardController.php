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
}
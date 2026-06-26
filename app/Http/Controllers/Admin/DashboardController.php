<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Mahasiswa;
use App\Models\Agen;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_tiket'   => Tiket::count(),
            'tiket_urgent'  => Tiket::where('is_urgent', true)->count(),
            'tiket_aktif'   => Tiket::whereNotIn('status', ['selesai','ditutup','dibatalkan'])->count(),
            'total_mahasiswa' => Mahasiswa::count(),
            'total_agen'    => Agen::count(),
        ];

        return view('admin.dashboard', $data);
    }
}
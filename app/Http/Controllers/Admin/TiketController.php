<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;

class TiketController extends Controller
{
    public function index()
    {
        $tikets = Tiket::with(['mahasiswa', 'agen', 'kategori'])
                       ->latest()
                       ->paginate(10);

        return view('admin.tiket.index', compact('tikets'));
    }

    public function show(int $id)
    {
        $tiket = Tiket::with(['mahasiswa', 'agen', 'kategori'])->findOrFail($id);
        return view('admin.tiket.show', compact('tiket'));
    }

    public function destroy(int $id)
    {
        Tiket::findOrFail($id)->delete();
        return redirect()->route('tiket.index')->with('success', 'Tiket berhasil dihapus');
    }
}
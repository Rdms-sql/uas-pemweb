<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'isi'   => 'required|string',
        ]);

        Pengumuman::create([
            'id_admin'  => 1,
            'judul'     => $request->judul,
            'isi'       => $request->isi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'isi'   => 'required|string',
        ]);

        Pengumuman::findOrFail($id)->update([
            'judul'     => $request->judul,
            'isi'       => $request->isi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function destroy(int $id)
    {
        Pengumuman::findOrFail($id)->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}
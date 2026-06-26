<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori'     => 'required|string|max:100',
            'deskripsi'         => 'nullable|string',
            'level_agen_default'=> 'required|in:1,2,3',
            'sla_jam_normal'    => 'required|integer|min:1',
            'sla_jam_urgent'    => 'required|integer|min:1',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama_kategori'     => 'required|string|max:100',
            'level_agen_default'=> 'required|in:1,2,3',
            'sla_jam_normal'    => 'required|integer|min:1',
            'sla_jam_urgent'    => 'required|integer|min:1',
        ]);

        Kategori::findOrFail($id)->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(int $id)
    {
        Kategori::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
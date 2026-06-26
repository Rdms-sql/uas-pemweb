<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::latest()->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function edit(int $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, int $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->only([
            'nama','email','program_studi','semester','no_telepon'
        ]));
        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil diupdate');
    }

    public function destroy(int $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update(['is_active' => false]);
        return redirect()->route('mahasiswa.index')
                         ->with('success', 'Akun mahasiswa dinonaktifkan');
    }
}
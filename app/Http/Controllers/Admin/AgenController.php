<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgenController extends Controller
{
    public function index()
    {
        $agens = Agen::latest()->paginate(10);
        return view('admin.agen.index', compact('agens'));
    }

    public function create()
    {
        return view('admin.agen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|unique:agens,email',
            'password'   => 'required|min:6',
            'level_agen' => 'required|in:1,2,3',
            'unit_kerja' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        Agen::create([
            'nama'        => $request->nama,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'level_agen'  => $request->level_agen,
            'unit_kerja'  => $request->unit_kerja,
            'no_telepon'  => $request->no_telepon,
            'is_active'   => true,
            'is_verified' => true,
        ]);

        return redirect()->route('agen.index')->with('success', 'Agen berhasil ditambahkan');
    }

    public function selesai($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->status = 'selesai';
        $tiket->closed_at = now();
        $tiket->save();

        return back()->with('success', 'Tiket berhasil diselesaikan.');
    }

    public function edit(int $id)
    {
        $agen = Agen::findOrFail($id);
        return view('admin.agen.edit', compact('agen'));
    }

    public function update(Request $request, int $id)
    {
        $agen = Agen::findOrFail($id);

        $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|unique:agens,email,' . $id . ',id_agen',
            'level_agen' => 'required|in:1,2,3',
            'unit_kerja' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $agen->update($request->only(['nama', 'email', 'level_agen', 'unit_kerja', 'no_telepon']));

        return redirect()->route('agen.index')->with('success', 'Data agen berhasil diupdate');
    }

    public function destroy(int $id)
    {
        $agen = Agen::findOrFail($id);
        $agen->update(['is_active' => false]);
        return redirect()->route('agen.index')->with('success', 'Agen dinonaktifkan');
    }
}
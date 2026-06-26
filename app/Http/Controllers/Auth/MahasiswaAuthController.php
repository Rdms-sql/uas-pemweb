<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MahasiswaAuthController extends Controller
{
    // =====================
    // REGISTER
    // =====================
    public function showRegister()
    {
        return view('auth.mahasiswa-register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:mahasiswas,email',
            'password'      => 'required|min:6|confirmed',
            'program_studi' => 'nullable|string|max:100',
            'no_telepon'    => 'nullable|string|max:20',
        ]);
    
        // Generate NIM otomatis
        $nim = $this->generateNim();
    
        Mahasiswa::create([
            'nim'           => $nim,
            'nama'          => $request->nama,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'program_studi' => $request->program_studi,
            'no_telepon'    => $request->no_telepon,
            'is_active'     => true,
        ]);
    
        return redirect('/mahasiswa/login')
               ->with('success', 'Akun berhasil dibuat! NIM kamu: ' . $nim . '. Silakan login.');
    }

// =====================
// GENERATE NIM UNIK
// =====================
private function generateNim(): string
{
    $prefix = now()->format('ymd'); // contoh: 260627

    // Cari NIM terakhir dengan prefix hari ini
    $last = Mahasiswa::where('nim', 'like', $prefix . '%')
                     ->orderBy('nim', 'desc')
                     ->first();

    if ($last) {
        // Ambil 2 digit terakhir (urutan) dan tambah 1
        $urutan = (int) substr($last->nim, 6) + 1;
    } else {
        $urutan = 1;
    }

    // Format urutan jadi 2 digit: 01, 02, ..., 99
    return $prefix . str_pad($urutan, 2, '0', STR_PAD_LEFT);
}

    // =====================
    // LOGIN
    // =====================
    public function showLogin()
    {
        return view('auth.mahasiswa-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('mahasiswa')->attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'is_active'=> true,
        ])) {
            $request->session()->regenerate();
            return redirect('/mahasiswa/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun tidak aktif.',
        ]);
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/mahasiswa/login');
    }
}
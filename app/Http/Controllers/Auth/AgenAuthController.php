<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agen;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AgenAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.agen-login');
    }

   public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $agen = Agen::where('email', $request->email)->first();

        if (!$agen) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.'
            ]);
        }

        if (!Hash::check($request->password, $agen->password)) {
            return back()->withErrors([
                'email' => 'Password salah.'
            ]);
        }

        Auth::guard('agen')->login($agen);

        $request->session()->regenerate();

        return redirect()->route('agen.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('agen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/agen/login');
    }
}
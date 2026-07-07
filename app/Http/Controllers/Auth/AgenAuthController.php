<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.agen-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('agen')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $agen = Auth::guard('agen')->user();

            if (!$agen->is_active) {
                Auth::guard('agen')->logout();
                return back()->withErrors([
                    'email' => 'Akun kamu tidak aktif. Hubungi admin.',
                ]);
            }

            return redirect()->intended(route('agen.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('agen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/agen/login');
    }
}
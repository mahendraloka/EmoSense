<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Coba login sebagai Mahasiswa (Prioritas utama EmoSense)
        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/mahasiswa/home');
        }

        // Coba login sebagai Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        // Coba login sebagai Psikolog
        if (Auth::guard('psikolog')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/psikolog/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }
}

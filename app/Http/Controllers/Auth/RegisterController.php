<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'nim'      => 'required|unique:mahasiswa',
            'email'    => 'required|email|unique:mahasiswa',
            'fakultas' => 'required',
            'prodi'    => 'required',
            'password' => 'required|min:6',
        ]);

        Mahasiswa::create([
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'email'    => $request->email,
            'fakultas' => $request->fakultas,
            'prodi'    => $request->prodi,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}

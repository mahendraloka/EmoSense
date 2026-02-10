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
            'nama'     => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'nim'      => 'required|unique:mahasiswa',
            'email'    => 'required|email|unique:mahasiswa',
            'fakultas' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'prodi'    => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'password' => 'required|min:6',
        ],
        [
            'nama.regex'     => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            'fakultas.regex' => 'Fakultas hanya boleh berisi huruf dan spasi.',
            'prodi.regex'    => 'Program studi hanya boleh berisi huruf dan spasi.',
        ]
        );

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

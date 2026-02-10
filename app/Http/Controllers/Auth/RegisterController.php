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
            'nim'      => 'required|unique:mahasiswa', // NIM juga harus unik
            'email'    => 'required|email|unique:mahasiswa,email', // Cek keunikan email
            'fakultas' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'prodi'    => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'password' => 'required|min:6',
        ],
        [
            'email.unique'   => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
            'nim.unique'     => 'NIM ini sudah terdaftar.',
            'nama.regex'     => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            'fakultas.regex' => 'Fakultas hanya boleh berisi huruf dan spasi.',
            'prodi.regex'    => 'Program studi hanya boleh berisi huruf dan spasi.',
        ]);

        // Jika validasi lolos, data akan disimpan
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

<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mahasiswa.profile.edit', [
            'mahasiswa' => Auth::guard('mahasiswa')->user()
        ]);
    }

    public function update(Request $request)
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|string|max:50|unique:mahasiswa,nim,' . $mahasiswa->id_Mahasiswa . ',id_Mahasiswa',
            'fakultas' => 'required|string',
            'prodi'    => 'required|string',
        ]);

        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->fakultas = $request->fakultas;
        $mahasiswa->prodi = $request->prodi;
        
        $mahasiswa->save();

        return back()->with('success', 'Informasi profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed|different:password_lama',
        ], [
            'password_baru.different' => 'Password baru harus berbeda dengan password lama.'
        ]);

        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Cek apakah password lama yang dimasukkan cocok dengan di database
        if (!Hash::check($request->password_lama, $mahasiswa->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah.']);
        }

        // Update password
        $mahasiswa->password = Hash::make($request->password_baru);
        $mahasiswa->save();

        // Logout dan Login kembali untuk menyegarkan session guard
        
        return back()->with('success', 'Password berhasil diperbarui. Silakan gunakan password baru Anda selanjutnya.');
    }
}
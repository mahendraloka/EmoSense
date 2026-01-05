<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil admin.
     */
    public function edit()
    {
        // Mengambil data admin yang sedang login melalui guard admin
        return view('admin.profile.edit', [
            'admin' => Auth::guard('admin')->user()
        ]);
    }

    /**
     * Memproses pembaruan data profil admin.
     */
    public function update(Request $request)
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            // 'confirmed' akan mencari input bernama password_confirmation
            'password' => 'nullable|min:6|confirmed', 
        ]);

        $admin->nama = $validated['nama'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', 'Profil administrator berhasil diperbarui');
    }
}
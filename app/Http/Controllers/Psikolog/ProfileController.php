<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Psikolog;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('psikolog.profile.edit', [
            'psikolog' => Auth::guard('psikolog')->user()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'nomor_hp'     => 'required|string|max:20',
            'spesialisasi' => 'required|string|max:255',
            'foto_profil'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'     => 'nullable|min:6|confirmed',
        ]);

        /** @var Psikolog $psikolog */
        $psikolog = Auth::guard('psikolog')->user();

        // UPDATE DATA UTAMA
        $psikolog->nama         = $validated['nama'];
        $psikolog->nomor_hp     = $validated['nomor_hp'];
        $psikolog->spesialisasi = $validated['spesialisasi'];

        // UPDATE PASSWORD (OPSIONAL)
        if (!empty($validated['password'])) {
            $psikolog->password = Hash::make($validated['password']);
        }

        // UPDATE FOTO PROFIL
        if ($request->hasFile('foto_profil')) {

            // hapus foto lama
            if ($psikolog->foto_profil) {
                Storage::disk('public')->delete($psikolog->foto_profil);
            }

            // simpan foto baru (path: psikolog/namafile.jpg)
            $psikolog->foto_profil = $request->file('foto_profil')
                ->store('psikolog', 'public');
        }

        $psikolog->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}

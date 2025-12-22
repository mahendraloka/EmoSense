<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Artikel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('konten', 'LIKE', "%{$search}%");
            });
        }

        $artikels = $query->orderBy('tanggal_upload', 'DESC')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.artikel.index', compact('artikels', 'search'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string',
            'konten'   => 'required|string',
            'kategori' => 'required|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate ID manual
        $last = Artikel::orderBy('id_Artikel', 'DESC')->first();
        $nextId = 'ART001';

        if ($last) {
            $num = (int) substr($last->id_Artikel, 3) + 1;
            $nextId = 'ART' . str_pad($num, 3, '0', STR_PAD_LEFT);
        }

        $data = [
            'id_Artikel'       => $nextId,
            'Admin_id_Admin'   => auth()->guard('admin')->id(),
            'judul'            => $request->judul,
            'konten'           => $request->konten,
            'kategori'         => $request->kategori,
            'tanggal_upload'   => now()->format('Y-m-d'),
        ];

        // ✅ SIMPAN GAMBAR JIKA ADA
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                                      ->store('artikel', 'public');
        }

        Artikel::create($data);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string',
            'konten'   => 'required|string',
            'kategori' => 'required|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'judul'    => $request->judul,
            'konten'   => $request->konten,
            'kategori' => $request->kategori,
        ];

        // ✅ JIKA GANTI GAMBAR
        if ($request->hasFile('gambar')) {

            // ⛔ hapus gambar lama
            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            // ✅ simpan gambar baru
            $data['gambar'] = $request->file('gambar')
                                      ->store('artikel', 'public');
        }

        $artikel->update($data);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // ⛔ hapus gambar jika ada
        if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}

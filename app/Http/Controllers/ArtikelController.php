<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // Tampilkan semua artikel
    public function index(Request $request)
    {
        $search = $request->input('search');
        $artikels = Artikel::when($search, function ($query) use ($search) {
            $query->where('judul', 'LIKE', "%{$search}%")
                ->orWhere('konten', 'LIKE', "%{$search}%");
        })
        ->orderBy('tanggal_upload', 'DESC')
        ->get();

        return view('mahasiswa.artikel.index', compact('artikels', 'search'));
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);

        return view('mahasiswa.artikel.show', compact('artikel'));
    }
}

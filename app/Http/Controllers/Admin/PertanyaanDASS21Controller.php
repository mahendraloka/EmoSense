<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PertanyaanDASS21;

class PertanyaanDASS21Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pertanyaans = PertanyaanDASS21::when($search, function ($q) use ($search) {
                $q->where('teks_pertanyaan', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%");
            })
            ->orderBy('urutan')
            ->paginate(10);

        $totalPertanyaan = PertanyaanDASS21::count();

        return view('admin.pertanyaan.index', compact('pertanyaans', 'search', 'totalPertanyaan'));
    }

    public function create()
    {
        if (PertanyaanDASS21::count() >= 21) {
            return redirect()
                ->route('admin.pertanyaan.index')
                ->with('error', 'Jumlah pertanyaan DASS-21 harus tepat 21.');
        }

        return view('admin.pertanyaan.create');
    }

    public function store(Request $request)
    {
        if (PertanyaanDASS21::count() >= 21) {
            return back()->with('error', 'Jumlah pertanyaan DASS-21 harus tepat 21.');
        }

        $request->validate([
            'urutan' => 'required|integer|between:1,21|unique:pertanyaan_dass21,urutan',
            'teks_pertanyaan' => 'required|string',
            'kategori' => 'required|in:Stress,Anxiety,Depression',
        ]);

        PertanyaanDASS21::create($request->all());

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pertanyaan = PertanyaanDASS21::findOrFail($id);
        return view('admin.pertanyaan.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = PertanyaanDASS21::findOrFail($id);

        $request->validate([
            'urutan' => 'required|integer|between:1,21|unique:pertanyaan_dass21,urutan,' . $id . ',id_Pertanyaan',
            'teks_pertanyaan' => 'required|string',
            'kategori' => 'required|in:Stress,Anxiety,Depression',
        ]);

        $pertanyaan->urutan = $request->urutan;
        $pertanyaan->teks_pertanyaan = $request->teks_pertanyaan;
        $pertanyaan->kategori = $request->kategori;
        $pertanyaan->save();

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pertanyaan = PertanyaanDASS21::findOrFail($id);

        // Hitung jumlah item pada kategori yang akan dihapus
        $jumlahKategori = PertanyaanDASS21::where('kategori', $pertanyaan->kategori)->count();

        $pertanyaan->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}

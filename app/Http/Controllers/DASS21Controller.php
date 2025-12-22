<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanDASS21;
use App\Models\HasilDASS21;
use Illuminate\Support\Facades\Auth;

class DASS21Controller extends Controller
{
    // Menampilkan form pertanyaan
    public function index()
    {
        $pertanyaan = PertanyaanDASS21::all();
        return view('self_assessment.dass21', compact('pertanyaan'));
    }

    // Menyimpan jawaban dan menghitung skor
    public function store(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array'
        ]);

        $jawaban = $request->jawaban;

        // Hitung skor berdasarkan kategori pertanyaan
        $skorDepresi = $this->hitungSkor($jawaban, 'Depression');
        $skorAnxiety = $this->hitungSkor($jawaban, 'Anxiety');
        $skorStress = $this->hitungSkor($jawaban, 'Stress');

        // Tentukan level berdasarkan skor
        $levelDepresi = $this->kategoriDepresi($skorDepresi);
        $levelAnxiety = $this->kategoriAnxiety($skorAnxiety);
        $levelStress = $this->kategoriStress($skorStress);

        // Simpan hasil ke database
        $hasil = HasilDASS21::create([
            'Mahasiswa_id_Mahasiswa' => Auth::user()->id,
            'tanggal_test' => now(),
            'skor_depresi' => $skorDepresi,
            'skor_anxiety' => $skorAnxiety,
            'skor_stress' => $skorStress,
            'tingkat_depresi' => $levelDepresi,
            'tingkat_anxiety' => $levelAnxiety,
            'tingkat_stress' => $levelStress,
        ]);

        return redirect()->route('hasil.show', $hasil->id_Hasil)
                         ->with('success', 'Tes berhasil disimpan!');
    }

    // Menampilkan hasil tes berdasarkan ID hasil
    public function show($id)
    {
        $hasil = HasilDASS21::findOrFail($id);
        return view('hasil.hasil_dass', compact('hasil'));
    }

    // ==============================
    // FUNCTION PENDUKUNG
    // ==============================

    private function hitungSkor($jawaban, $kategori)
    {
        $pertanyaan = PertanyaanDASS21::where('kategori', $kategori)->get();
        $skor = 0;

        foreach ($pertanyaan as $q) {
            if (isset($jawaban[$q->id_Pertanyaan])) {
                $skor += intval($jawaban[$q->id_Pertanyaan]);
            }
        }

        return $skor;
    }

    private function kategoriDepresi($skor)
    {
        return match (true) {
            $skor >= 0 && $skor <= 4 => "Normal",
            $skor <= 6 => "Ringan",
            $skor <= 10 => "Sedang",
            $skor <= 13 => "Berat",
            default => "Sangat Berat"
        };
    }

    private function kategoriAnxiety($skor)
    {
        return match (true) {
            $skor >= 0 && $skor <= 3 => "Normal",
            $skor <= 5 => "Ringan",
            $skor <= 7 => "Sedang",
            $skor <= 9 => "Berat",
            default => "Sangat Berat"
        };
    }

    private function kategoriStress($skor)
    {
        return match (true) {
            $skor >= 0 && $skor <= 7 => "Normal",
            $skor <= 9 => "Ringan",
            $skor <= 12 => "Sedang",
            $skor <= 15 => "Berat",
            default => "Sangat Berat"
        };
    }
}

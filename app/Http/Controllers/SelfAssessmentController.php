<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PertanyaanDASS21;
use App\Models\HasilDASS21;

class SelfAssessmentController extends Controller
{
    public function index()
    {
        // Validasi struktur DASS-21
        $strukturValid =
            PertanyaanDASS21::count() === 21 &&
            PertanyaanDASS21::where('kategori', 'Stress')->count() === 7 &&
            PertanyaanDASS21::where('kategori', 'Anxiety')->count() === 7 &&
            PertanyaanDASS21::where('kategori', 'Depression')->count() === 7;

        if (! $strukturValid) {
            abort(500, 'Instrumen DASS-21 belum lengkap atau tidak valid.');
        }

        $questions = PertanyaanDASS21::orderBy('urutan')->get();

        return view('mahasiswa.selfassessment', compact('questions'));
    }

    public function store(Request $request)
    {
        $answers = $request->input('answers', []);

        // Pastikan semua item baku terjawab
        $jumlahPertanyaan = PertanyaanDASS21::count();

        if (count($answers) !== $jumlahPertanyaan) {
            return back()->with('error', 'Semua pertanyaan harus dijawab.');
        }

        $skorDepresi = $this->calculateScore($answers, 'Depression');
        $skorAnxiety = $this->calculateScore($answers, 'Anxiety');
        $skorStress  = $this->calculateScore($answers, 'Stress');

        $hasil = HasilDASS21::create([
            'Mahasiswa_id_Mahasiswa' => Auth::guard('mahasiswa')->id(),
            'tanggal_test' => now(),
            'skor_depresi' => $skorDepresi * 2,
            'skor_anxiety' => $skorAnxiety * 2,
            'skor_stress' => $skorStress * 2,
            'tingkat_depresi' => $this->getLevel('Depression', $skorDepresi * 2),
            'tingkat_anxiety' => $this->getLevel('Anxiety', $skorAnxiety * 2),
            'tingkat_stress' => $this->getLevel('Stress', $skorStress * 2),
            'daftar_jawaban' => $answers,
        ]);

        return redirect()
        ->route('selfassessment.result', $hasil->id_Hasil)
        ->with('success', 'Self Assessment berhasil disimpan!');
    }

    public function result($id)
    {
        $hasil = HasilDASS21::findOrFail($id);
        // Ambil saran berdasarkan tingkat masing-masing kategori
        $saranDepresi = $this->getSaran($hasil->tingkat_depresi);
        $saranAnxiety = $this->getSaran($hasil->tingkat_anxiety);
        $saranStress  = $this->getSaran($hasil->tingkat_stress);

        // Kirim semua variabel ke view
        return view('hasil.hasil_dass21', compact('hasil', 'saranDepresi', 'saranAnxiety', 'saranStress'));
    }


    private function calculateScore(array $answers, string $kategori)
    {
        return PertanyaanDASS21::where('kategori', $kategori)
            ->get()
            ->sum(fn($q) => isset($answers[$q->id_Pertanyaan]) ? (int)$answers[$q->id_Pertanyaan] : 0);
    }

    private function getLevel(string $kategori, int $score)
    {
        $ranges = [
            'Depression' => [
                'Normal' => [0, 9],
                'Ringan' => [10, 13],
                'Sedang' => [14, 20],
                'Berat' => [21, 27],
                'Sangat Berat' => [28, 42],
            ],
            'Anxiety' => [
                'Normal' => [0, 7],
                'Ringan' => [8, 9],
                'Sedang' => [10, 14],
                'Berat' => [15, 19],
                'Sangat Berat' => [20, 42],
            ],
            'Stress' => [
                'Normal' => [0, 14],
                'Ringan' => [15, 18],
                'Sedang' => [19, 25],
                'Berat' => [26, 33],
                'Sangat Berat' => [34, 42],
            ],
        ];

        foreach ($ranges[$kategori] as $level => [$min, $max]) {
            if ($score >= $min && $score <= $max) {
                return $level;
            }
        }

        return 'Tidak Diketahui';
    }

    private function getSaran($level)
    {
        $saran = [
            'Normal' => 'Tetap jaga keseimbangan aktivitas dan kesehatan mental Anda.',
            'Ringan' => 'Kondisi ini masih umum dialami banyak orang, namun tetap penting untuk memperhatikan kebutuhan diri dan mengelola stres dengan baik.',
            'Sedang' => 'Disarankan untuk mulai mempertimbangkan strategi coping yang lebih aktif atau berbicara dengan orang tepercaya.',
            'Berat'  => 'Disarankan untuk mempertimbangkan mencari bantuan profesional agar mendapatkan dukungan yang sesuai.',
            'Sangat Berat' => 'Sangat disarankan untuk segera menghubungi tenaga profesional atau layanan bantuan yang tersedia untuk mendapatkan penanganan lebih lanjut.',
        ];

        return $saran[$level] ?? 'Tetap perhatikan kondisi kesehatan mental Anda.';
    }
}

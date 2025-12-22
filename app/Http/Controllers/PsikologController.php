<?php

namespace App\Http\Controllers;

use App\Models\Psikolog;
use App\Models\Mahasiswa;
use App\Models\MoodTracker;
use App\Models\HasilDASS21;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PsikologController extends Controller
{
    public function index()
    {
        $psikolog = Psikolog::orderBy('nama')->get();
        return view('psikolog.index', compact('psikolog'));
    }

    public function dashboard()
    {
        // =====================
        // STATISTIK RINGKAS
        // =====================
        $totalMahasiswa = Mahasiswa::count();

        // Ambil hasil DASS-21 TERAKHIR tiap mahasiswa
        $hasilTerakhir = HasilDASS21::select('hasil_dass21.*')
            ->join(DB::raw('(
                SELECT Mahasiswa_id_Mahasiswa, MAX(tanggal_test) as max_date
                FROM hasil_dass21
                GROUP BY Mahasiswa_id_Mahasiswa
            ) as latest'), function ($join) {
                $join->on('hasil_dass21.Mahasiswa_id_Mahasiswa', '=', 'latest.Mahasiswa_id_Mahasiswa')
                     ->on('hasil_dass21.tanggal_test', '=', 'latest.max_date');
            })
            ->get();

        // Jumlah mahasiswa berisiko (minimal 1 dimensi sedang ke atas)
        $dassTinggi = $hasilTerakhir->filter(function ($item) {
            return in_array($item->tingkat_depresi, ['Sedang','Berat','Sangat Berat'])
                || in_array($item->tingkat_anxiety, ['Sedang','Berat','Sangat Berat'])
                || in_array($item->tingkat_stress, ['Sedang','Berat','Sangat Berat']);
        })->count();

        $rataMood = MoodTracker::where('tanggal_input', '>=', now()->subDays(7))
            ->avg('tingkat_mood');

        $totalAssessmentHariIni = HasilDASS21::whereDate('tanggal_test', now())->count();

        // =====================
        // CHART ATAS
        // =====================
        // Distribusi Tingkat Depresi
        // (1 mahasiswa = 1 data karena pakai hasil terakhir)
        $dassDepresi = $hasilTerakhir
            ->groupBy('tingkat_depresi')
            ->map(fn ($items) => $items->count());

        // Tren Mood
        $trendMood = MoodTracker::selectRaw('DATE(tanggal_input) as tanggal')
            ->selectRaw('AVG(tingkat_mood) as rata_mood')
            ->where('tanggal_input', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // =====================
        // CHART BAWAH
        // 1 mahasiswa = 1 DIMENSI DOMINAN
        // =====================

        $levelMap = [
            'Normal' => 0,
            'Ringan' => 1,
            'Sedang' => 2,
            'Berat' => 3,
            'Sangat Berat' => 4,
        ];

        $dimensiDominan = $hasilTerakhir->map(function ($item) use ($levelMap) {

            $nilai = [
                'Depresi' => $levelMap[$item->tingkat_depresi] ?? 0,
                'Anxiety' => $levelMap[$item->tingkat_anxiety] ?? 0,
                'Stress'  => $levelMap[$item->tingkat_stress] ?? 0,
            ];

            $max = max($nilai);
            if ($max === 0) {
                return 'Normal/Sehat';
            }
        
            return collect($nilai)
                ->filter(fn ($v) => $v === $max)
                ->keys()
                ->first();
        });

        $risikoKategori = $dimensiDominan
            ->countBy()
            ->toArray();

        return view('psikolog.dashboard', compact(
            'totalMahasiswa',
            'dassTinggi',
            'rataMood',
            'totalAssessmentHariIni',
            'dassDepresi',
            'trendMood',
            'risikoKategori'
        ));
    }

    public function mahasiswaIndex(Request $request)
    {
        $search = $request->query('search');

        $mahasiswa = Mahasiswa::with(['moodTerakhir', 'dassTerakhir'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('nim', 'LIKE', "%{$search}%")
                      ->orWhere('fakultas', 'LIKE', "%{$search}%")
                      ->orWhere('prodi', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('psikolog.mahasiswa.index', compact('mahasiswa', 'search'));
    }

    public function mahasiswaDetail($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // UBAH 'asc' MENJADI 'desc' agar data terbaru di atas
        $riwayatMood = $mahasiswa->moodTracker()
            ->orderBy('created_at', 'desc') 
            ->get();

        // Untuk grafik tren, kita tetap gunakan urutan waktu (asc) agar garis mengalir dari kiri ke kanan
        $trendMood = $mahasiswa->moodTracker()
            ->orderBy('created_at', 'asc')
            ->limit(30)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => \Carbon\Carbon::parse($item->created_at)->format('d M'),
                    'mood'    => $item->tingkat_mood,
                ];
            });

        $hasilDASS = $mahasiswa->dassTerakhir;

        return view('psikolog.mahasiswa.detail', compact(
            'mahasiswa',
            'riwayatMood',
            'hasilDASS',
            'trendMood'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MoodTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodTrackerController extends Controller
{
    public function index()
    {
        $user = Auth::guard('mahasiswa')->user();

        // RIWAYAT
        $history = MoodTracker::where('Mahasiswa_id_Mahasiswa', $user->id_Mahasiswa)
            ->orderBy('created_at', 'DESC')
            ->get();

        // GRAFIK
        $chartData = MoodTracker::where('Mahasiswa_id_Mahasiswa', $user->id_Mahasiswa)
            ->whereNotNull('tanggal_input') // ⬅️ PENTING
            ->selectRaw('DATE(tanggal_input) as tanggal, AVG(tingkat_mood) as avg_mood')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $chartLabels = $chartData->map(function ($item) {
            return Carbon::parse($item->tanggal)->format('d M');
        })->toArray();

        $chartValues = $chartData->map(function ($item) {
            return round($item->avg_mood, 1);
        })->toArray();

        return view('mahasiswa.moodtracker', compact(
            'history',
            'chartLabels',
            'chartValues'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat_mood' => 'required|integer|min:1|max:5',
            'catatan_harian' => 'nullable|string|max:500',
        ]);

        $user = Auth::guard('mahasiswa')->user();

        MoodTracker::create([
            'id_Mood' => 'M' . uniqid(),
            'Mahasiswa_id_Mahasiswa' => $user->id_Mahasiswa,
            'tanggal_input' => now()->toDateString(), // TETAP
            'tingkat_mood' => $request->tingkat_mood,
            'catatan_harian' => $request->catatan_harian,
        ]);

        return back()->with('success', 'Mood berhasil dicatat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat_mood' => 'required|integer|min:1|max:5',
            'catatan_harian' => 'nullable|string|max:500',
        ]);

        $mood = MoodTracker::where('id_Mood', $id)->firstOrFail();

        if ($mood->Mahasiswa_id_Mahasiswa !== Auth::guard('mahasiswa')->id()) {
            abort(403);
        }

        $mood->update([
            'tingkat_mood' => $request->tingkat_mood,
            'catatan_harian' => $request->catatan_harian,
        ]);

        return back()->with('success', 'Mood berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mood = MoodTracker::where('id_Mood', $id)->firstOrFail();

        if ($mood->Mahasiswa_id_Mahasiswa !== Auth::guard('mahasiswa')->id()) {
            abort(403);
        }

        $mood->delete();

        return back()->with('success', 'Mood berhasil dihapus.');
    }
}

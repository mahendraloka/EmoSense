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
            ->latest()
            ->get();

        // GRAFIK
        $chartData = MoodTracker::where('Mahasiswa_id_Mahasiswa', $user->id_Mahasiswa)
        ->orderBy('created_at', 'ASC')
        ->get();

        $chartLabels = $chartData->map(function ($item) {
            return Carbon::parse($item->created_at)
                ->format('d M H:i');
        })->toArray();

        $chartValues = $chartData->map(function ($item) {
            return (int) $item->tingkat_mood;
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

        if ($mood->Mahasiswa_id_Mahasiswa != Auth::guard('mahasiswa')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
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

        if ($mood->Mahasiswa_id_Mahasiswa != Auth::guard('mahasiswa')->id()) {
            abort(403);
        }

        $mood->delete();

        return back()->with('success', 'Mood berhasil dihapus.');
    }
}

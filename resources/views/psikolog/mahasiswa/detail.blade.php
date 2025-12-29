@extends('psikolog.layouts.master')

@section('title', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@section('content')
<div class="max-w-6xl mx-auto space-y-6 md:space-y-8 pb-12">
    
    {{-- HEADER & NAVIGATION --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-4 md:gap-5">
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-[1.5rem] md:rounded-[2rem] bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white text-2xl md:text-3xl font-black shadow-xl shadow-green-200 flex-shrink-0 border-4 border-white">
                {{ substr($mahasiswa->nama, 0, 1) }}
            </div>
            <div class="min-w-0">
                <nav class="flex mb-1 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                    <a href="{{ route('psikolog.mahasiswa.index') }}" class="hover:text-green-500 transition">Mahasiswa</a>
                    <span class="mx-2">/</span>
                    <span class="text-green-600">Detail</span>
                </nav>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight truncate leading-tight">{{ $mahasiswa->nama }}</h1>
                <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    {{ $mahasiswa->nim }}
                </p>
            </div>
        </div>

        <a href="{{ route('psikolog.mahasiswa.index') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 md:py-3.5 rounded-2xl bg-white text-gray-600 font-bold shadow-sm border border-gray-100 hover:bg-gray-50 transition-all active:scale-95 w-full md:w-auto text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    {{-- GRID ATAS: INFO & ASSESSMENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        {{-- INFORMASI AKADEMIK --}}
        <div class="bg-white rounded-[2.5rem] p-6 md:p-8 shadow-sm border border-gray-100">
            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Data Akademik
            </h3>
            
            <div class="space-y-5">
                <div>
                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">Program Studi</label>
                    <p class="font-bold text-gray-800 text-sm md:text-base leading-tight">{{ $mahasiswa->prodi }}</p>
                </div>
                <div class="border-t border-gray-50 pt-4">
                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">Fakultas</label>
                    <p class="font-bold text-gray-800 text-sm md:text-base leading-tight">{{ $mahasiswa->fakultas }}</p>
                </div>
                <div class="border-t border-gray-50 pt-4">
                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">Email</label>
                    <p class="font-bold text-gray-800 truncate text-xs italic">{{ $mahasiswa->email }}</p>
                </div>
            </div>
        </div>

        {{-- ASSESSMENT DASS-21 --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-6 md:p-8 shadow-sm border border-gray-100 relative overflow-hidden">
            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-rose-500 rounded-full"></span> Assessment Terakhir
            </h3>

            @if($hasilDASS)
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4">
                    <div class="bg-slate-900 rounded-2xl md:rounded-3xl p-4 text-center shadow-lg flex flex-col justify-center">
                        <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase mb-1">Total Skor</p>
                        <p class="text-2xl md:text-3xl font-black text-white italic">{{ $hasilDASS->skor_depresi + $hasilDASS->skor_anxiety + $hasilDASS->skor_stress }}</p>
                    </div>
                    <div class="bg-blue-50/50 rounded-2xl md:rounded-3xl p-3 md:p-4 text-center border border-blue-100">
                        <p class="text-[8px] md:text-[9px] font-black text-blue-400 uppercase mb-1">Depresi</p>
                        <p class="text-lg md:text-xl font-black text-blue-600">{{ $hasilDASS->skor_depresi }}</p>
                        <span class="text-[8px] font-black uppercase text-blue-700 block mt-1">{{ $hasilDASS->tingkat_depresi }}</span>
                    </div>
                    <div class="bg-amber-50/50 rounded-2xl md:rounded-3xl p-3 md:p-4 text-center border border-amber-100">
                        <p class="text-[8px] md:text-[9px] font-black text-amber-400 uppercase mb-1">Cemas</p>
                        <p class="text-lg md:text-xl font-black text-amber-600">{{ $hasilDASS->skor_anxiety }}</p>
                        <span class="text-[8px] font-black uppercase text-amber-700 block mt-1">{{ $hasilDASS->tingkat_anxiety }}</span>
                    </div>
                    <div class="bg-rose-50/50 rounded-2xl md:rounded-3xl p-3 md:p-4 text-center border border-rose-100">
                        <p class="text-[8px] md:text-[9px] font-black text-rose-400 uppercase mb-1">Stres</p>
                        <p class="text-lg md:text-xl font-black text-rose-600">{{ $hasilDASS->skor_stress }}</p>
                        <span class="text-[8px] font-black uppercase text-rose-700 block mt-1">{{ $hasilDASS->tingkat_stress }}</span>
                    </div>
                </div>
                <p class="mt-6 text-[10px] font-bold text-gray-400 italic">Diselesaikan pada: {{ $hasilDASS->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
            @else
                <div class="py-12 text-center bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest italic">Assessment belum diisi</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Letakkan di bawah informasi skor DASS --}}
    <div class="mt-8 bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
        <h3 class="text-sm font-black uppercase tracking-widest text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Audit Jawaban Per Item
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase">
                        <th class="px-4 py-3 w-12 text-center">No</th>
                        <th class="px-4 py-3">Pertanyaan DASS-21</th>
                        <th class="px-4 py-3 text-center">Skor Mhs</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        // Ambil semua pertanyaan dari tabel pertanyaan_dass21
                        $semuaPertanyaan = \App\Models\PertanyaanDASS21::orderBy('urutan')->get();
                        $jawabanMhs = $hasilDASS->daftar_jawaban ?? [];
                    @endphp

                    @foreach($semuaPertanyaan as $index => $q)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-4 py-3 text-center text-xs font-bold text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-medium">{{ $q->teks_pertanyaan }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg {{ isset($jawabanMhs[$q->id_Pertanyaan]) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-300' }} font-black text-xs">
                                {{ $jawabanMhs[$q->id_Pertanyaan] ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- GRAFIK TREN MOOD --}}
    <div class="bg-white rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-sm border border-gray-100">
        <h3 class="text-xl font-black text-gray-800 tracking-tight mb-8 md:mb-10">Tren Emosi Harian</h3>
        <div class="h-[300px] md:h-[400px] w-full">
            @if($trendMood->count())
                <canvas id="moodChart"></canvas>
            @else
                <div class="h-full flex items-center justify-center bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-gray-400 font-bold text-[10px] uppercase tracking-[0.2em]">Data mood belum mencukupi</p>
                </div>
            @endif
        </div>
    </div>

    {{-- RIWAYAT MOODTRACKER --}}
    <div class="bg-white rounded-[2.5rem] md:rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-10 border-b border-gray-50 bg-gradient-to-r from-white to-gray-50/30">
            <h3 class="text-lg md:text-xl font-black text-gray-800 tracking-tight text-center md:text-left">Riwayat Mood Tracker</h3>
        </div>
        
        {{-- TAMPILAN DESKTOP (TABLE) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left table-fixed">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest w-48 text-center">Waktu Input</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest w-48 text-center">Skala Mood</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Catatan Psikologis Mahasiswa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($riwayatMood as $mood)
                    @php
                        $moodConfig = [
                            5 => ['emoji' => '😄', 'label' => 'Sangat Senang', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-200'],
                            4 => ['emoji' => '🙂', 'label' => 'Senang', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100'],
                            3 => ['emoji' => '😐', 'label' => 'Biasa Saja', 'bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'border' => 'border-slate-200'],
                            2 => ['emoji' => '🙁', 'label' => 'Sedih', 'bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100'],
                            1 => ['emoji' => '😢', 'label' => 'Sangat Sedih', 'bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'border' => 'border-rose-200'],
                        ];
                        $score = intval($mood->tingkat_mood);
                        $style = $moodConfig[$score] ?? ['emoji' => '😶', 'label' => 'N/A', 'bg' => 'bg-gray-50', 'text' => 'text-gray-400', 'border' => 'border-gray-100'];
                    @endphp
                    <tr class="group hover:bg-gray-50/50 transition-all duration-300">
                        <td class="px-6 py-8 text-center">
                            <p class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($mood->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="text-[9px] text-green-600 font-bold uppercase mt-1">Pukul {{ \Carbon\Carbon::parse($mood->created_at)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 group-hover:scale-110 transition-transform">
                                <span class="text-4xl">{{ $style['emoji'] }}</span>
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                    {{ $style['label'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-8">
                            <div class="bg-gray-50/50 p-5 rounded-2xl border border-gray-100 italic text-sm text-gray-600 leading-relaxed">
                                <p class="text-sm text-gray-600 leading-relaxed italic whitespace-pre-line text-left break-all">
                                "{{ $mood->catatan_harian ?? 'Tidak ada catatan.' }}"
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-8 py-16 text-center text-gray-400 font-bold uppercase text-[10px]">Belum ada riwayat</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        {{-- TAMPILAN MOBILE (CARDS) --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($riwayatMood as $mood)
                @php
                    // Re-use config yang sama untuk mobile
                    $score = intval($mood->tingkat_mood);
                    $style = $moodConfig[$score] ?? ['emoji' => '😶', 'label' => 'N/A', 'bg' => 'bg-gray-50', 'text' => 'text-gray-400', 'border' => 'border-gray-100'];
                @endphp
                <div class="p-6 space-y-4 bg-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-gray-800">{{ \Carbon\Carbon::parse($mood->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="text-[9px] text-green-600 font-bold uppercase">Pukul {{ \Carbon\Carbon::parse($mood->created_at)->format('H:i') }} WIB</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">{{ $style['emoji'] }}</span>
                            <span class="px-2 py-1 rounded-lg text-[8px] font-black uppercase border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                {{ $style['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-xs text-gray-600 leading-relaxed italic break-all overflow-hidden">
                            "{{ $mood->catatan_harian ?? 'Tidak ada catatan.' }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="px-8 py-16 text-center text-gray-400 font-bold uppercase text-[10px]">Belum ada riwayat</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script Grafik (Sama seperti sebelumnya dengan optimasi emoji sumbu Y) --}}
<script>
@if($trendMood->count())
const ctx = document.getElementById('moodChart');
const moodLabels = { 5: '😊', 4: '🙂', 3: '😐', 2: '🙁', 1: '😢' };

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($trendMood->pluck('tanggal')) !!},
        datasets: [{
            label: 'Level Mood',
            data: {!! json_encode($trendMood->pluck('mood')) !!},
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.05)',
            tension: 0.45,
            fill: true,
            pointRadius: window.innerWidth < 768 ? 4 : 8,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#10b981',
            pointBorderWidth: 4,
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: { 
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return ' Mood: ' + moodLabels[context.parsed.y];
                    }
                }
            }
        },
        scales: {
            y: { 
                min: 1, max: 5,
                grid: { borderDash: [10, 10], color: '#f1f5f9', drawBorder: false },
                ticks: { 
                    stepSize: 1,
                    font: { size: window.innerWidth < 1024 ? 18 : 26 },
                    callback: value => moodLabels[value]
                }
            },
            x: { grid: { display: false }, ticks: { font: { weight: '800', size: 9 }, color: '#cbd5e1' } }
        }
    }
});
@endif
</script>
@endpush
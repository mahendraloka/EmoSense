@extends('layouts.app')

@section('content')
{{-- BACKGROUND DECORATION --}}
<div class="fixed inset-0 -z-10 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
    <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
</div>

<div class="max-w-3xl mx-auto space-y-8 pb-20 pt-4 px-4">

    {{-- KARTU UTAMA --}}
    <div class="bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/60 rounded-[3rem] p-8 md:p-12 border border-white relative overflow-hidden">
        
        {{-- HEADER HASIL --}}
        <div class="text-center space-y-3 relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-[10px] font-black uppercase tracking-widest shadow-sm">
                📊 Hasil Analisis Emosional
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 tracking-tight leading-tight">
                Laporan DASS-21 Kamu
            </h2>
            <p class="text-slate-500 font-medium flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($hasil->tanggal_test)->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- GRAFIK & MAKNA --}}
        <div class="mt-12 grid lg:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center relative">
                <div class="absolute inset-0 bg-sky-200 rounded-full blur-3xl opacity-20 transform scale-75"></div>
                <canvas id="dassCircleChart" class="max-h-64 relative z-10"></canvas>
            </div>
            
            <div class="space-y-6">
                <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100 italic relative group hover:bg-white transition-colors duration-500">
                    <span class="absolute -top-3 left-6 bg-white px-2 text-2xl">🌱</span>
                    <p class="text-slate-600 leading-relaxed font-medium text-sm">
                        Grafik ini menggambarkan proporsi kondisi emosionalmu dalam <strong class="text-slate-800">7 hari terakhir</strong>. Ingatlah bahwa perasaan ini valid dan memahami diri adalah langkah awal pemulihan.
                    </p>
                </div>
            </div>
        </div>

        {{-- KARTU DETAIL HASIL --}}
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            @php
                $getTheme = function($kategori, $tingkat) {
                    // Warna Dasar per Tingkat
                    $base = match($tingkat) {
                        'Normal'       => ['bg' => 'bg-blue-500',    'text' => 'text-blue-600',    'light' => 'bg-blue-50'],
                        'Ringan'       => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'light' => 'bg-emerald-50'],
                        'Sedang'       => ['bg' => 'bg-amber-500',   'text' => 'text-amber-600',   'light' => 'bg-amber-50'],
                        'Berat'        => ['bg' => 'bg-orange-600',  'text' => 'text-orange-700',  'light' => 'bg-orange-50'],
                        'Sangat Berat' => ['bg' => 'bg-red-600',     'text' => 'text-red-700',     'light' => 'bg-red-50'],
                        default        => ['bg' => 'bg-slate-400',   'text' => 'text-slate-500',   'light' => 'bg-slate-50'],
                    };

                    // Emoji Spesifik per Dimensi & Tingkat
                    $emojis = [
                        'Depresi' => [
                            'Normal' => '😊', 'Ringan' => '🙂', 'Sedang' => '😔', 'Berat' => '☹️', 'Sangat Berat' => '😫'
                        ],
                        'Kecemasan' => [
                            'Normal' => '😇', 'Ringan' => '🤨', 'Sedang' => '😟', 'Berat' => '😰', 'Sangat Berat' => '😱'
                        ],
                        'Stres' => [
                            'Normal' => '😌', 'Ringan' => '😐', 'Sedang' => '😑', 'Berat' => '😣', 'Sangat Berat' => '🤯'
                        ],
                    ];

                    $base['emoji'] = $emojis[$kategori][$tingkat] ?? '😶';
                    return $base;
                };

                // 2. PEMANGGILAN FUNGSI
                $depresiTheme = $getTheme('Depresi', $hasil->tingkat_depresi);
                $anxietyTheme = $getTheme('Kecemasan', $hasil->tingkat_anxiety);
                $stressTheme  = $getTheme('Stres', $hasil->tingkat_stress);
            @endphp

            {{-- KARTU DEPRESI --}}
            <div class="space-y-4 group">
                <div class="{{ $depresiTheme['light'] }}/50 p-6 rounded-[2.5rem] border border-white group-hover:bg-white group-hover:shadow-xl transition-all duration-500">
                    <span class="text-5xl block mb-3 transform group-hover:scale-110 transition-transform duration-500">
                        {{ $depresiTheme['emoji'] }}
                    </span>
                    <h4 class="text-[10px] font-black {{ $depresiTheme['text'] }} uppercase tracking-[0.2em]">Depresi</h4>
                    <p class="text-xl font-black text-slate-800">{{ $hasil->tingkat_depresi }}</p>
                    
                    <div class="mt-4 w-full bg-slate-200/50 rounded-full h-2.5 overflow-hidden p-0.5">
                        <div class="{{ $depresiTheme['bg'] }} h-full rounded-full transition-all duration-1000" 
                             style="width: {{ max(($hasil->skor_depresi / 42) * 100, 8) }}%"></div>
                    </div>
                    
                    <div class="mt-3 flex justify-center items-center gap-1">
                        <span class="text-[11px] font-black text-slate-700">{{ $hasil->skor_depresi }}</span>
                        <span class="text-[10px] font-bold text-slate-400">/ 42 POIN</span>
                    </div>
                </div>
            </div>

            {{-- KARTU KECEMASAN --}}
            <div class="space-y-4 group">
                <div class="{{ $anxietyTheme['light'] }}/50 p-6 rounded-[2.5rem] border border-white group-hover:bg-white group-hover:shadow-xl transition-all duration-500">
                    <span class="text-5xl block mb-3 transform group-hover:scale-110 transition-transform duration-500">
                        {{ $anxietyTheme['emoji'] }}
                    </span>
                    <h4 class="text-[10px] font-black {{ $anxietyTheme['text'] }} uppercase tracking-[0.2em]">Kecemasan</h4>
                    <p class="text-xl font-black text-slate-800">{{ $hasil->tingkat_anxiety }}</p>
                    
                    <div class="mt-4 w-full bg-slate-200/50 rounded-full h-2.5 overflow-hidden p-0.5">
                        <div class="{{ $anxietyTheme['bg'] }} h-full rounded-full transition-all duration-1000" 
                             style="width: {{ max(($hasil->skor_anxiety / 42) * 100, 8) }}%"></div>
                    </div>
                    
                    <div class="mt-3 flex justify-center items-center gap-1">
                        <span class="text-[11px] font-black text-slate-700">{{ $hasil->skor_anxiety }}</span>
                        <span class="text-[10px] font-bold text-slate-400">/ 42 POIN</span>
                    </div>
                </div>
            </div>

            {{-- KARTU STRES --}}
            <div class="space-y-4 group">
                <div class="{{ $stressTheme['light'] }}/50 p-6 rounded-[2.5rem] border border-white group-hover:bg-white group-hover:shadow-xl transition-all duration-500">
                    <span class="text-5xl block mb-3 transform group-hover:scale-110 transition-transform duration-500">
                        {{ $stressTheme['emoji'] }}
                    </span>
                    <h4 class="text-[10px] font-black {{ $stressTheme['text'] }} uppercase tracking-[0.2em]">Stres</h4>
                    <p class="text-xl font-black text-slate-800">{{ $hasil->tingkat_stress }}</p>
                    
                    <div class="mt-4 w-full bg-slate-200/50 rounded-full h-2.5 overflow-hidden p-0.5">
                        <div class="{{ $stressTheme['bg'] }} h-full rounded-full transition-all duration-1000" 
                             style="width: {{ max(($hasil->skor_stress / 42) * 100, 8) }}%"></div>
                    </div>
                    
                    <div class="mt-3 flex justify-center items-center gap-1">
                        <span class="text-[11px] font-black text-slate-700">{{ $hasil->skor_stress }}</span>
                        <span class="text-[10px] font-bold text-slate-400">/ 42 POIN</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL NORMA SKOR --}}
        <div class="mt-16 bg-slate-50/50 rounded-[2.5rem] border border-white p-6 md:p-8">
            <div class="text-center mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Ambang Batas Skor (Norma DASS)</h3>
                <p class="text-[10px] text-slate-500 font-medium mt-1 uppercase tracking-tighter">Batas skor minimal untuk setiap kategori tingkat keparahan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 bg-blue-100/30 rounded-l-lg">Depresi</th>
                            <th class="px-4 py-2 bg-emerald-100/30">Kecemasan</th>
                            <th class="px-4 py-2 bg-amber-100/30 rounded-r-lg">Stres</th>
                        </tr>
                    </thead>
                    <tbody class="text-[11px] font-bold text-slate-600">
                        @php
                            $norma = [
                                ['Normal', '0-9', '0-7', '0-14', 'border-blue-500'],
                                ['Ringan', '10-13', '8-9', '15-18', 'border-emerald-500'],
                                ['Sedang', '14-20', '10-14', '19-25', 'border-amber-500'],
                                ['Berat', '21-27', '15-19', '26-33', 'border-orange-600'],
                                ['Sangat Berat', '28+', '20+', '34+', 'border-red-600'],
                            ];
                        @endphp
                        @foreach($norma as $n)
                        <tr class="group transition-all">
                            <td class="px-4 py-3 bg-white rounded-l-xl border-l-4 {{ $n[4] }}">{{ $n[0] }}</td>
                            <td class="px-4 py-3 bg-white/60 text-center">{{ $n[1] }}</td>
                            <td class="px-4 py-3 bg-white/60 text-center">{{ $n[2] }}</td>
                            <td class="px-4 py-3 bg-white text-center rounded-r-xl">{{ $n[3] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex gap-3 items-start bg-white/40 p-3 rounded-xl border border-white/60">
                <span class="text-xs">💡</span>
                <p class="text-[10px] text-slate-500 italic leading-relaxed">
                    Setiap dimensi memiliki ambang batas yang berbeda. Sebagai contoh, skor 24 sudah termasuk "Sangat Berat" pada Kecemasan, namun "Sedang" pada Stres.
                </p>
            </div>
        </div>

        {{-- EDUKASI (COLLAPSIBLE) --}}
        <div x-data="{ open: false }" class="mt-8 bg-slate-50/80 rounded-[2rem] border border-white overflow-hidden transition-all duration-500">
            <button @click="open = !open" class="w-full flex items-center justify-between px-8 py-5 hover:bg-white transition-colors duration-300">
                <div class="flex items-center gap-4 text-left">
                    <span class="text-xl flex-shrink-0">📘</span>
                    <p class="font-bold text-slate-800 tracking-tight">Panduan Membaca Hasil</p>
                </div>
                <svg class="w-5 h-5 text-slate-400 transition-transform duration-500" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse class="px-8 pb-8 text-sm text-slate-600 font-medium space-y-6">
                <div class="space-y-2">
                    <p class="text-slate-800 font-bold text-xs uppercase tracking-wider">Interpretasi Grafik</p>
                    <p class="leading-relaxed text-xs">
                        Persentase pada grafik menunjukkan perbandingan intensitas antara ketiga dimensi. Skor dihitung berdasarkan standar DASS untuk menentukan tingkat keparahan kondisi emosionalmu.
                    </p>
                </div>

                <div class="bg-white/50 p-4 rounded-2xl border border-white space-y-1 text-xs">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.1em]">Informasi Skala</p>
                    <p class="leading-relaxed">
                        Skor DASS-21 dikalikan 2 agar setara dengan skala DASS-42 (Maksimum 42 poin per dimensi) untuk memberikan gambaran yang lebih detail sesuai standar norma Lovibond (1995).
                    </p>
                </div>
            </div>
        </div>

        {{-- DISCLAIMER --}}
        <div class="mt-12 text-[10px] md:text-xs text-slate-400 leading-relaxed text-center max-w-2xl mx-auto border-t border-slate-100 pt-8 uppercase tracking-widest">
            Penting: Hasil ini bersifat <span class="text-slate-600 font-bold">refleksi diri mandiri</span> dan bukan merupakan diagnosis medis resmi.
        </div>

        {{-- AKSI --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-12">
            {{-- Tombol Kembali --}}
            <a href="{{ route('mahasiswa.home') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-slate-600 font-black uppercase tracking-[0.15em] text-[10px] md:text-xs shadow-lg border border-slate-100 hover:bg-slate-50 transition-all active:scale-95 group order-2 sm:order-1">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            {{-- Tombol Hubungi Psikolog --}}
            <a href="{{ route('psikolog.list') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-black uppercase tracking-[0.15em] text-[10px] md:text-xs shadow-xl shadow-emerald-200/50 hover:opacity-90 transition-all active:scale-95 order-1 sm:order-2">
                <span>📞 Hubungi Psikolog</span>
            </a>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    const ctx = document.getElementById('dassCircleChart');
    const skorDepresi = {{ $hasil->skor_depresi }};
    const skorAnxiety = {{ $hasil->skor_anxiety }};
    const skorStress  = {{ $hasil->skor_stress }};
    const total = skorDepresi + skorAnxiety + skorStress;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Depresi', 'Kecemasan', 'Stres'],
            datasets: [{
                data: total > 0 ? [skorDepresi, skorAnxiety, skorStress] : [1, 1, 1],
                backgroundColor: total > 0 
                    ? ['#3b82f6', '#10b981', '#f59e0b'] 
                    : ['#e2e8f0', '#e2e8f0', '#e2e8f0'],
                borderColor: '#ffffff',
                borderWidth: 5,
                hoverOffset: 20
            }]
        },
        options: {
            cutout: '75%',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: total > 0 },
                datalabels: {
                    color: '#1e293b',
                    font: { weight: '800', size: 10, family: 'Plus Jakarta Sans' },
                    formatter: (val, context) => {
                        if (total === 0) return "0%";
                        let sum = 0;
                        let dataArr = context.chart.data.datasets[0].data;
                        dataArr.map(data => { sum += data; });
                        return (val * 100 / sum).toFixed(1) + "%";
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
@endsection
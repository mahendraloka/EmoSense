@extends('psikolog.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-10 pb-12">
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">Hello, {{ auth('psikolog')->user()->nama }}! 👋</h1>
            <p class="text-gray-500 mt-1 font-medium italic">Pantau dan dukung kesehatan mental mahasiswa hari ini.</p>
        </div>
        <div class="hidden md:flex items-center gap-2 bg-white px-4 py-2 rounded-2xl border border-gray-200 shadow-sm">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <p class="text-xs font-bold text-gray-600">{{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </header>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Mahasiswa', 'val' => $totalMahasiswa, 'color' => 'blue', 'icon' => '🎓'],
                ['label' => 'DASS-21 Risiko Tinggi', 'val' => $dassTinggi, 'color' => 'red', 'icon' => '🚨'],
                ['label' => 'Rata-rata Mood', 'val' => number_format($rataMood, 1), 'color' => 'amber', 'icon' => '✨'],
                ['label' => 'Pengisian Hari Ini', 'val' => $totalAssessmentHariIni, 'color' => 'green', 'icon' => '📝'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-{{ $s['color'] }}-50 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    {{ $s['icon'] }}
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-{{ $s['color'] }}-400">Live Data</span>
            </div>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-tight">{{ $s['label'] }}</p>
            <h3 class="text-4xl font-black text-gray-900 mt-1">{{ $s['val'] }}</h3>
        </div>
        @endforeach
    </div>

    {{-- CHART ATAS --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                <h3 class="text-lg font-black text-gray-800 tracking-tight">Distribusi Tingkat Depresi</h3>
            </div>
            <div class="h-[300px]">
                <canvas id="chartDepresi"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                <h3 class="text-lg font-black text-gray-800 tracking-tight">Tren Rata-rata Mood (7 Hari)</h3>
            </div>
            <div class="h-[300px]">
                <canvas id="chartMood"></canvas>
            </div>
        </div>
    </div>

    {{-- CHART BAWAH --}}
    <div class="bg-white p-8 lg:p-12 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-10">
            <div class="w-1 h-6 bg-red-500 rounded-full"></div>
            <h3 class="text-lg font-black text-gray-800 tracking-tight">Dimensi Risiko Utama Mahasiswa (Hasil DASS-21 Terakhir)</h3>
        </div>
        <div class="h-[350px] lg:h-[400px]">
            <canvas id="chartRisiko"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // Chart Depresi
    new Chart(document.getElementById('chartDepresi'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dassDepresi->keys()) !!},
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: {!! json_encode($dassDepresi->values()) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 12,
                barThickness: 30,
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { display: false }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart Mood
    new Chart(document.getElementById('chartMood'), {
        type: 'line',
        data: {
            labels: {!! json_encode($trendMood->pluck('tanggal')) !!},
            datasets: [{
                label: 'Rata-rata Mood',
                data: {!! json_encode($trendMood->pluck('rata_mood')) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { min: 1, max: 5, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart Risiko
    new Chart(document.getElementById('chartRisiko'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($risikoKategori)) !!},
            datasets: [{
                label: 'Jumlah Mahasiswa Berisiko',
                data: {!! json_encode(array_values($risikoKategori)) !!},
                backgroundColor: ['#ef4444', '#f97316', '#eab308'],
                borderRadius: 15,
                barThickness: 60,
            }]
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y', // Modern horizontal look
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { stepSize: 1 } },
                y: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@extends('admin.layouts.master')

@section('content')
<div class="space-y-8">
    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">
                Hello, {{ Auth::user()->nama ?? Auth::user()->name }}! 👋
            </h1>
            <p class="text-gray-500 mt-1 font-medium">
                Berikut adalah rangkuman data <span class="text-blue-600 font-bold">EmoSense</span> hari ini.
            </p>
        </div>
        
        {{-- Info Waktu Login --}}
        <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-left">
                <p class="text-[10px] uppercase font-bold text-gray-400 leading-none">Login Terakhir</p>
                <p class="text-xs font-bold text-gray-700">{{ now()->format('d M, H:i') }}</p>
            </div>
        </div>
    </header>

    {{-- Grid Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Mahasiswa', 'value' => $totalMahasiswa, 'color' => 'blue', 'icon' => '🎓'],
                ['label' => 'Total Psikolog', 'value' => $totalPsikolog, 'color' => 'amber', 'icon' => '🧠'],
                ['label' => 'Total Artikel', 'value' => $totalArtikel, 'color' => 'purple', 'icon' => '📄'],
                ['label' => 'Sistem Admin', 'value' => $totalAdmin, 'color' => 'emerald', 'icon' => '🛠️'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-{{ $stat['color'] }}-50 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                    {{ $stat['icon'] }}
                </div>
                <span class="text-xs font-bold text-{{ $stat['color'] }}-600 bg-{{ $stat['color'] }}-50 px-2 py-1 rounded-lg uppercase tracking-wider">Statistik</span>
            </div>
            <div class="mt-4">
                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">{{ $stat['label'] }}</p>
                <h3 class="text-3xl font-black text-gray-900 mt-1">{{ number_format($stat['value']) }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart Section --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2 text-lg">
                <span class="w-1 h-6 bg-blue-600 rounded-full"></span>
                Aktivitas Pengguna
            </h3>
            <canvas id="userChart" class="max-h-[300px]"></canvas>
        </div>

        {{-- Info Section --}}
        <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="font-bold text-xl mb-4">Informasi Sistem</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-white/10 pb-3">
                        <span class="text-gray-400">Status Server</span>
                        <span class="flex items-center gap-2 text-green-400 font-bold">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-ping"></span> Online
                        </span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-3">
                        <span class="text-gray-400">Total Database</span>
                        <span class="font-bold">{{ $totalMahasiswa + $totalAdmin + $totalPsikolog }} Users</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Waktu Server</span>
                        <span class="font-mono text-sm">{{ now()->format('H:i T') }}</span>
                    </div>
                </div>
            </div>
            {{-- Abstract Decoration --}}
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('userChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Mahasiswa', 'Admin', 'Psikolog'],
        datasets: [{
            label: 'Jumlah Pengguna',
            data: [
                {{ $totalMahasiswa }},
                {{ $totalAdmin }},
                {{ $totalPsikolog }}
            ],
            backgroundColor: [
                '#2563EB', // Mahasiswa
                '#16A34A', // Admin
                '#EAB308'  // Psikolog
            ],
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
@endsection

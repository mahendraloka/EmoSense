@extends('admin.layouts.master')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight text-green-600">Edit Pertanyaan</h1>
            <p class="text-gray-500 font-medium font-medium mt-1">Perbarui data butir instrumen ke-{{ $pertanyaan->urutan }}.</p>
        </div>
        <a href="{{ route('admin.pertanyaan.index') }}" class="text-sm font-bold text-gray-400 hover:text-green-600 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Batalkan Edit
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.pertanyaan.update', $pertanyaan->id_Pertanyaan) }}" method="POST" class="divide-y divide-gray-50">
            @csrf @method('PUT')
            
            <div class="p-8 md:p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Urutan --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Urutan Item</label>
                        <input type="number" name="urutan" min="1" max="21" value="{{ old('urutan', $pertanyaan->urutan) }}"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-bold text-lg text-green-600" required>
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Kategori</label>
                        <div class="relative">
                            <select name="kategori" required
                                    class="w-full appearance-none px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium cursor-pointer">
                                <option value="Stress" {{ $pertanyaan->kategori=='Stress'?'selected':'' }}>Stress</option>
                                <option value="Anxiety" {{ $pertanyaan->kategori=='Anxiety'?'selected':'' }}>Anxiety</option>
                                <option value="Depression" {{ $pertanyaan->kategori=='Depression'?'selected':'' }}>Depression</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Teks Pertanyaan --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Bunyi Teks Pertanyaan</label>
                    <textarea name="teks_pertanyaan" rows="5" required
                              class="w-full px-6 py-5 bg-gray-50 border border-gray-200 rounded-[2rem] focus:ring-4 focus:ring-green-500/10 focus:border-green-500 focus:bg-white transition-all outline-none font-medium text-gray-700 leading-relaxed">{{ old('teks_pertanyaan', $pertanyaan->teks_pertanyaan) }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="px-8 py-10 bg-gray-50/50 flex flex-col md:flex-row justify-end items-center gap-4">
                <a href="{{ route('admin.pertanyaan.index') }}" class="px-8 py-4 text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-xl shadow-green-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Update Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('admin.layouts.master')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Artikel</h1>
            <p class="text-gray-500 font-medium">Perbarui informasi dan konten artikel yang sudah ada.</p>
        </div>
        <a href="{{ route('admin.artikel.index') }}" 
           class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors group">
            <svg class="w-5 h-5 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <form id="form-edit"
              action="{{ route('admin.artikel.update', $artikel->id_Artikel) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-10 space-y-8">
                {{-- Judul --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">Judul Artikel</label>
                    <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}"
                           class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                    @error('judul')
                        <p class="text-red-600 text-xs mt-2 ml-2 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">Kategori</label>
                    <div class="relative">
                        <select name="kategori"
                                class="w-full appearance-none px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium cursor-pointer">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Depresi" {{ (old('kategori', $artikel->kategori) == 'Depresi') ? 'selected' : '' }}>Depresi</option>
                            <option value="Anxiety" {{ (old('kategori', $artikel->kategori) == 'Anxiety') ? 'selected' : '' }}>Anxiety</option>
                            <option value="Stress" {{ (old('kategori', $artikel->kategori) == 'Stress') ? 'selected' : '' }}>Stress</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('kategori')
                        <p class="text-red-600 text-xs mt-2 ml-2 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konten --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">Konten Artikel</label>
                    <div class="prose prose-blue max-w-none">
                        <input id="konten" type="hidden" name="konten" value="{{ old('konten', $artikel->konten) }}">
                        <trix-editor input="konten" class="trix-content min-h-[350px] bg-gray-50 border border-gray-200 rounded-2xl p-4 focus:bg-white transition-all focus:ring-4 focus:ring-blue-500/10 outline-none"></trix-editor>
                    </div>
                    @error('konten')
                        <p class="text-red-600 text-xs mt-2 ml-2 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1 text-center md:text-left">Gambar Artikel</label>
                    
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        {{-- Preview Box --}}
                        <div class="relative w-full md:w-80 h-48 bg-gray-100 rounded-[2rem] overflow-hidden border-2 border-dashed border-gray-300 flex items-center justify-center shadow-inner group">
                            @if($artikel->gambar)
                                <img id="preview" src="{{ asset('storage/'.$artikel->gambar) }}" class="absolute inset-0 w-full h-full object-cover">
                                <div id="placeholder-icon" class="hidden text-gray-400 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs font-bold uppercase tracking-widest">Preview</span>
                                </div>
                            @else
                                <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                <div id="placeholder-icon" class="text-gray-400 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs font-bold uppercase tracking-widest">Preview</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 space-y-4 w-full text-center md:text-left">
                            <input type="file" name="gambar" id="gambar-input" accept="image/jpeg,image/png" onchange="previewImage(event)" class="hidden">
                            <label for="gambar-input" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-200 rounded-2xl font-bold text-gray-700 hover:border-green-500 hover:text-green-600 cursor-pointer transition-all active:scale-95 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Ganti Gambar
                            </label>
                            <p class="text-xs text-gray-400 font-medium italic">Kosongkan jika tidak ingin mengubah gambar</p>
                            @error('gambar')
                                <p class="text-red-600 text-xs font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Footer --}}
            <div class="px-6 py-8 md:px-10 bg-gray-50/50 border-t border-gray-100 flex flex-col md:flex-row justify-end gap-4">
                <a href="{{ route('admin.artikel.index') }}" class="px-8 py-4 text-sm font-bold text-gray-400 hover:text-gray-600 text-center uppercase tracking-widest transition-colors flex items-center justify-center">Batal</a>
                <button type="button" onclick="confirmUpdate()"
                        class="px-10 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-xl shadow-green-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Update Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>

<script>
function confirmUpdate() {
    Swal.fire({
        title: 'Simpan perubahan?',
        text: 'Konten artikel akan diperbarui secara permanen.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Ya, perbarui',
        cancelButtonText: 'Batal',
        borderRadius: '20px'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-edit').submit();
        }
    });
}

function previewImage(event) {
    const img = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder-icon');
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
}
</script>
@endsection
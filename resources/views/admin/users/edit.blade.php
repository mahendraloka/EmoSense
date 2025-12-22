@extends('admin.layouts.master')

@section('title', 'Edit ' . ucfirst($type))

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Data {{ ucfirst($type) }}</h1>
            <p class="text-gray-500 font-medium mt-1 font-mono italic">UID: #{{ $user->getKey() }}</p>
        </div>
        <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="text-sm font-bold text-gray-400 hover:text-blue-600 transition flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.users.update', [$type, $user->getKey()]) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-50">
            @csrf @method('PUT')
            
            <div class="p-8 md:p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
                        @error('nama') <p class="text-red-600 text-xs font-bold mt-1 italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email (Readonly) --}}
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest ml-1">Email (Akun Tidak Dapat Diubah)</label>
                        <div class="relative group">
                            <input type="email" name="email" value="{{ $user->email }}" readonly
                                   class="w-full px-6 py-4 bg-gray-100 border border-gray-200 rounded-2xl text-gray-400 cursor-not-allowed font-medium">
                            <span class="absolute right-6 top-4 text-gray-300">🔒</span>
                        </div>
                    </div>

                    @if ($type === 'mahasiswa')
                        <div class="space-y-2"><label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">NIM</label>
                        <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none"></div>
                        <div class="space-y-2"><label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Fakultas</label>
                        <input type="text" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none"></div>
                        <div class="space-y-2 md:col-span-2"><label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Program Studi</label>
                        <input type="text" name="prodi" value="{{ old('prodi', $user->prodi) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none"></div>
                    @endif

                    @if ($type === 'psikolog')
                        <div class="space-y-2"><label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Nomor STR</label>
                        <input type="text" name="nomor_str" value="{{ old('nomor_str', $user->nomor_str) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none"></div>
                        <div class="space-y-2 md:col-span-2"><label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Spesialisasi</label>
                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi', $user->spesialisasi) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none"></div>
                        
                        <div class="md:col-span-2 bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100">
                            <div class="flex flex-col md:flex-row items-center gap-8">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden">
                                        <img id="fotoPreview" src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('images/default-user.png') }}" class="w-full h-full object-cover transition group-hover:scale-110">
                                    </div>
                                    <label for="foto_profil" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center border-4 border-white cursor-pointer hover:bg-blue-700 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </label>
                                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden" onchange="previewFoto(event)">
                                </div>
                                <div class="flex-1 text-center md:text-left">
                                    <p class="text-sm font-bold text-blue-900 italic">Ubah Foto Profil</p>
                                    <p class="text-xs text-blue-600 mt-1">Biarkan kosong jika tidak ingin mengganti foto yang sudah ada.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="px-8 py-10 bg-gray-50/50 flex flex-col md:flex-row justify-end items-center gap-4">
                <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="px-8 py-4 text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batalkan</a>
                <button type="submit" 
                        class="w-full md:w-auto px-12 py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-xl shadow-green-600/20 transition-all active:scale-95 uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewFoto(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('fotoPreview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
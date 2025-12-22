@extends('layouts.app')

@section('content')

{{-- GLOBAL WRAPPER DENGAN BACKGROUND DEKORATIF --}}
<div class="relative overflow-hidden min-h-screen">
    {{-- BACKGROUND DECORATION --}}
    <div class="fixed inset-0 -z-10 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0]"></div>
        <div class="absolute -top-40 -right-40 w-[30rem] h-[30rem] bg-sky-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[30rem] h-[30rem] bg-teal-100/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 space-y-8 pb-20 pt-4 text-center md:text-left">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-2">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white text-2xl shadow-lg shadow-slate-200 transform -rotate-3">
                    ⚙️
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Pengaturan Akun</h1>
                    <p class="text-sm text-slate-500 font-medium">Kelola profil dan keamanan digital Anda.</p>
                </div>
            </div>
            <a href="{{ route('mahasiswa.home') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-white/80 backdrop-blur-md text-slate-600 font-bold shadow-sm border border-white hover:bg-white transition-all active:scale-95 text-xs uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        {{-- SUCCESS ALERT --}}
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm animate-fadeIn">
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- INFORMASI PROFIL --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white p-6 md:p-10 transition-all text-left">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-6 bg-sky-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight uppercase tracking-widest">Informasi Dasar</h2>
            </div>

            <form id="formProfil" action="{{ route('mahasiswa.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ([
                        ['label'=>'Nama Lengkap', 'name'=>'nama', 'type'=>'text', 'icon'=>'👤', 'readonly' => false],
                        ['label'=>'NIM', 'name'=>'nim', 'type'=>'text', 'icon'=>'🆔', 'readonly' => false],
                        ['label'=>'Email (Akun Utama)', 'name'=>'email', 'type'=>'email', 'icon'=>'🔒', 'readonly' => true],
                        ['label'=>'Fakultas', 'name'=>'fakultas', 'type'=>'text', 'icon'=>'🏛️', 'readonly' => false],
                    ] as $field)
                        <div class="space-y-2 group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-500 transition-colors">
                                {{ $field['label'] }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-lg">{{ $field['icon'] }}</span>
                                <input
                                    type="{{ $field['type'] }}"
                                    name="{{ $field['name'] }}"
                                    value="{{ old($field['name'], $mahasiswa->{$field['name']}) }}"
                                    {{ $field['readonly'] ? 'readonly' : '' }}
                                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl border transition-all outline-none font-bold
                                    {{ $field['readonly'] 
                                        ? 'bg-slate-100 border-slate-200 text-slate-400 cursor-not-allowed italic shadow-inner' 
                                        : 'bg-slate-50/50 border-slate-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 focus:bg-white text-slate-700' 
                                    }}"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-2 group">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-500 transition-colors text-left block">
                        Program Studi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-lg text-left">🎓</span>
                        <input
                            type="text"
                            name="prodi"
                            value="{{ old('prodi', $mahasiswa->prodi) }}"
                            class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-slate-50/50 border border-slate-100 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 focus:bg-white transition-all outline-none font-bold text-slate-700"
                        >
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" onclick="openConfirm('profil')"
                            class="w-full md:w-auto px-10 py-4 rounded-2xl bg-slate-900 text-white font-black uppercase tracking-widest text-xs shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- KEAMANAN --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white p-6 md:p-10 transition-all text-left">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-6 bg-rose-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight uppercase tracking-widest">Keamanan Akun</h2>
            </div>

            <form id="formPassword" action="{{ route('mahasiswa.profile.password') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password Lama</label>
                    <input type="password" name="password_lama" placeholder="••••••••"
                        class="w-full px-5 py-3.5 rounded-2xl bg-slate-50/50 border border-slate-100 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold">
                    {{-- Pesan error diletakkan di bawah input --}}
                    @error('password_lama')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password Baru</label>
                    <input type="password" name="password_baru" placeholder="Minimal 8 karakter"
                        class="w-full px-5 py-3.5 rounded-2xl bg-slate-50/50 border border-slate-100 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold">
                    @error('password_baru')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2 md:col-span-2 text-left">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_baru_confirmation" placeholder="Ulangi password baru"
                        class="w-full px-5 py-3.5 rounded-2xl bg-slate-50/50 border border-slate-100 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold">
                </div>

                <div class="md:col-span-2 flex justify-end pt-4">
                    <button type="button" onclick="openConfirm('password')"
                            class="w-full md:w-auto px-10 py-4 rounded-2xl bg-rose-500 text-white font-black uppercase tracking-widest text-xs shadow-xl shadow-rose-100 hover:bg-rose-600 transition-all active:scale-95">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI (SweetAlert2 Style) --}}
<div id="confirmModal" x-data x-cloak
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-[100] px-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 md:p-10 shadow-2xl border border-white animate-fadeIn">
        <div class="w-16 h-16 bg-sky-50 rounded-2xl flex items-center justify-center text-3xl mb-6 mx-auto">
            🛡️
        </div>
        <h3 class="text-2xl font-black text-slate-800 text-center tracking-tight mb-2">Konfirmasi Perubahan</h3>
        <p class="text-slate-500 text-center font-medium mb-8 leading-relaxed">
            Apakah Anda sudah yakin data yang dimasukkan benar? Perubahan akan langsung diterapkan pada akun Anda.
        </p>

        <div class="grid grid-cols-2 gap-3">
            <button onclick="closeConfirm()"
                    class="py-4 rounded-2xl border-2 border-slate-100 text-slate-500 font-black uppercase tracking-widest text-[10px] hover:bg-slate-50 transition-all">
                Batal
            </button>
            <button onclick="submitForm()"
                    class="py-4 rounded-2xl bg-sky-500 text-white font-black uppercase tracking-widest text-[10px] shadow-lg shadow-sky-100 hover:bg-sky-600 transition-all active:scale-95">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT DAN STYLE TETAP SAMA --}}
<script>
    let currentForm = null;
    function openConfirm(type) {
        currentForm = type === 'profil' ? document.getElementById('formProfil') : document.getElementById('formPassword');
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }
    function closeConfirm() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
        currentForm = null;
    }
    function submitForm() {
        if (currentForm) { currentForm.submit(); }
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>
@endsection
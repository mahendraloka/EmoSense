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
        <div id="sectionPassword" class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white p-6 md:p-10 transition-all text-left">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1.5 h-6 bg-rose-500 rounded-full"></div>
                <h2 class="text-lg font-black text-slate-800 tracking-tight uppercase tracking-widest">Keamanan Akun</h2>
            </div>

            <form id="formPassword" action="{{ route('mahasiswa.profile.password') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                {{-- Password Lama --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password Lama</label>
                    <div class="relative">
                        <input type="password" id="password_lama" name="password_lama" placeholder="••••••••"
                            class="w-full px-5 py-3.5 pr-12 rounded-2xl bg-slate-50/50 border focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold {{ $errors->has('password_lama') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-100' }}">
                        <button type="button" onclick="toggleVisibility('password_lama', 'eyeOld', 'eyeOldSlash')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 p-2 focus:outline-none hover:text-rose-500 transition-colors">
                            <svg id="eyeOld" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" /></svg>
                            <svg id="eyeOldSlash" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password_lama')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 ml-2 uppercase animate-pulse">⚠️ {{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Password Baru --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="password_baru" name="password_baru" placeholder="Minimal 8 karakter"
                            class="w-full px-5 py-3.5 pr-12 rounded-2xl bg-slate-50/50 border focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold {{ $errors->has('password_baru') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-100' }}">
                        <button type="button" onclick="toggleVisibility('password_baru', 'eyeNew', 'eyeNewSlash')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 p-2 focus:outline-none hover:text-rose-500 transition-colors">
                            <svg id="eyeNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" /></svg>
                            <svg id="eyeNewSlash" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password_baru')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 ml-2 uppercase">⚠️ {{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Konfirmasi Password --}}
                <div class="space-y-2 md:col-span-2 text-left">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" placeholder="Ulangi password baru"
                            class="w-full px-5 py-3.5 pr-12 rounded-2xl bg-slate-50/50 border border-slate-100 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 focus:bg-white transition-all outline-none font-bold">
                        <button type="button" onclick="toggleVisibility('password_baru_confirmation', 'eyeConfirm', 'eyeConfirmSlash')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 p-2 focus:outline-none hover:text-rose-500 transition-colors">
                            <svg id="eyeConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.644m17.832 0a1.012 1.012 0 010 .644M12 18.75c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.046m4.01-4.22a9.956 9.956 0 013.97-1.033m2.632 0c1.398.077 2.731.43 3.933 1.033m4.026 4.22a9.97 9.97 0 011.563 3.046M12 5.25c4.478 0 8.268-2.943 9.543 7a9.97 9.97 0 01-1.563 3.046M9.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0Z" /></svg>
                            <svg id="eyeConfirmSlash" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    <p id="errorConfirm" class="hidden text-rose-500 text-[10px] font-bold mt-1 ml-2 uppercase animate-pulse">⚠️ Konfirmasi password tidak cocok!</p>
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

{{-- MODAL KONFIRMASI --}}
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
                    class="py-4 rounded-2xl bg-sky-600 text-white font-black uppercase tracking-widest text-[10px] shadow-lg shadow-sky-100 hover:bg-sky-700 transition-all active:scale-95">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    let currentForm = null;

    // 1. Toggle Password Visibility
    function toggleVisibility(inputId, eyeId, slashId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        const slash = document.getElementById(slashId);
        if (input.type === "password") {
            input.type = "text";
            eye.classList.add('hidden');
            slash.classList.remove('hidden');
        } else {
            input.type = "password";
            eye.classList.remove('hidden');
            slash.classList.add('hidden');
        }
    }

    // 2. Control Modal Konfirmasi + Validasi Client Side
    function openConfirm(type) {
        currentForm = type === 'profil' ? document.getElementById('formProfil') : document.getElementById('formPassword');
        const errorJS = document.getElementById('errorConfirm');

        if(errorJS) errorJS.classList.add('hidden');

        // Jika Form Password, cek kecocokan dlu
        if (type === 'password') {
            const passBaru = document.getElementById('password_baru').value;
            const confBaru = document.getElementById('password_baru_confirmation').value;

            if (passBaru !== confBaru) {
                errorJS.classList.remove('hidden');
                document.getElementById('password_baru_confirmation').focus();
                // Scroll ke arah input yang salah
                document.getElementById('password_baru_confirmation').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return; 
            }
        }

        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeConfirm() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
        currentForm = null;
    }

    function submitForm() {
        if (currentForm) {
            currentForm.submit(); 
        }
    }

    // 3. Scroll Otomatis ke Error Sisi Server saat halaman di-reload
    @if ($errors->any())
        window.onload = function() {
            const firstErrorField = document.querySelector('.text-rose-500');
            if (firstErrorField) {
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        };
    @endif
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
    [x-cloak] { display: none !important; }
</style>
@endsection
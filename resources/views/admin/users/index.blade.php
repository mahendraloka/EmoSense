@extends('admin.layouts.master')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-6 pb-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kelola Pengguna</h1>
            <p class="text-gray-500 font-medium">Manajemen data akses untuk Mahasiswa, Psikolog, dan Admin.</p>
        </div>

        <a href="{{ route('admin.users.create', $type) }}"
           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 group">
            <span class="mr-2 transform group-hover:scale-110 transition-transform">➕</span> Tambah {{ ucfirst($type) }}
        </a>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex p-1 bg-gray-100 rounded-2xl w-fit">
        @foreach(['mahasiswa','psikolog','admin'] as $menu)
            <a href="{{ route('admin.users.index', ['type'=>$menu]) }}"
               class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all
               {{ $type === $menu ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                {{ ucfirst($menu) }}
            </a>
        @endforeach
    </div>

    {{-- Search Card --}}
    <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-3 items-center">
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                       placeholder="Cari data..."
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-transparent rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium">
            </div>
            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all">
                Cari Data
            </button>
        </form>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest w-16 text-center">#</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Identitas User</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Email</th>
                        @if($type === 'mahasiswa')
                            <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">NIM</th>
                        @endif
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $u)
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-5 text-center font-bold text-gray-400 text-sm">
                            {{ ($users->currentPage()-1)*$users->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase">
                                    {{ substr($u->nama, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 truncate max-w-[150px]">{{ $u->nama }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $type }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-medium text-gray-700">{{ $u->email }}</p>
                        </td>
                        @if($type === 'mahasiswa')
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold font-mono">{{ $u->nim }}</span>
                            </td>
                        @endif
                        
                        {{-- PERBAIKAN AKSI: Tombol berjejer langsung (Identik dengan DASS-21) --}}
                        <td class="px-6 py-5">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.users.edit', [$type, $u->getKey()]) }}"
                                   class="p-2.5 text-amber-500 bg-amber-50 hover:bg-amber-500 hover:text-white rounded-xl transition-all shadow-sm"
                                   title="Edit User">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2l-6 6H9v-2z"/></svg>
                                </a>
                        
                                {{-- Tombol Reset Password --}}
                                <button type="button" 
                                onclick="resetPassword('{{ route('admin.users.reset-password', ['type' => $type, 'id' => $u->getKey()]) }}', '{{ addslashes($u->nama) }}')"
                                class="p-2.5 text-indigo-500 bg-indigo-50 hover:bg-indigo-500 hover:text-white rounded-xl transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3M21 12a9 9 0 11-6.219-8.56"/></svg>
                                </button>

                                {{-- Tombol Hapus User --}}
                                <button type="button" 
                                onclick="deleteUser('{{ route('admin.users.destroy', ['type' => $type, 'id' => $u->getKey()]) }}', '{{ addslashes($u->nama) }}')"
                                class="p-2.5 text-red-500 bg-red-50 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M9 7V4h6v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Data tidak ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pt-4">{{ $users->links() }}</div>
</div>
@endsection

@section('scripts')
<script>
    window.resetPassword = function(url, nama) {
        Swal.fire({
            title: 'Reset Password?',
            text: `Password untuk ${nama} akan dibuat baru secara otomatis.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#4f46e5',
            borderRadius: '20px'
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({ 
                    title: 'Memproses...', 
                    allowOutsideClick: false, 
                    didOpen: () => Swal.showLoading() 
                });

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal menghubungi server');
                    return res.json();
                })
                .then(data => {
                    if(data.status === 'success') {
                        const newPassword = data.password.toString().trim();
                        
                        Swal.fire({
                            title: 'Berhasil!',
                            html: `
                                <p class="mb-3 text-sm text-gray-500">Salin password baru untuk <b>${nama}</b>:</p>
                                <div id="pwd-box" class="bg-gray-100 p-4 rounded-xl font-mono text-2xl border-2 border-dashed border-indigo-300 cursor-pointer select-all">${newPassword}</div>
                            `,
                            icon: 'success',
                            confirmButtonText: 'Salin & Tutup',
                            confirmButtonColor: '#4f46e5',
                        }).then(() => {
                            // Fungsi Salin dengan Fallback (Dukungan Hosting Non-HTTPS)
                            copyToClipboard(newPassword);
                        });
                    }
                })
                .catch(err => {
                    Swal.fire('Error', err.message, 'error');
                });
            }
        });
    }

    // Fungsi helper salin teks (Anti-Gagal di Hosting)
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showToast();
            });
        } else {
            // Fallback untuk HTTP/Hosting tanpa SSL
            let textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-9999px";
            textArea.style.top = "0";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast();
            } catch (err) {
                console.error('Gagal menyalin', err);
            }
            document.body.removeChild(textArea);
        }
    }

    function showToast() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Password berhasil disalin',
            showConfirmButton: false,
            timer: 1500
        });
    }

    window.deleteUser = function(url, nama) {
        Swal.fire({
            title: 'Hapus User?',
            text: `Seluruh data ${nama} akan dihapus permanen dari sistem!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            borderRadius: '20px'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
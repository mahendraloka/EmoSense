@extends('admin.layouts.master')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Artikel</h1>
            <p class="text-gray-500 text-sm">Update konten edukasi kesehatan mental mahasiswa.</p>
        </div>
        <a href="{{ route('admin.artikel.create') }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
           <span class="mr-2">➕</span> Tambah Artikel
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul artikel..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
            </div>
            <button class="px-8 py-2.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-black transition-all">Cari</button>
        </form>
    </div>

    {{-- Responsive Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bold text-gray-700">Artikel</th>
                        <th class="px-6 py-4 font-bold text-gray-700 hidden md:table-cell">Penulis</th>
                        <th class="px-6 py-4 font-bold text-gray-700 hidden lg:table-cell">Tanggal</th>
                        <th class="px-6 py-4 text-center font-bold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($artikels as $artikel)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $artikel->judul }}</span>
                                <span class="text-xs text-gray-400 md:hidden mt-1">{{ \Carbon\Carbon::parse($artikel->tanggal_upload)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($artikel->admin)
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">Admin: {{ $artikel->admin->nama }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold border border-purple-100">Psikolog: {{ $artikel->psikolog->nama }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 hidden lg:table-cell font-medium">
                            {{ \Carbon\Carbon::parse($artikel->tanggal_upload)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.artikel.edit', $artikel->id_Artikel) }}" 
                                   class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2l-6 6H9v-2z"/></svg>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $artikel->id_Artikel) }}" method="POST" class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M9 7V4h6v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">Belum ada artikel yang dibuat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $artikels->links() }}</div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Hapus Artikel?',
            text: 'Artikel yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection

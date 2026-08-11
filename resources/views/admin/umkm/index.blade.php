{{-- resources/views/admin/umkm/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Manajemen UMKM')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama usaha..."
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </form>
        <a href="{{ route('admin.umkm.create') }}"
           class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah UMKM
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Usaha</th>
                        <th class="text-left px-5 py-3 font-medium">Kategori</th>
                        <th class="text-left px-5 py-3 font-medium">Kontak</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($umkms as $umkm)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate max-w-xs">{{ $umkm->nama_usaha }}</p>
                                        <p class="text-xs text-slate-400">{{ $umkm->nama_pemilik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $umkm->kategori }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $umkm->no_hp ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $umkm->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($umkm->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.umkm.edit', $umkm) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.umkm.destroy', $umkm) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data UMKM ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-slate-400 text-sm">Belum ada data UMKM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($umkms->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $umkms->links() }}</div>
        @endif
    </div>
</div>
@endsection

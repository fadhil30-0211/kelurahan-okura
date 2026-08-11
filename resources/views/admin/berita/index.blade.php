{{-- resources/views/admin/berita/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Manajemen Berita')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..."
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </form>
        <a href="{{ route('admin.berita.create') }}"
           class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Berita
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Berita</th>
                        <th class="text-left px-5 py-3 font-medium">Kategori</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-left px-5 py-3 font-medium">Dilihat</th>
                        <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($beritas as $berita)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $berita->thumbnail ? asset('storage/'.$berita->thumbnail) : asset('images/placeholder.jpg') }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate max-w-xs">{{ $berita->judul }}</p>
                                        <p class="text-xs text-slate-400">oleh {{ $berita->user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $berita->kategori }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $berita->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($berita->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $berita->views }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $berita->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.berita.edit', $berita) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-10 text-slate-400 text-sm">Belum ada berita ditambahkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($beritas->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $beritas->links() }}</div>
        @endif
    </div>
</div>
@endsection

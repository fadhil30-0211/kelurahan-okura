{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Pengumuman')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul pengumuman..."
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </form>
        <a href="{{ route('admin.pengumuman.create') }}"
           class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Pengumuman
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Judul</th>
                        <th class="text-left px-5 py-3 font-medium">Kategori</th>
                        <th class="text-left px-5 py-3 font-medium">Periode</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pengumumans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-slate-800 truncate max-w-xs">{{ $item->judul }}</p>
                                <p class="text-xs text-slate-400">oleh {{ $item->user->name }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                @php
                                    $kategoriColor = match($item->kategori) {
                                        'darurat' => 'bg-red-50 text-red-700',
                                        'penting' => 'bg-amber-50 text-amber-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $kategoriColor }}">{{ ucfirst($item->kategori) }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">
                                {{ $item->tanggal_mulai->format('d M Y') }}
                                @if ($item->tanggal_selesai) — {{ $item->tanggal_selesai->format('d M Y') }} @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pengumuman.edit', $item) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-slate-400 text-sm">Belum ada pengumuman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pengumumans->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $pengumumans->links() }}</div>
        @endif
    </div>
</div>
@endsection

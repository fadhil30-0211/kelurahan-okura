{{-- resources/views/admin/wisata/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Manajemen Wisata')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama wisata..."
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </form>
        <a href="{{ route('admin.wisata.create') }}"
           class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Wisata
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Wisata</th>
                        <th class="text-left px-5 py-3 font-medium">Harga Tiket</th>
                        <th class="text-left px-5 py-3 font-medium">Jam Operasional</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($wisatas as $wisata)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate max-w-xs">{{ $wisata->nama }}</p>
                                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $wisata->alamat }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $wisata->harga_tiket ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $wisata->jam_operasional ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $wisata->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($wisata->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.wisata.edit', $wisata) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.wisata.destroy', $wisata) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data wisata ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-slate-400 text-sm">Belum ada data wisata.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

@if ($wisata->status === 'pending')
    <form action="{{ route('admin.wisata.approve', $wisata) }}" method="POST" class="inline">
        @csrf @method('PUT')
        <button type="submit" class="text-xs font-medium text-emerald-600 hover:underline">Setujui</button>
    </form>
@endif

    </div>
</div>
@endsection

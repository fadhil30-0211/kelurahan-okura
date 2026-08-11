{{-- resources/views/admin/pegawai/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Struktur Pegawai')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex-1 max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai..."
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </form>
        <a href="{{ route('admin.pegawai.create') }}"
           class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Pegawai
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Pegawai</th>
                        <th class="text-left px-5 py-3 font-medium">Jabatan</th>
                        <th class="text-left px-5 py-3 font-medium">Kontak</th>
                        <th class="text-left px-5 py-3 font-medium">Urutan</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pegawais as $pegawai)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/'.$pegawai->foto) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-800 truncate">{{ $pegawai->nama }}</p>
                                        <p class="text-xs text-slate-400">{{ $pegawai->nip ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $pegawai->jabatan }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">
                                {{ $pegawai->no_hp ?? '-' }}<br>{{ $pegawai->email ?? '' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $pegawai->urutan }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $pegawai->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $pegawai->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data pegawai ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-10 text-slate-400 text-sm">Belum ada data pegawai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pegawais->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $pegawais->links() }}</div>
        @endif
    </div>
</div>
@endsection

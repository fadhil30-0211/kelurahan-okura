{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')

@section('content')
<div class="space-y-6">

    {{-- ALERT FLASH MESSAGE --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- SUMMARY CARDS (Tampil jika variabel $summary dipassing dari controller) --}}
    @if (isset($summary))
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Pengumuman</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">{{ number_format($summary['total'] ?? 0) }}</h4>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882T19.246 3A2 2 0 0121 5v11a2 2 0 01-1.246 1.882L11 21m0-15.118L2.754 3A2 2 0 001 5v11a2 2 0 001.246 1.882L11 21m0-15.118V21"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Aktif</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">{{ number_format($summary['aktif'] ?? 0) }}</h4>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between col-span-2 lg:col-span-1">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nonaktif</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">{{ number_format($summary['nonaktif'] ?? 0) }}</h4>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>
    @endif

    {{-- FILTER & ACTION BAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-col sm:flex-row gap-2.5 flex-1 max-w-lg">
            {{-- Input Teks pl-4 tanpa ikon --}}
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul pengumuman..."
                       class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
            </div>

            @if(request('search'))
                <a href="{{ route('admin.pengumuman.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.pengumuman.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengumuman
        </a>
    </div>

    {{-- TABEL PENGUMUMAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/60 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-5">Judul</th>
                        <th class="py-3 px-5">Kategori</th>
                        <th class="py-3 px-5">Periode</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($pengumumans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            {{-- Judul & Author --}}
                            <td class="py-3.5 px-5">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 truncate max-w-xs text-xs md:text-sm" title="{{ $item->judul }}">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        oleh <span class="font-medium text-slate-600">{{ $item->user->name ?? 'Admin' }}</span>
                                    </p>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                @php
                                    $kategoriColor = match($item->kategori) {
                                        'darurat' => 'bg-rose-50 text-rose-700 border border-rose-100',
                                        'penting' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold inline-block capitalize {{ $kategoriColor }}">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>

                            {{-- Periode Tanggal --}}
                            <td class="py-3.5 px-5 text-slate-500 text-xs whitespace-nowrap font-mono">
                                {{ $item->tanggal_mulai->format('d M Y') }}
                                @if ($item->tanggal_selesai)
                                    <span class="text-slate-300 mx-1">—</span> {{ $item->tanggal_selesai->format('d M Y') }}
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium inline-block {{ $item->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.pengumuman.edit', $item) }}"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition"
                                       title="Edit Pengumuman">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus Pengumuman">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882T19.246 3A2 2 0 0121 5v11a2 2 0 01-1.246 1.882L11 21m0-15.118L2.754 3A2 2 0 001 5v11a2 2 0 001.246 1.882L11 21m0-15.118V21"/>
                                    </svg>
                                    <p class="text-sm">Belum ada pengumuman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($pengumumans->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

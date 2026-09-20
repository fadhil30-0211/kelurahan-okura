{{-- resources/views/admin/pengaduan/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Inbox Pengaduan')
@section('page-title', 'Inbox Pengaduan')

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

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                [
                    'label' => 'Total Aduan',
                    'value' => $summary['total'],
                    'bg' => 'bg-slate-50 border-slate-100 text-slate-700',
                    'icon_bg' => 'bg-slate-200/60 text-slate-600',
                    'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                ],
                [
                    'label' => 'Diterima',
                    'value' => $summary['diterima'],
                    'bg' => 'bg-sky-50/50 border-sky-100 text-sky-800',
                    'icon_bg' => 'bg-sky-100 text-sky-600',
                    'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4'
                ],
                [
                    'label' => 'Diproses',
                    'value' => $summary['diproses'],
                    'bg' => 'bg-amber-50/50 border-amber-100 text-amber-800',
                    'icon_bg' => 'bg-amber-100 text-amber-600',
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
                [
                    'label' => 'Selesai',
                    'value' => $summary['selesai'],
                    'bg' => 'bg-emerald-50/50 border-emerald-100 text-emerald-800',
                    'icon_bg' => 'bg-emerald-100 text-emerald-600',
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5 flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $card['label'] }}</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">{{ number_format($card['value']) }}</h4>
                </div>
                <div class="w-12 h-12 rounded-xl {{ $card['icon_bg'] }} flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    {{-- FILTER & EXPORT BAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        {{-- Form Pencarian & Filter Status --}}
        <form method="GET" class="flex flex-col sm:flex-row gap-2.5 flex-1 min-w-0">
            <div class="relative flex-1 sm:max-w-md min-w-0">
                {{-- Input Pencarian dengan Padding Kiri pl-10 --}}
                {{-- Ganti class pl-10 menjadi pl-4 --}}
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode tiket atau pelapor..."
       class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
            </div>

            <select name="status" onchange="this.form.submit()"
                    class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition bg-white cursor-pointer">
                <option value="">Semua Status</option>
                @foreach (['diterima', 'diproses', 'selesai', 'ditolak'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.pengaduan.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tombol Export --}}
         <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            <a href="{{ route('admin.pengaduan.export.excel', request()->query()) }}"
             class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('admin.pengaduan.export.pdf', request()->query()) }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- TABEL PENGADUAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/60 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-5">Kode Tiket</th>
                        <th class="py-3 px-5">Judul Aduan</th>
                        <th class="py-3 px-5">Pelapor</th>
                        <th class="py-3 px-5">Kategori</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($pengaduans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            {{-- Kode Tiket --}}
                            <td class="py-3.5 px-5 font-mono text-xs font-semibold text-slate-600 whitespace-nowrap">
                                <span class="bg-slate-100 px-2 py-1 rounded-md">#{{ $item->kode_tiket }}</span>
                            </td>

                            {{-- Judul Aduan --}}
                            <td class="py-3.5 px-5 font-semibold text-slate-800 max-w-xs truncate" title="{{ $item->judul_aduan }}">
                                {{ $item->judul_aduan }}
                            </td>

                            {{-- Pelapor --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                @if ($item->is_anonim)
                                    <span class="inline-flex items-center gap-1 text-slate-500 font-medium text-xs bg-slate-100 px-2 py-0.5 rounded">
                                        🔒 Anonim
                                    </span>
                                @else
                                    <p class="font-semibold text-slate-700 text-xs">{{ $item->nama_pelapor }}</p>
                                @endif
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->no_hp }}</p>
                            </td>

                            {{-- Kategori --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-md bg-emerald-50 text-emerald-700 capitalize">
                                    {{ $item->kategori }}
                                </span>
                            </td>

                            {{-- Status & Warning --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium inline-block {{ $item->statusBadgeColor() }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                @if (! $item->notif_terakhir_dikirim)
                                    <span class="flex items-center gap-1 text-[10px] font-medium text-amber-600 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Belum dinotif
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Tombol Tangani / Detail --}}
                                    <a href="{{ route('admin.pengaduan.show', $item) }}"
                                       class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold transition"
                                       title="Tangani Aduan">
                                        Tangani
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    @if (auth()->user()->canApprove())
                                        <form action="{{ route('admin.pengaduan.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data pengaduan ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                    title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-sm">Belum ada pengaduan masuk.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($pengaduans->hasPages())
            <div class="px-4 sm:px-5 py-4 border-t border-slate-100 overflow-x-auto">
                <div class="min-w-max">
                    {{ $pengaduans->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

{{-- resources/views/admin/layanan-surat/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Layanan Surat')
@section('page-title', 'Layanan Surat')

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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                [
                    'label' => 'Total Pengajuan',
                    'value' => $summary['total'],
                    'icon_bg' => 'bg-slate-100 text-slate-600',
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                ],
                [
                    'label' => 'Diajukan',
                    'value' => $summary['diajukan'],
                    'icon_bg' => 'bg-sky-100 text-sky-600',
                    'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
                ],
                [
                    'label' => 'Diproses',
                    'value' => $summary['diproses'],
                    'icon_bg' => 'bg-amber-100 text-amber-600',
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
                [
                    'label' => 'Selesai',
                    'value' => $summary['selesai'],
                    'icon_bg' => 'bg-emerald-100 text-emerald-600',
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
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

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="flex flex-col sm:flex-row gap-2.5 flex-1 max-w-2xl">
                {{-- Input Tanpa Ikon dengan padding pl-4 --}}
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode tiket / nama pemohon..."
                           class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                </div>

                {{-- Filter Status --}}
                <select name="status" onchange="this.form.submit()"
                        class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition bg-white cursor-pointer">
                    <option value="">Semua Status</option>
                    @foreach (['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.layanan-surat.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABEL PENGAJUAN SURAT --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/60 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-5">Kode Tiket</th>
                        <th class="py-3 px-5">Jenis Surat</th>
                        <th class="py-3 px-5">Pemohon</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5">Tanggal</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($layananSurats as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            {{-- Kode Tiket --}}
                            <td class="py-3.5 px-5 font-mono text-xs font-semibold text-slate-600 whitespace-nowrap">
                                <span class="bg-slate-100 px-2 py-1 rounded-md">#{{ $item->kode_tiket }}</span>
                            </td>

                            {{-- Jenis Surat --}}
                            <td class="py-3.5 px-5 font-semibold text-slate-800">
                                {{ $item->jenis_surat }}
                            </td>

                            {{-- Pemohon --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <p class="font-semibold text-slate-700 text-xs">{{ $item->nama_pemohon }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->no_hp }}</p>
                            </td>

                            {{-- Status --}}
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium inline-block {{ $item->statusBadgeColor() }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-3.5 px-5 text-slate-500 text-xs whitespace-nowrap">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Tombol Proses --}}
                                    <a href="{{ route('admin.layanan-surat.show', $item) }}"
                                       class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold transition"
                                       title="Proses Surat">
                                        Proses
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    @if (auth()->user()->canApprove())
                                        <form action="{{ route('admin.layanan-surat.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data pengajuan surat ini? Tindakan ini tidak bisa dibatalkan.')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm">Belum ada pengajuan surat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($layananSurats->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $layananSurats->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

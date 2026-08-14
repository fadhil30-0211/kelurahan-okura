{{-- resources/views/admin/pengaduan/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Inbox Pengaduan')

@section('content')
<div class="space-y-5">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Aduan', 'value' => $summary['total'], 'color' => 'bg-slate-100 text-slate-700'],
                ['label' => 'Diterima', 'value' => $summary['diterima'], 'color' => 'bg-sky-50 text-sky-700'],
                ['label' => 'Diproses', 'value' => $summary['diproses'], 'color' => 'bg-amber-50 text-amber-700'],
                ['label' => 'Selesai', 'value' => $summary['selesai'], 'color' => 'bg-emerald-50 text-emerald-700'],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <div class="w-10 h-10 rounded-xl {{ $card['color'] }} flex items-center justify-center text-sm font-bold mb-2">
                    {{ $card['value'] }}
                </div>
                <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filter & Export --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode tiket / nama pelapor..."
                   class="flex-1 max-w-sm px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="">Semua Status</option>
                @foreach (['diterima', 'diproses', 'selesai', 'ditolak'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pengaduan.export.excel', request()->query()) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold">
                Export Excel
            </a>
            <a href="{{ route('admin.pengaduan.export.pdf', request()->query()) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                Export PDF
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Kode Tiket</th>
                        <th class="text-left px-5 py-3 font-medium">Judul Aduan</th>
                        <th class="text-left px-5 py-3 font-medium">Pelapor</th>
                        <th class="text-left px-5 py-3 font-medium">Kategori</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pengaduans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $item->kode_tiket }}</td>
                            <td class="px-5 py-3.5 text-slate-700 max-w-xs truncate">{{ $item->judul_aduan }}</td>

                            {{-- Pelapor --}}
                            <td class="px-5 py-3.5">
                                @if ($item->is_anonim)
                                    <span class="inline-flex items-center gap-1 text-slate-500 font-medium">
                                        🔒 Anonim
                                    </span>
                                @else
                                    <p class="text-slate-700">{{ $item->nama_pelapor }}</p>
                                @endif
                                <p class="text-xs text-slate-400">{{ $item->no_hp }}</p>
                            </td>

                            <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $item->kategori }}</td>

                            {{-- Status + Warning Notif --}}
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->statusBadgeColor() }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                @if (! $item->notif_terakhir_dikirim)
                                    <span class="block text-[10px] text-amber-600 mt-1">⚠ Belum dinotif</span>
                                @endif
                            </td>

                            {{-- Kolom Aksi (Tangani & Hapus) --}}
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.pengaduan.show', $item) }}" class="text-xs font-medium text-emerald-600 hover:underline">Tangani</a>

                                    @if (auth()->user()->canApprove())
                                        <form action="{{ route('admin.pengaduan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengaduan ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-10 text-slate-400 text-sm">Belum ada pengaduan masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pengaduans->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $pengaduans->links() }}</div>
        @endif
    </div>
</div>
@endsection

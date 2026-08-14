{{-- resources/views/admin/layanan-surat/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Layanan Surat')

@section('content')
<div class="space-y-5">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Total Pengajuan', 'value' => $summary['total'], 'color' => 'bg-slate-100 text-slate-700'],
                ['label' => 'Diajukan', 'value' => $summary['diajukan'], 'color' => 'bg-sky-50 text-sky-700'],
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

    {{-- Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode tiket / nama pemohon..."
                   class="flex-1 max-w-sm px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="">Semua Status</option>
                @foreach (['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tabel Pengajuan Surat --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Kode Tiket</th>
                        <th class="text-left px-5 py-3 font-medium">Jenis Surat</th>
                        <th class="text-left px-5 py-3 font-medium">Pemohon</th>
                        <th class="text-left px-5 py-3 font-medium">Status</th>
                        <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($layananSurats as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $item->kode_tiket }}</td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $item->jenis_surat }}</td>
                            <td class="px-5 py-3.5">
                                <p class="text-slate-700">{{ $item->nama_pemohon }}</p>
                                <p class="text-xs text-slate-400">{{ $item->no_hp }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->statusBadgeColor() }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $item->created_at->format('d M Y') }}</td>

                            {{-- Kolom Aksi (Proses & Hapus) --}}
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.layanan-surat.show', $item) }}" class="text-xs font-medium text-emerald-600 hover:underline">Proses</a>

                                    @if (auth()->user()->canApprove())
                                        <form action="{{ route('admin.layanan-surat.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengajuan surat ini? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-10 text-slate-400 text-sm">Belum ada pengajuan surat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($layananSurats->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $layananSurats->links() }}</div>
        @endif
    </div>
</div>
@endsection

{{-- resources/views/admin/survei/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Survei Kepuasan Masyarakat')

@section('content')
<div class="space-y-5">
    {{-- Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center">
            <p class="text-4xl font-bold text-amber-500">{{ number_format($rataRata ?? 0, 1) }}</p>
            <div class="flex justify-center gap-0.5 my-2">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($rataRata ?? 0) ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.956a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.287 3.955c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.539-1.118l1.287-3.955a1 1 0 00-.363-1.118L2.813 9.383c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.956z"/>
                    </svg>
                @endfor
            </div>
            <p class="text-xs text-slate-400">Rata-rata dari {{ $totalResponden }} responden</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <p class="text-xs font-semibold text-slate-600 mb-3">Distribusi Rating</p>
            @for ($i = 5; $i >= 1; $i--)
                @php $jumlah = $distribusi[$i] ?? 0; $persen = $totalResponden ? round($jumlah / $totalResponden * 100) : 0; @endphp
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-xs text-slate-500 w-3">{{ $i }}</span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-400" style="width: {{ $persen }}%"></div>
                    </div>
                    <span class="text-xs text-slate-400 w-8">{{ $jumlah }}</span>
                </div>
            @endfor
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex gap-2">
        <select name="layanan" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">Semua Layanan</option>
            <option value="umum" {{ request('layanan') == 'umum' ? 'selected' : '' }}>Pelayanan Umum</option>
            <option value="surat" {{ request('layanan') == 'surat' ? 'selected' : '' }}>Layanan Surat</option>
            <option value="aduan" {{ request('layanan') == 'aduan' ? 'selected' : '' }}>Pengaduan</option>
            <option value="wisata" {{ request('layanan') == 'wisata' ? 'selected' : '' }}>Wisata</option>
            <option value="umkm" {{ request('layanan') == 'umkm' ? 'selected' : '' }}>UMKM</option>
        </select>
    </form>

    {{-- Tabel Detail --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Nama</th>
                        <th class="text-left px-5 py-3 font-medium">Rating</th>
                        <th class="text-left px-5 py-3 font-medium">Layanan</th>
                        <th class="text-left px-5 py-3 font-medium">Saran</th>
                        <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($surveis as $survei)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 text-slate-700">{{ $survei->nama ?? 'Anonim' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="text-amber-500 font-semibold">{{ $survei->rating }} ★</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $survei->layanan_terkait ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-500 max-w-xs truncate">{{ $survei->saran ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $survei->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-slate-400 text-sm">Belum ada data survei.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($surveis->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $surveis->links() }}</div>
        @endif
    </div>
</div>
@endsection

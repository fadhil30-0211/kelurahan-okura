{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ============ SUMMARY CARDS ============ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Aduan Baru', 'value' => $summary['pengaduan_masuk'], 'sub' => $summary['pengaduan_proses'].' sedang diproses', 'color' => 'bg-amber-50 text-amber-700', 'route' => 'admin.pengaduan.index'],
                ['label' => 'Surat Diajukan', 'value' => $summary['surat_diajukan'], 'sub' => $summary['surat_proses'].' sedang diproses', 'color' => 'bg-sky-50 text-sky-700', 'route' => 'admin.layanan-surat.index'],
                ['label' => 'Berita', 'value' => $summary['total_berita'], 'sub' => $summary['berita_published'].' sudah publish', 'color' => 'bg-emerald-50 text-emerald-700', 'route' => 'admin.berita.index'],
                ['label' => 'Wisata & UMKM', 'value' => $summary['total_wisata'] + $summary['total_umkm'], 'sub' => $summary['total_wisata'].' wisata, '.$summary['total_umkm'].' UMKM', 'color' => 'bg-rose-50 text-rose-700', 'route' => 'admin.wisata.index'],
            ];
        @endphp

        @foreach ($cards as $card)
            <a href="{{ route($card['route']) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-md p-5 border border-slate-100 transition">
                <div class="w-10 h-10 rounded-xl {{ $card['color'] }} flex items-center justify-center text-sm font-bold mb-3">
                    {{ $card['value'] }}
                </div>
                <p class="text-sm font-semibold text-slate-800">{{ $card['label'] }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $card['sub'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- ============ CHARTS ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-4 text-sm">Aduan Masuk (7 Hari Terakhir)</h3>
            <canvas id="chartAduan" height="90"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-4 text-sm">Kategori Aduan</h3>
            <canvas id="chartKategori" height="200"></canvas>
        </div>
    </div>

    {{-- ============ TABEL TERBARU ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Pengaduan Terbaru</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs text-emerald-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse ($pengaduanTerbaru as $item)
                    <a href="{{ route('admin.pengaduan.show', $item) }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $item->judul_aduan }}</p>
                            <p class="text-xs text-slate-400">{{ $item->nama_pelapor }} · {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </a>
                @empty
                    <p class="text-sm text-slate-400 text-center py-8">Belum ada pengaduan masuk.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Pengajuan Surat Terbaru</h3>
                <a href="{{ route('admin.layanan-surat.index') }}" class="text-xs text-emerald-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse ($suratTerbaru as $item)
                    <a href="{{ route('admin.layanan-surat.show', $item) }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $item->jenis_surat }}</p>
                            <p class="text-xs text-slate-400">{{ $item->nama_pemohon }} · {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </a>
                @empty
                    <p class="text-sm text-slate-400 text-center py-8">Belum ada pengajuan surat.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('chartAduan'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Aduan',
                data: @json($chartData),
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: @json($kategoriAduan->keys()),
            datasets: [{
                data: @json($kategoriAduan->values()),
                backgroundColor: ['#059669', '#D97706', '#0284C7', '#DC2626', '#7C3AED'],
                borderWidth: 0,
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });
</script>
@endpush

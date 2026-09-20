@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Page -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Transparansi Anggaran & Keuangan
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                Laporan Keterbukaan Anggaran Pendapatan dan Belanja Kelurahan Tahun {{ $tahunPilihan }}
            </p>
        </div>

        <!-- Filter Tahun & Ringkasan Utama -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <!-- Filter Tahun -->
            <form method="GET" action="{{ route('transparansi.index') }}" class="flex items-center gap-2">
                <label for="tahun" class="text-sm font-medium text-gray-700">Pilih Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" class="rounded-lg border-gray-300 border px-3 py-2 text-gray-700 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahunPilihan == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('transparansi.download-pdf', $tahunPilihan) }}" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium text-sm rounded-lg shadow transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Laporan LPP (PDF)
            </a>
        </div>

        <!-- Card Stat Ringkasan APBD -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Pendapatan -->
            <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-sm relative overflow-hidden">
                <div class="text-emerald-600 font-semibold text-sm">TOTAL PENDAPATAN</div>
                <div class="text-3xl font-extrabold text-emerald-900 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="mt-4 text-xs text-emerald-600 flex items-center gap-1">
                    <span class="font-bold">{{ $persenPendapatan }}%</span> terealisasi dari target
                </div>
            </div>

            <!-- Belanja/Pengeluaran -->
            <div class="bg-white rounded-2xl p-6 border border-rose-100 shadow-sm relative overflow-hidden">
                <div class="text-rose-600 font-semibold text-sm">TOTAL BELANJA</div>
                <div class="text-3xl font-extrabold text-rose-900 mt-2">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
                <div class="mt-4 text-xs text-rose-600 flex items-center gap-1">
                    <span class="font-bold">{{ $persenBelanja }}%</span> terpakai dari anggaran
                </div>
            </div>

            <!-- Pembiayaan / Sisa -->
            <div class="bg-white rounded-2xl p-6 border border-amber-100 shadow-sm relative overflow-hidden">
                <div class="text-amber-600 font-semibold text-sm">SILPA / SISA ANGGARAN</div>
                <div class="text-3xl font-extrabold text-amber-900 mt-2">Rp {{ number_format($silpa, 0, ',', '.') }}</div>
                <div class="mt-4 text-xs text-amber-600">
                    Sisa Lebih Pembiayaan Anggaran
                </div>
            </div>
        </div>

        <!-- Visualisasi Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Doughnut Chart: Proporsi Belanja -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Proporsi Alokasi Belanja</h3>
                <div class="relative h-64">
                    <canvas id="chartProporsiBelanja"></canvas>
                </div>
            </div>

            <!-- Bar Chart: Realisasi vs Target -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Realisasi per Kategori Program</h3>
                <div class="relative h-64">
                    <canvas id="chartRealisasi"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Detail -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ tab: 'belanja' }">
            <div class="border-b border-gray-200 px-6 py-4 flex gap-4 bg-gray-50/50">
                <button @click="tab = 'belanja'" :class="tab === 'belanja' ? 'border-amber-600 text-amber-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-2 border-b-2 transition">Rincian Belanja</button>
                <button @click="tab = 'pendapatan'" :class="tab === 'pendapatan' ? 'border-amber-600 text-amber-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-2 border-b-2 transition">Rincian Pendapatan</button>
            </div>

            <!-- Tabel Belanja -->
            <div x-show="tab === 'belanja'" class="overflow-x-auto p-6">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Kategori / Program</th>
                            <th class="py-3 px-4">Anggaran</th>
                            <th class="py-3 px-4">Realisasi</th>
                            <th class="py-3 px-4">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($detailBelanja as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $item->kategori }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @php $pct = $item->anggaran > 0 ? round(($item->realisasi / $item->anggaran) * 100, 1) : 0; @endphp
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-500 h-2 rounded-full" style="width: {{ min($pct, 100) }}%"></div>
                                    </div>
                                    <span>{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tabel Pendapatan -->
            <div x-show="tab === 'pendapatan'" class="overflow-x-auto p-6" x-cloak>
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="py-3 px-4">Sumber Pendapatan</th>
                            <th class="py-3 px-4">Target</th>
                            <th class="py-3 px-4">Realisasi</th>
                            <th class="py-3 px-4">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($detailPendapatan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $item->sumber }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($item->target, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @php $pct = $item->target > 0 ? round(($item->realisasi / $item->target) * 100, 1) : 0; @endphp
                                <span>{{ $pct }}%</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Doughnut Chart (Proporsi Belanja)
        const ctxDoughnut = document.getElementById('chartProporsiBelanja');
        if (ctxDoughnut) {
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: @json($detailBelanja->pluck('kategori')),
                    datasets: [{
                        data: @json($detailBelanja->pluck('realisasi')),
                        backgroundColor: ['#D97706', '#059669', '#2563EB', '#7C3AED', '#DC2626', '#6B7280'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Bar Chart (Realisasi vs Anggaran)
        const ctxBar = document.getElementById('chartRealisasi');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($detailBelanja->pluck('kategori')),
                    datasets: [
                        {
                            label: 'Anggaran',
                            data: @json($detailBelanja->pluck('anggaran')),
                            backgroundColor: '#E5E7EB',
                            borderRadius: 4
                        },
                        {
                            label: 'Realisasi',
                            data: @json($detailBelanja->pluck('realisasi')),
                            backgroundColor: '#D97706',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                callback: (v) => 'Rp' + (v >= 1000000 ? (v/1000000) + 'jt' : v)
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

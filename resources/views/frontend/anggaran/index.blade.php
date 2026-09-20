@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-slate-50/60 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- 1. HEADER & FILTER TAHUN --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1.5 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Portal Transparansi Publik
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Transparansi Anggaran
                </h1>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Informasi terbuka alokasi dan realisasi anggaran Kelurahan untuk mewujudkan tata kelola keuangan yang akuntabel.
                </p>
            </div>

            {{-- Selector Tahun --}}
            <div class="flex items-center gap-2 bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/60 self-start md:self-center">
                <span class="text-xs font-semibold text-slate-500 px-2 uppercase tracking-wider hidden sm:inline">Tahun:</span>
                <div class="flex items-center gap-1">
                    @foreach ($tahunList as $t)
                        <a href="{{ route('transparansi.index', ['tahun' => $t]) }}"
                           class="px-4 py-2 rounded-lg text-xs font-bold transition-all duration-150 {{ $t == $tahunSelected ? 'bg-white text-emerald-700 shadow-sm border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }}">
                            {{ $t }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 2. STATISTIK RINGKAS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Card Total Pagu --}}
            <div class="lg:col-span-2 bg-emerald-600 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

                <div>
                    <span class="text-emerald-100 text-xs font-semibold tracking-wider uppercase">
                        Total Pagu Anggaran {{ $tahunSelected }}
                    </span>
                    <div class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white mt-2">
                        Rp {{ number_format($totalAnggaran, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/15 flex flex-wrap items-center justify-between gap-3 text-xs text-emerald-50">
                    <div class="inline-flex items-center gap-1.5 bg-black/10 px-3 py-1 rounded-lg backdrop-blur-sm">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Status: <strong class="text-white">Resmi & Ditetapkan</strong></span>
                    </div>
                    <span>Terdistribusi ke <strong class="text-white">{{ $dataAnggaran->count() }} Pos Anggaran</strong></span>
                </div>
            </div>

            {{-- Card Ringkasan Analisis --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-4">
                <div>
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                        Analisis Alokasi
                    </h2>

                    <div class="space-y-3">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs text-slate-500 font-medium block">Rata-rata per Pos</span>
                            <span class="text-base font-bold text-slate-800 mt-0.5 block">
                                Rp {{ $dataAnggaran->count() > 0 ? number_format($totalAnggaran / $dataAnggaran->count(), 0, ',', '.') : '0' }}
                            </span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs text-slate-500 font-medium block">Jumlah Pos Anggaran</span>
                            <span class="text-base font-bold text-slate-800 mt-0.5 block">
                                {{ $dataAnggaran->count() }} Kategori Kegiatan
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-slate-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Data bersumber langsung dari Laporan Kelurahan</span>
                </div>
            </div>

        </div>

        {{-- 3. TABEL RINCIAN --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Rincian Pos Anggaran</h2>
                    <p class="text-xs text-slate-500">Tahun Anggaran {{ $tahunSelected }}</p>
                </div>
                <span class="text-xs font-medium text-slate-600 bg-white px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs self-start sm:self-auto">
                    Mata Uang: IDR (Rupiah)
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold tracking-wider border-b border-slate-200/80">
                            <th class="py-3.5 px-5 w-12 text-center">No</th>
                            <th class="py-3.5 px-5">Kategori Pos</th>
                            <th class="py-3.5 px-5">Keterangan / Rincian</th>
                            <th class="py-3.5 px-5 w-44">Proporsi Pagu</th>
                            <th class="py-3.5 px-5 text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                        @forelse ($dataAnggaran as $index => $item)
                            @php
                                $persentase = $totalAnggaran > 0 ? ($item->jumlah / $totalAnggaran) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5 text-center font-mono text-xs text-slate-400 font-semibold">
                                    {{ sprintf('%02d', $index + 1) }}
                                </td>
                                <td class="py-3.5 px-5 font-semibold text-slate-800">
                                    {{ $item->kategori }}
                                </td>
                                <td class="py-3.5 px-5 text-slate-500 text-xs leading-relaxed max-w-xs">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: {{ $persentase }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600 w-10 text-right">{{ number_format($persentase, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-right font-bold text-slate-900 whitespace-nowrap">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="font-semibold text-slate-700 text-sm">Belum Ada Data</p>
                                        <p class="text-slate-400 text-xs">Data anggaran untuk tahun {{ $tahunSelected }} belum tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

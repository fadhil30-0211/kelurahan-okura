@extends('layouts.admin')

@section('page-title', 'Janji Temu')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Janji Temu
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Kelola pengajuan janji temu warga dengan Lurah.
        </p>
    </div>

    {{-- Alert Success / Danger (Jika Ada Flash Message) --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200/80 rounded-xl text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

        @php
            $borderColors = [
                'total' => 'border-t-slate-400',
                'menunggu' => 'border-t-amber-400',
                'disetujui' => 'border-t-emerald-500',
                'ditolak' => 'border-t-rose-500',
                'selesai' => 'border-t-sky-500',
            ];
        @endphp

        @foreach([
            'total' => 'Total',
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
        ] as $key => $label)

            <div class="bg-white rounded-2xl border border-slate-100 border-t-4 {{ $borderColors[$key] ?? 'border-t-slate-300' }} shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    {{ $label }}
                </p>

                <p class="text-2xl font-bold text-slate-800 mt-2">
                    {{ number_format($summary[$key], 0, ',', '.') }}
                </p>
            </div>

        @endforeach

    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">

        <form method="GET"
              action="{{ route(
                  auth()->user()->role === 'staf'
                      ? 'staf.janji-temu.index'
                      : 'admin.janji-temu.index'
              ) }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-3">

            {{-- Input Search dengan Inline Style Padding Terkunci --}}
            <div class="relative w-full flex items-center">
                <div class="absolute left-4 pointer-events-none text-slate-400 z-10 flex items-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kode, nama, atau nomor HP..."
                    style="padding-left: 2.75rem !important;"
                    class="w-full py-2.5 pr-4 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            </div>

            <select
                name="status"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">

                <option value="">Semua Status</option>

                <option value="menunggu" @selected(request('status') === 'menunggu')}>
                    Menunggu
                </option>

                <option value="disetujui" @selected(request('status') === 'disetujui')}>
                    Disetujui
                </option>

                <option value="ditolak" @selected(request('status') === 'ditolak')}>
                    Ditolak
                </option>

                <option value="selesai" @selected(request('status') === 'selesai')}>
                    Selesai
                </option>

            </select>

            <button
                type="submit"
                class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold shadow-sm transition-all flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
            </button>

        </form>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800">
                Daftar Pengajuan Janji Temu
            </h2>
            <span class="text-xs text-slate-400 font-medium">
                Total: {{ $janjiTemus->total() }} Data
            </span>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-slate-50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                    <tr>

                        <th class="px-5 py-3.5">
                            Kode Tiket
                        </th>

                        <th class="px-5 py-3.5">
                            Pemohon
                        </th>

                        <th class="px-5 py-3.5">
                            Tanggal
                        </th>

                        <th class="px-5 py-3.5">
                            Waktu
                        </th>

                        <th class="px-5 py-3.5">
                            Status
                        </th>

                        <th class="px-5 py-3.5 text-right">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($janjiTemus as $janjiTemu)

                        <tr class="hover:bg-slate-50/70 transition-colors">

                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-lg font-mono text-xs font-bold">
                                    {{ $janjiTemu->kode_tiket }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $janjiTemu->nama_pemohon }}
                                </p>

                                <p class="text-xs text-slate-400 mt-0.5 flex items-center space-x-1">
                                    <svg class="w-3 h-3 text-slate-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $janjiTemu->no_hp }}</span>
                                </p>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-slate-600 font-medium">
                                {{ $janjiTemu->tanggal_diinginkan?->translatedFormat('d F Y') ?? '-' }}
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-slate-600 font-medium">
                                {{ $janjiTemu->waktu_diinginkan ?: '-' }}
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap">

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $janjiTemu->statusBadgeColor() }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-current"></span>
                                    {{ ucfirst($janjiTemu->status) }}
                                </span>

                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-right">
                                <div class="inline-flex items-center justify-end space-x-2">
                                    {{-- Tombol Detail --}}
                                    <a
                                        href="{{ route(
                                            auth()->user()->role === 'staf'
                                                ? 'staf.janji-temu.show'
                                                : 'admin.janji-temu.show',
                                            $janjiTemu
                                        ) }}"
                                        class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 hover:border-emerald-200 font-medium text-xs transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form
                                        action="{{ route(
                                            auth()->user()->role === 'staf'
                                                ? 'staf.janji-temu.destroy'
                                                : 'admin.janji-temu.destroy',
                                            $janjiTemu
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data janji temu ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 hover:text-rose-600 hover:bg-rose-50 hover:border-rose-200 font-medium text-xs transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-5 py-12 text-center text-slate-400">
                                Belum ada pengajuan janji temu.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $janjiTemus->links() }}
        </div>

    </div>

</div>

@endsection

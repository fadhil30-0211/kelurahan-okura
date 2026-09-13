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

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

        @foreach([
            'total' => 'Total',
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
        ] as $key => $label)

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <p class="text-xs text-slate-500">
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

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kode, nama, atau nomor HP..."
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >

            <select
                name="status"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">

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
                class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Filter
            </button>

        </form>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">
                Daftar Pengajuan Janji Temu
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50">
                    <tr class="text-left text-slate-500">

                        <th class="px-5 py-3">
                            Kode Tiket
                        </th>

                        <th class="px-5 py-3">
                            Pemohon
                        </th>

                        <th class="px-5 py-3">
                            Tanggal
                        </th>

                        <th class="px-5 py-3">
                            Waktu
                        </th>

                        <th class="px-5 py-3">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($janjiTemus as $janjiTemu)

                        <tr class="hover:bg-slate-50">

                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-semibold text-emerald-700">
                                    {{ $janjiTemu->kode_tiket }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ $janjiTemu->nama_pemohon }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $janjiTemu->no_hp }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $janjiTemu->tanggal_diinginkan?->translatedFormat('d F Y') ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $janjiTemu->waktu_diinginkan ?: '-' }}
                            </td>

                            <td class="px-5 py-4">

                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $janjiTemu->statusBadgeColor() }}">
                                    {{ ucfirst($janjiTemu->status) }}
                                </span>

                            </td>

                            <td class="px-5 py-4 text-right">

                                <a
                                    href="{{ route(
                                        auth()->user()->role === 'staf'
                                            ? 'staf.janji-temu.show'
                                            : 'admin.janji-temu.show',
                                        $janjiTemu
                                    ) }}"
                                    class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm">
                                    Detail
                                </a>

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

        <div class="px-5 py-4 border-t border-slate-100">
            {{ $janjiTemus->links() }}
        </div>

    </div>

</div>

@endsection
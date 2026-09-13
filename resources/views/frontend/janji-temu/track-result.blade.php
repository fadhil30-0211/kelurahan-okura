@extends('layouts.frontend')

@section('title', 'Status Janji Temu')

@section('content')

<section class="pt-28 pb-16 min-h-screen bg-slate-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8">
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold mb-3">
                Status Pengajuan
            </span>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]">
                Status Janji Temu
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Berikut informasi terbaru mengenai pengajuan janji temu Anda.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">

            <div class="bg-[#0B1F3A] px-6 py-5 text-center">
                <p class="text-xs text-slate-300">
                    Kode Tiket
                </p>

                <p class="font-mono text-xl sm:text-2xl font-bold text-white mt-1 tracking-wider">
                    {{ $janjiTemu->kode_tiket }}
                </p>
            </div>

            <div class="p-6 sm:p-8 space-y-5">

                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Nama Pemohon
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $janjiTemu->nama_pemohon }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Keperluan
                    </p>

                    <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 leading-relaxed">
                        {{ $janjiTemu->keperluan }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <p class="text-xs text-slate-400 mb-1">
                            Tanggal
                        </p>

                        <p class="text-sm font-medium text-slate-700">
                            {{ $janjiTemu->tanggal_diinginkan?->translatedFormat('d F Y') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400 mb-1">
                            Waktu
                        </p>

                        <p class="text-sm font-medium text-slate-700">
                            {{ $janjiTemu->waktu_diinginkan ?: '-' }}
                        </p>
                    </div>

                </div>

                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">
                        Status
                    </span>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $janjiTemu->statusBadgeColor() }}">
                        {{ ucfirst($janjiTemu->status) }}
                    </span>
                </div>

                @if ($janjiTemu->catatan_admin)
                    <div>
                        <p class="text-xs text-slate-400 mb-1">
                            Catatan Petugas
                        </p>

                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-sm text-slate-700 leading-relaxed">
                            {{ $janjiTemu->catatan_admin }}
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3">

                    <a
                        href="{{ route('janji-temu.track.form') }}"
                        class="flex items-center justify-center py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition">
                        Lacak Janji Temu Lain
                    </a>

                    <a
                        href="{{ route('home') }}"
                        class="flex items-center justify-center py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Kembali ke Beranda
                    </a>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
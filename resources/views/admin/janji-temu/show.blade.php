@extends('layouts.admin')

@section('page-title', 'Detail Janji Temu')

@section('content')

<div class="max-w-3xl space-y-6">

    <div>
        <a
            href="{{ route(
                auth()->user()->role === 'staf'
                    ? 'staf.janji-temu.index'
                    : 'admin.janji-temu.index'
            ) }}"
            class="text-sm text-slate-400 hover:text-emerald-600">
            ← Kembali ke Janji Temu
        </a>

        <h1 class="text-2xl font-bold text-slate-800 mt-3">
            Detail Janji Temu
        </h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

        <div class="space-y-4 text-sm">

            <div class="flex justify-between gap-4">
                <span class="text-slate-400">Kode Tiket</span>

                <span class="font-mono font-bold text-emerald-700">
                    {{ $janjiTemu->kode_tiket }}
                </span>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-400">Nama Pemohon</span>

                <span class="font-medium text-slate-700">
                    {{ $janjiTemu->nama_pemohon }}
                </span>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-400">Nomor HP</span>

                <span class="font-medium text-slate-700">
                    {{ $janjiTemu->no_hp }}
                </span>
            </div>

            <div>
                <p class="text-slate-400 mb-1">
                    Keperluan
                </p>

                <p class="text-slate-700 leading-relaxed">
                    {{ $janjiTemu->keperluan }}
                </p>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-400">Tanggal</span>

                <span class="font-medium text-slate-700">
                    {{ $janjiTemu->tanggal_diinginkan?->translatedFormat('d F Y') ?? '-' }}
                </span>
            </div>

            <div class="flex justify-between gap-4">
                <span class="text-slate-400">Waktu</span>

                <span class="font-medium text-slate-700">
                    {{ $janjiTemu->waktu_diinginkan ?: '-' }}
                </span>
            </div>

            <div class="flex justify-between items-center gap-4">
                <span class="text-slate-400">
                    Status
                </span>

                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $janjiTemu->statusBadgeColor() }}">
                    {{ ucfirst($janjiTemu->status) }}
                </span>
            </div>

        </div>

    </div>

    @if (auth()->user()->isSuperAdmin())

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

            <h2 class="font-semibold text-slate-800 mb-4">
                Proses Janji Temu
            </h2>

            <form
                action="{{ route('admin.janji-temu.update', $janjiTemu) }}"
                method="POST"
                class="space-y-5">

                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200">

                        @foreach([
                            'menunggu',
                            'disetujui',
                            'ditolak',
                            'selesai',
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected($janjiTemu->status === $status)>
                                {{ ucfirst($status) }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Catatan
                    </label>

                    <textarea
                        name="catatan_admin"
                        rows="4"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200"
                        placeholder="Tambahkan catatan untuk pemohon...">{{ old('catatan_admin', $janjiTemu->catatan_admin) }}</textarea>
                </div>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                    Simpan Perubahan
                </button>

            </form>

        </div>

    @endif

</div>

@endsection
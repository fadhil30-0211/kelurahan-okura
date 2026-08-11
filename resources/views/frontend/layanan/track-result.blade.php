{{-- resources/views/frontend/pengaduan/track-result.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Lacak Pengaduan')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">
    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs text-slate-400">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-[#0B1F3A]">{{ $surat->kode_tiket }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $surat->statusBadgeColor() }}">
                {{ ucfirst($surat->status) }}
            </span>
        </div>

        <h2 class="font-semibold text-slate-800 mb-1">{{ $surat->judul_surat }}</h2>
        <p class="text-sm text-slate-500 mb-6">{{ $surat->isi_surat }}</p>

                @if ($surat->status === 'selesai' && $surat->file_hasil)
            <a href="{{ asset('storage/' . $surat->file_hasil) }}" target="_blank"
            class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Unduh Surat (PDF)
            </a>
        @endif

    </div>
</section>
@endsection

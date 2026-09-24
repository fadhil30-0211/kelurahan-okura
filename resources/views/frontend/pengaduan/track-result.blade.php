{{-- resources/views/frontend/pengaduan/track-result.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Lacak Pengaduan')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">
    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs text-slate-400">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-[#0B1F3A]">{{ $pengaduan->kode_tiket }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $pengaduan->statusBadgeColor() }}">
                {{ ucfirst($pengaduan->status) }}
            </span>
        </div>

        <h2 class="font-semibold text-slate-800 mb-1">{{ $pengaduan->judul_aduan }}</h2>
        <p class="text-sm text-slate-500 mb-6">{{ $pengaduan->isi_aduan }}</p>

        @if ($pengaduan->tanggapan_admin)
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                <p class="text-xs font-semibold text-emerald-700 mb-1">Tanggapan Petugas</p>
                <p class="text-sm text-emerald-800">{{ $pengaduan->tanggapan_admin }}</p>
                <p class="text-xs text-emerald-600 mt-2">{{ $pengaduan->tanggal_tanggapan?->translatedFormat('d F Y, H:i') }}</p>
            </div>
        @else
            <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-500">
                Pengaduan Anda sedang ditinjau oleh petugas kelurahan.
            </div>
        @endif

        <p class="text-xs text-slate-400 mt-6">Dilaporkan pada {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }}</p>
    </div>
</section>
@endsection

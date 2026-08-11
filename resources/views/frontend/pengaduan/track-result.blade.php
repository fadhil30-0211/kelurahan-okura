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

{{-- resources/views/frontend/layanan/track-result.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Hasil Lacak Surat')

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

        <h2 class="font-semibold text-slate-800 mb-1">{{ $surat->jenis_surat }}</h2>
        <p class="text-sm text-slate-500 mb-6">{{ $surat->keperluan }}</p>

        @if ($surat->catatan_admin)
            <div class="bg-slate-50 rounded-xl p-4 mb-4">
                <p class="text-xs font-semibold text-slate-600 mb-1">Catatan Petugas</p>
                <p class="text-sm text-slate-700">{{ $surat->catatan_admin }}</p>
            </div>
        @endif

        @if ($surat->status === 'selesai' && $surat->file_hasil)
            <a href="{{ asset('storage/' . $surat->file_hasil) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Unduh Surat (PDF)
            </a>
        @else
            <div class="bg-amber-50 rounded-xl p-4 text-sm text-amber-700">
                Surat Anda sedang diproses oleh petugas kelurahan.
            </div>
        @endif

        <p class="text-xs text-slate-400 mt-6">Diajukan pada {{ $surat->created_at->translatedFormat('d F Y, H:i') }}</p>
    </div>
</section>
@endsection

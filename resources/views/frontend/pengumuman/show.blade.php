{{-- resources/views/frontend/pengumuman/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $pengumuman->judul)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        @php
            $kategoriColor = match($pengumuman->kategori) {
                'darurat' => 'bg-red-50 text-red-700 border-red-100',
                'penting' => 'bg-amber-50 text-amber-700 border-amber-100',
                default => 'bg-slate-50 text-slate-600 border-slate-100',
            };
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border {{ $kategoriColor }} mb-4">
                {{ ucfirst($pengumuman->kategori) }}
            </span>

            <h1 class="text-2xl font-bold text-[#0B1F3A] mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                {{ $pengumuman->judul }}
            </h1>
            <p class="text-xs text-slate-400 mb-6">
                Berlaku sejak {{ $pengumuman->tanggal_mulai->translatedFormat('d F Y') }}
                @if ($pengumuman->tanggal_selesai)
                    hingga {{ $pengumuman->tanggal_selesai->translatedFormat('d F Y') }}
                @endif
            </p>

            <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $pengumuman->isi }}
            </div>

            @if ($pengumuman->file_lampiran)
                <a href="{{ asset('storage/'.$pengumuman->file_lampiran) }}" target="_blank"
                   class="inline-flex items-center gap-2 mt-6 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                    📎 Lihat Lampiran
                </a>
            @endif
        </div>

        <a href="{{ route('pengumuman.index') }}" class="inline-block mt-6 text-sm text-slate-400 hover:text-emerald-600">
            ← Kembali ke Daftar Pengumuman
        </a>
    </div>
</section>
@endsection

{{-- resources/views/frontend/search.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <h1 class="text-2xl font-bold text-[#0B1F3A] mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Hasil Pencarian
        </h1>
        <p class="text-sm text-slate-500 mb-8">
            {{ $totalResults }} hasil ditemukan untuk "<span class="font-medium text-slate-700">{{ $keyword }}</span>"
        </p>

        @if ($totalResults === 0)
            <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center">
                <p class="text-slate-400 text-sm">Tidak ada hasil ditemukan. Coba kata kunci lain seperti "SKTM", "wisata", atau "UMKM".</p>
            </div>
        @endif

        @if ($beritas->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">📰 Berita ({{ $beritas->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($beritas as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition">
                            <p class="text-sm font-medium text-slate-800 line-clamp-2">{{ $item->judul }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $item->published_at->format('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($wisatas->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">🏞️ Wisata ({{ $wisatas->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($wisatas as $item)
                        <a href="{{ route('wisata.show', $item->slug) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition">
                            <p class="text-sm font-medium text-slate-800">{{ $item->nama }}</p>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ $item->alamat }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($umkms->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">🛍️ UMKM ({{ $umkms->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($umkms as $item)
                        <a href="{{ route('umkm.show', $item->id) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition">
                            <p class="text-sm font-medium text-slate-800">{{ $item->nama_usaha }}</p>
                            <p class="text-xs text-slate-400 mt-1 capitalize">{{ $item->kategori }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

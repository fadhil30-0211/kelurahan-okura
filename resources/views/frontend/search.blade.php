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
            <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center shadow-sm">
                <p class="text-slate-500 text-sm">Tidak ada hasil ditemukan. Coba kata kunci lain seperti "SKTM", "wisata", atau "UMKM".</p>
            </div>
        @endif

        {{-- 1. HASIL LAYANAN & PERSYARATAN SURAT --}}
        @if (isset($layananSurats) && $layananSurats->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">📄 Layanan & Persyaratan Surat ({{ $layananSurats->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($layananSurats as $item)
                        <a href="{{ route('layanan.index') }}#layanan-{{ $item->id }}" class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition block">
                            <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-medium border border-emerald-200 inline-block mb-2">
                                {{ $item->jenis_surat ?? $item->jenis ?? 'Layanan' }}
                            </span>
                            <h3 class="text-base font-semibold text-slate-800">
                                {{ $item->nama_surat ?? $item->nama_layanan ?? $item->nama ?? $item->judul ?? 'Layanan Surat' }}
                            </h3>
                            @if(!empty($item->persyaratan) || !empty($item->deskripsi))
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                    <strong>Persyaratan:</strong> {{ strip_tags($item->persyaratan ?? $item->deskripsi) }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 2. HASIL PENGUMUMAN --}}
        @if (isset($pengumumans) && $pengumumans->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">📢 Pengumuman ({{ $pengumumans->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($pengumumans as $item)
                        <a href="{{ route('pengumuman.show', $item) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition block">
                            <p class="text-sm font-medium text-slate-800 line-clamp-1">{{ $item->judul }}</p>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ strip_tags($item->isi) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 3. HASIL BERITA --}}
        @if (isset($beritas) && $beritas->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">📰 Berita ({{ $beritas->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($beritas as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition block">
                            <p class="text-sm font-medium text-slate-800 line-clamp-2">{{ $item->judul }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ optional($item->published_at)->format('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 4. HASIL WISATA --}}
        @if (isset($wisatas) && $wisatas->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">🏞️ Wisata ({{ $wisatas->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($wisatas as $item)
                        <a href="{{ route('wisata.show', $item->slug) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition block">
                            <p class="text-sm font-medium text-slate-800">{{ $item->nama }}</p>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ $item->alamat }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 5. HASIL UMKM --}}
        @if (isset($umkms) && $umkms->count())
            <div class="mb-10">
                <h2 class="font-semibold text-slate-800 mb-4">🛍️ UMKM ({{ $umkms->count() }})</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($umkms as $item)
                        <a href="{{ route('umkm.show', $item->id) }}" class="bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md transition block">
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

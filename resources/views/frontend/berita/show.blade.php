{{-- resources/views/frontend/berita/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $berita->judul)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-4 capitalize">
            {{ $berita->kategori }}
        </span>

        <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A] leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $berita->judul }}
        </h1>

        <div class="flex items-center gap-3 text-xs text-slate-400 mt-4 mb-6">
            <span>{{ $berita->user->name ?? 'Admin' }}</span>
            <span>·</span>
            <span>{{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : $berita->created_at->translatedFormat('d F Y') }}</span>
            <span>·</span>
            <span>{{ $berita->views }} kali dilihat</span>
        </div>

        {{-- Gambar Utama --}}
        <div class="w-full h-64 sm:h-96 rounded-2xl overflow-hidden bg-slate-100 mb-8">
            @if ($berita->thumbnail)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($berita->thumbnail) }}"
                     class="w-full h-full object-cover"
                     alt="{{ $berita->judul }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/800x500/e2e8f0/475569?text=Berita';">
            @else
                <img src="https://placehold.co/800x500/e2e8f0/475569?text=Berita"
                     class="w-full h-full object-cover"
                     alt="Gambar Default">
            @endif
        </div>

        <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $berita->isi }}
        </div>

        {{-- Galeri Foto Dokumentasi --}}
        @if (isset($galleries) && $galleries->count() > 0)
            <div class="mt-10 pt-8 border-t border-slate-100">
                <h3 class="font-semibold text-slate-800 text-lg mb-4">Galeri Dokumentasi</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($galleries as $foto)
                        <div class="h-36 sm:h-44 rounded-xl overflow-hidden bg-slate-100 group border border-slate-100">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($foto->path ?? $foto->foto ?? $foto->image) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 alt="Dokumentasi Berita"
                                 onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/475569?text=Galeri';">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Berita Lainnya --}}
        @if ($beritaLainnya->count())
            <div class="mt-14 pt-8 border-t border-slate-100">
                <h2 class="font-semibold text-slate-800 mb-4">Berita Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="group">
                            <div class="w-full h-32 rounded-xl overflow-hidden bg-slate-100 mb-2">
                                @if ($item->thumbnail)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->thumbnail) }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                         alt="{{ $item->judul }}"
                                         onerror="this.onerror=null;this.src='https://placehold.co/400x300/e2e8f0/475569?text=Berita';">
                                @else
                                    <img src="https://placehold.co/400x300/e2e8f0/475569?text=Berita"
                                         class="w-full h-full object-cover"
                                         alt="Gambar Default">
                                @endif
                            </div>
                            <p class="text-xs font-medium text-slate-700 group-hover:text-emerald-600 line-clamp-2">{{ $item->judul }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

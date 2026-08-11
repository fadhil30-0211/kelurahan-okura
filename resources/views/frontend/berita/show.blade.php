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
            <span>{{ $berita->user->name }}</span>
            <span>·</span>
            <span>{{ $berita->published_at->translatedFormat('d F Y') }}</span>
            <span>·</span>
            <span>{{ $berita->views }} kali dilihat</span>
        </div>

        <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-full h-64 sm:h-96 object-cover rounded-2xl mb-8" alt="{{ $berita->judul }}">

        <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $berita->isi }}
        </div>

        @if ($beritaLainnya->count())
            <div class="mt-14 pt-8 border-t border-slate-100">
                <h2 class="font-semibold text-slate-800 mb-4">Berita Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="group">
                            <img src="{{ asset('storage/'.$item->thumbnail) }}" class="w-full h-32 object-cover rounded-xl mb-2" alt="">
                            <p class="text-xs font-medium text-slate-700 group-hover:text-emerald-600 line-clamp-2">{{ $item->judul }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

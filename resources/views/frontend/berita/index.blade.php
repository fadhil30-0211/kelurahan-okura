
{{-- resources/views/frontend/berita/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Berita Kelurahan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Informasi
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Berita & Kegiatan Kelurahan
            </h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($beritas as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('storage/'.$berita->thumbnail) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $berita->judul }}"
                             loading="lazy">
                     </div>
                    <div class="p-5">
                        <span class="text-xs text-emerald-600 font-medium capitalize">{{ $berita->kategori }}</span>
                        <h3 class="font-semibold text-slate-800 mt-1 line-clamp-2">{{ $berita->judul }}</h3>
                        <p class="text-xs text-slate-400 mt-2">{{ $berita->published_at->translatedFormat('d F Y') }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-slate-400 text-sm py-16">Belum ada berita dipublikasikan.</p>
            @endforelse
        </div>

        @if ($beritas->hasPages())
            <div class="mt-10">{{ $beritas->links() }}</div>
        @endif
    </div>
</section>
@endsection

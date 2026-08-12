{{-- resources/views/frontend/galeri/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Galeri Kegiatan')

@section('content')
<section class="pt-28 pb-16" x-data="{ open: false, activeIndex: 0, photos: {{ $galeris->pluck('foto')->map(fn($p) => asset('storage/'.$p))->toJson() }} }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold mb-3">
                Dokumentasi
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Galeri Kegiatan Kelurahan
            </h1>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            @foreach (['' => 'Semua', 'kegiatan' => 'Kegiatan', 'fasilitas' => 'Fasilitas', 'wisata' => 'Wisata'] as $val => $label)
                <a href="{{ route('galeri.index', ['kategori' => $val]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-medium {{ request('kategori', '') == $val ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Grid Foto --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($galeris as $i => $foto)
                <div class="group relative rounded-2xl overflow-hidden cursor-pointer" @click="open = true; activeIndex = {{ $i }}">
                    <img src="{{ asset('storage/'.$foto->foto) }}" loading="lazy"
                         class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $foto->judul }}">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-end p-3">
                        <p class="text-white text-xs font-medium opacity-0 group-hover:opacity-100 transition line-clamp-2">{{ $foto->judul }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-4 text-center text-slate-400 text-sm py-16">Belum ada foto galeri.</p>
            @endforelse
        </div>

        @if ($galeris->hasPages())
            <div class="mt-10">{{ $galeris->links() }}</div>
        @endif
    </div>

    {{-- Lightbox Modal --}}
    <div x-show="open" x-cloak @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
        <button @click="open = false" class="absolute top-5 right-5 text-white text-2xl">✕</button>
        <button @click="activeIndex = (activeIndex - 1 + photos.length) % photos.length" class="absolute left-5 text-white text-3xl">‹</button>
        <img :src="photos[activeIndex]" class="max-h-[85vh] max-w-full rounded-lg">
        <button @click="activeIndex = (activeIndex + 1) % photos.length" class="absolute right-5 text-white text-3xl">›</button>
    </div>
</section>
@endsection

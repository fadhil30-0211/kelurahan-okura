{{-- resources/views/frontend/wisata/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $wisata->nama)

@section('content')
<section class="pt-16">
    {{-- Hero Image --}}
    <div class="relative h-72 sm:h-96">
        <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
             class="w-full h-full object-cover" alt="{{ $wisata->nama }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-2xl sm:text-4xl font-bold text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $wisata->nama }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-200 mt-2">
                    <p>📍 {{ $wisata->alamat }}</p>

                    {{-- Indikator Views --}}
                    <div class="flex items-center gap-1.5 bg-black/30 backdrop-blur-md px-3 py-1 rounded-full text-xs text-emerald-300 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>{{ number_format($wisata->views ?? 0) }} kali dilihat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Konten Utama --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-slate-800 mb-3">Tentang Destinasi</h2>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $wisata->deskripsi }}</p>
                </div>

                {{-- Galeri Foto --}}
                @if ($wisata->galleries && $wisata->galleries->count())
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ open: false, activeIndex: 0, photos: {{ $wisata->galleries->pluck('path')->map(fn($p) => asset('storage/'.$p))->toJson() }} }">
                        <h2 class="font-semibold text-slate-800 mb-3">Galeri Foto ({{ $wisata->galleries->count() }})</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($wisata->galleries as $i => $foto)
                                <img src="{{ asset('storage/'.$foto->path) }}" @click="open = true; activeIndex = {{ $i }}"
                                    class="w-full h-28 object-cover rounded-xl cursor-pointer hover:opacity-80 transition" alt="">
                            @endforeach
                        </div>

                        {{-- Lightbox Modal --}}
                        <div x-show="open" x-cloak @keydown.escape.window="open = false"
                            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
                            <button @click="open = false" class="absolute top-5 right-5 text-white text-2xl">✕</button>
                            <button @click="activeIndex = (activeIndex - 1 + photos.length) % photos.length" class="absolute left-5 text-white text-3xl">‹</button>
                            <img :src="photos[activeIndex]" class="max-h-[85vh] max-w-full rounded-lg">
                            <button @click="activeIndex = (activeIndex + 1) % photos.length" class="absolute right-5 text-white text-3xl">›</button>
                        </div>
                    </div>
                @endif

                {{-- PETA LOKASI GOOGLE MAPS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-slate-800 mb-3">Lokasi Destinasi</h2>
                    <div id="peta-wisata-detail" class="w-full h-64 rounded-xl overflow-hidden border border-slate-200">
                        @if ($wisata->latitude && $wisata->longitude)
                            <iframe
                                width="100%"
                                height="100%"
                                style="border:0;"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://maps.google.com/maps?q={{ $wisata->latitude }},{{ $wisata->longitude }}&hl=id&z=16&output=embed">
                            </iframe>
                        @else
                            <div class="flex items-center justify-center h-full bg-slate-50">
                                <p class="text-xs text-slate-400">Koordinat lokasi belum tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Harga Tiket</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Jam Operasional</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $wisata->jam_operasional ?? '-' }}</p>
                    </div>
                    @if ($wisata->kontak)
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Kontak</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $wisata->kontak }}</p>
                        </div>
                    @endif

                    @if ($wisata->kontak)
                        <a href="https://wa.me/62{{ ltrim($wisata->kontak, '0') }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20{{ urlencode($wisata->nama) }}"
                           target="_blank"
                           class="block text-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                            Tanya via WhatsApp
                        </a>
                    @endif
                </div>

                {{-- Wisata Terkait --}}
                @php
                    $rekomendasiWisata = $wisataLainnya ?? $wisataTerkait ?? collect();
                @endphp

                @if ($rekomendasiWisata->count())
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="font-semibold text-slate-800 text-sm mb-3">Wisata Lainnya</h3>
                        <div class="space-y-3">
                            @foreach ($rekomendasiWisata as $item)
                                <a href="{{ route('wisata.show', $item->slug ?? $item) }}" class="flex gap-3 group">
                                    <img src="{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : asset('images/placeholder.jpg') }}"
                                         class="w-14 h-14 rounded-lg object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium text-slate-700 group-hover:text-emerald-600 truncate">{{ $item->nama }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $item->alamat }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

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
                <p class="text-sm text-slate-200 mt-2">📍 {{ $wisata->alamat }}</p>
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

                {{-- Ganti blok galeri lama di frontend/wisata/show.blade.php --}}
                @if ($wisata->galleries->count())
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

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-slate-800 mb-3">Lokasi</h2>
                    <div id="peta-wisata-detail" class="w-full h-64 rounded-xl"></div>
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
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20{{ urlencode($wisata->nama) }}"
                       target="_blank"
                       class="block text-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Tanya via WhatsApp
                    </a>
                </div>

                @if ($wisataLainnya->count())
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="font-semibold text-slate-800 text-sm mb-3">Wisata Lainnya</h3>
                        <div class="space-y-3">
                            @foreach ($wisataLainnya as $item)
                                <a href="{{ route('wisata.show', $item->slug) }}" class="flex gap-3 group">
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

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    @if ($wisata->latitude && $wisata->longitude)
        const map = L.map('peta-wisata-detail').setView([{{ $wisata->latitude }}, {{ $wisata->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([{{ $wisata->latitude }}, {{ $wisata->longitude }}]).addTo(map).bindPopup('{{ $wisata->nama }}');
    @else
        document.getElementById('peta-wisata-detail').innerHTML = '<p class="text-xs text-slate-400 text-center py-24">Koordinat lokasi belum tersedia.</p>';
    @endif
</script>
@endpush

{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Kelurahan Tebing Tinggi Okura')

@section('content')

@php
    // Normalisasi $banners
    $bannersData = isset($banners) && is_iterable($banners) ? collect($banners) : collect();
    $bannerCount = $bannersData->count();

    // Normalisasi $settings
    if (isset($settings)) {
        $mapInput = is_array($settings) ? ($settings['google_maps_embed_url'] ?? null) : ($settings->google_maps_embed_url ?? null);
        $lat = is_array($settings) ? ($settings['latitude'] ?? null) : ($settings->latitude ?? null);
        $lng = is_array($settings) ? ($settings['longitude'] ?? null) : ($settings->longitude ?? null);
        $zoom = is_array($settings) ? ($settings['map_zoom'] ?? 16) : ($settings->map_zoom ?? 16);
        $nomorWa = is_array($settings) ? ($settings['nomor_hp'] ?? '081234567890') : ($settings->nomor_hp ?? '081234567890');
    } else {
        $mapInput = null;
        $lat = null;
        $lng = null;
        $zoom = 16;
        $nomorWa = '081234567890';
    }

    // 1. Ambil URL iframe jika ada
    if ($mapInput && preg_match('/src="([^"]+)"/', $mapInput, $matches)) {
        $mapUrl = $matches[1];
    } else {
        $mapUrl = $mapInput;
    }

    // 2. Otomatis ubah mode Satelit (!5e1) ke Peta Biasa (!5e0) untuk menghilangkan pesan error Google
    if (!empty($mapUrl)) {
        $mapUrl = str_replace('!5e1', '!5e0', $mapUrl);
    } else {
        // Backup jika database kosong
        $mapUrl = "https://maps.google.com/maps?q=Kantor+Lurah+Tebing+Tinggi+Okura&t=&z=16&ie=UTF8&iwloc=&output=embed";
    }

    // Format Nomor WhatsApp
    $nomorWaClean = preg_replace('/[^0-9]/', '', $nomorWa);
    if (str_starts_with($nomorWaClean, '0')) {
        $nomorWaClean = '62' . substr($nomorWaClean, 1);
    }
@endphp

{{-- ================= HERO SECTION — CAROUSEL DINAMIS ================= --}}
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden"
         x-data='{
             slides: {{ $bannerCount > 0 ? $bannerCount : 1 }},
             banners: @json($bannersData),
             current: 0,
             autoplay: null,
             init() {
                 if (this.slides > 1) {
                     this.autoplay = setInterval(() => this.next(), 6000);
                 }
             },
             next() { this.current = (this.current + 1) % this.slides },
             prev() { this.current = (this.current - 1 + this.slides) % this.slides },
             goTo(i) {
                 this.current = i;
                 if (this.autoplay) clearInterval(this.autoplay);
                 if (this.slides > 1) this.autoplay = setInterval(() => this.next(), 6000);
             }
         }'>

    {{-- Banner Images & Background Overlay --}}
    <div class="absolute inset-0 z-0">
        @forelse ($bannersData as $i => $banner)
            <div x-show="current === {{ $i }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <img src="{{ asset('storage/' . ($banner->gambar ?? $banner['gambar'] ?? '')) }}"
                     alt="{{ $banner->judul ?? $banner['judul'] ?? 'Hero Banner' }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0B1F3A]/80 via-[#0B1F3A]/60 to-[#0B1F3A]/90"></div>
            </div>
        @empty
            <div class="absolute inset-0">
                <img src="{{ asset('images/hero-okura.jpg') }}" alt="Okura" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0B1F3A]/80 via-[#0B1F3A]/60 to-[#0B1F3A]/90"></div>
            </div>
        @endforelse
    </div>

    {{-- Carousel Controls --}}
    @if ($bannerCount > 1)
        {{-- Tombol Previous --}}
        <button @click="prev()"
                aria-label="Previous Slide"
                class="absolute left-2 sm:left-4 top-[50%] sm:top-[51%] -translate-y-1/2 z-20 w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-br from-white/30 via-white/10 to-white/5 backdrop-blur-md border border-white/40 hover:border-white/70 shadow-lg shadow-black/25 flex items-center justify-center text-white transition-all duration-300 hover:scale-110 active:scale-95 focus:outline-none group">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 drop-shadow group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Tombol Next --}}
        <button @click="next()"
                aria-label="Next Slide"
                class="absolute right-2 sm:right-4 top-[50%] sm:top-[51%] -translate-y-1/2 z-20 w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-br from-white/30 via-white/10 to-white/5 backdrop-blur-md border border-white/40 hover:border-white/70 shadow-lg shadow-black/25 flex items-center justify-center text-white transition-all duration-300 hover:scale-110 active:scale-95 focus:outline-none group">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 drop-shadow group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Indikator Dots Carousel --}}
        <div class="absolute bottom-20 sm:bottom-24 left-1/2 -translate-x-1/2 z-20 flex gap-2 p-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-md">
            @foreach ($bannersData as $i => $banner)
                <button @click="goTo({{ $i }})"
                        aria-label="Go to slide {{ $i + 1 }}"
                        :class="current === {{ $i }} ? 'w-8 bg-amber-400 shadow-sm shadow-amber-400/50' : 'w-2 bg-white/50 hover:bg-white/80'"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none"></button>
            @endforeach
        </div>
    @endif

    <div class="relative z-10 max-w-4xl mx-auto px-12 sm:px-16 text-center pt-32 sm:pt-28 pb-24 sm:pb-28">
        <span class="inline-block px-4 py-1.5 mb-5 rounded-full bg-amber-400/20 text-amber-300 text-sm font-medium border border-amber-400/30 shadow-sm backdrop-blur">
            Portal Resmi Kelurahan
        </span>

        {{-- Judul Dinamis --}}
        <h1 class="text-4xl sm:text-6xl font-bold text-white leading-tight tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            @if ($bannerCount > 0)
                <span x-text="banners[current]?.judul || 'Tebing Tinggi Okura'">Tebing Tinggi Okura</span>
            @else
                Tebing Tinggi Okura
            @endif
        </h1>

        {{-- Subjudul Dinamis --}}
        <p class="mt-4 text-lg sm:text-xl text-slate-200 max-w-2xl mx-auto leading-relaxed">
            @if ($bannerCount > 0)
                <span x-text="banners[current]?.subjudul || 'Menyajikan pelayanan, informasi, dan potensi wisata & UMKM warga secara cepat, transparan, dan modern.'">
                    Menyajikan pelayanan, informasi, dan potensi wisata & UMKM warga secara cepat, transparan, dan modern.
                </span>
            @else
                Menyajikan pelayanan, informasi, dan potensi wisata & UMKM warga secara cepat, transparan, dan modern.
            @endif
        </p>

        {{-- Tombol Aksi Dinamis --}}
        @if ($bannerCount > 0)
            <template x-if="banners[current]?.tombol_teks">
                <div class="mt-6">
                    <a :href="banners[current]?.tombol_link || '#'"
                       x-text="banners[current]?.tombol_teks"
                       class="inline-block px-6 py-3 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 font-semibold text-sm transition shadow-lg hover:shadow-amber-400/20">
                    </a>
                </div>
            </template>
        @endif

        {{-- Form Pencarian & Lacak Pengaduan (Semi-Liquid Glass Style) --}}
        <div id="lacak" class="mt-8 max-w-xl mx-auto" x-data="{ tab: window.location.hash === '#lacak' ? 'lacak' : 'cari' }">
            <div class="flex bg-white/10 backdrop-blur-md rounded-xl p-1 mb-3 max-w-xs mx-auto border border-white/20 shadow-inner">
                <button @click="tab = 'cari'"
                        type="button"
                        :class="tab === 'cari' ? 'bg-white/25 text-white shadow-sm border border-white/25 font-bold' : 'text-white/70 hover:text-white'"
                        class="flex-1 py-1.5 rounded-lg text-xs transition">
                    Cari Informasi
                </button>
                <button @click="tab = 'lacak'"
                        type="button"
                        :class="tab === 'lacak' ? 'bg-white/25 text-white shadow-sm border border-white/25 font-bold' : 'text-white/70 hover:text-white'"
                        class="flex-1 py-1.5 rounded-lg text-xs transition">
                    Lacak Pengaduan
                </button>
            </div>

            <form x-show="tab === 'cari'" action="{{ route('search') }}" method="GET">
                <div class="flex items-center bg-white/15 backdrop-blur-md rounded-2xl shadow-xl p-2 border border-white/30 transition-all duration-300 focus-within:bg-white/25 focus-within:border-white/50 focus-within:ring-4 focus-within:ring-white/10">
                    <svg class="w-5 h-5 text-white/70 ml-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari: Syarat SKTM, Wisata Sungai Siak, UMKM..."
                           class="flex-1 px-3 py-2 bg-transparent focus:outline-none text-white text-sm sm:text-base placeholder-white/70">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-semibold text-sm transition shadow-md active:scale-95 shrink-0">
                        Cari
                    </button>
                </div>
            </form>

            <form x-show="tab === 'lacak'" x-cloak action="{{ route('tracking.universal') }}" method="POST">
                @csrf
                <div class="flex items-center bg-white/15 backdrop-blur-md rounded-2xl shadow-xl p-2 border border-white/30 transition-all duration-300 focus-within:bg-white/25 focus-within:border-white/50 focus-within:ring-4 focus-within:ring-white/10">
                    <svg class="w-5 h-5 text-white/70 ml-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <input type="text" name="kode_tiket" placeholder="Masukkan kode tiket, contoh: ADU-20260809-001"
                           class="flex-1 px-3 py-2 bg-transparent focus:outline-none text-white text-sm sm:text-base font-mono placeholder-white/70">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-semibold text-sm transition shadow-md active:scale-95 shrink-0">
                        Lacak
                    </button>
                </div>
                @error('kode_tiket')
                    <p class="text-xs text-red-300 mt-2 text-center bg-red-900/40 border border-red-500/30 rounded-lg py-1.5 px-3 backdrop-blur-md">{{ $message }}</p>
                @enderror
            </form>
        </div>

        {{-- Live Counter --}}
        <div class="mt-12 mb-2 grid grid-cols-3 gap-4 max-w-lg mx-auto">
            <div class="text-center" x-data="{ val: 0, target: {{ $jumlahPenduduk ?? 0 }} }" x-init="if (target > 0) { let step = Math.max(1, Math.ceil(target / 80)); let t = setInterval(() => { val += step; if (val >= target) { val = target; clearInterval(t); } }, 15) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val.toLocaleString('id-ID')">{{ number_format($jumlahPenduduk ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Jumlah Penduduk</p>
            </div>
            <div class="text-center" x-data="{ val: 0, target: {{ $jumlahWisata ?? 0 }} }" x-init="if (target > 0) { let t = setInterval(() => { val += 1; if (val >= target) { val = target; clearInterval(t); } }, 80) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val">{{ $jumlahWisata ?? 0 }}</p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Destinasi Wisata</p>
            </div>
            <div class="text-center" x-data="{ val: 0, target: {{ $jumlahUmkm ?? 0 }} }" x-init="if (target > 0) { let t = setInterval(() => { val += 1; if (val >= target) { val = target; clearInterval(t); } }, 40) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val">{{ $jumlahUmkm ?? 0 }}</p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">UMKM Terdaftar</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= QUICK ACCESS CARDS ================= --}}
<section class="relative z-20 -mt-10 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $quickLinks = [
            [
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                'label' => 'Layanan Surat',
                'desc' => 'Ajukan & lacak',
                'route' => 'layanan.index',
                'color' => 'bg-emerald-50 text-emerald-600'
            ],
            [
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
                'label' => 'Lapor Pengaduan',
                'desc' => 'Sampaikan keluhan',
                'route' => 'pengaduan.create',
                'color' => 'bg-amber-50 text-amber-600'
            ],
            [
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                'label' => 'Wisata Okura',
                'desc' => 'Jelajahi destinasi',
                'route' => 'wisata.index',
                'color' => 'bg-sky-50 text-sky-600'
            ],
            [
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
                'label' => 'UMKM Warga',
                'desc' => 'Dukung usaha lokal',
                'route' => 'umkm.index',
                'color' => 'bg-rose-50 text-rose-600'
            ],
        ];
    @endphp

    @foreach ($quickLinks as $link)
        <a href="{{ route($link['route']) }}"
        class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-5 transition-all duration-300 hover:-translate-y-1 border border-slate-100">
            <div class="w-12 h-12 rounded-xl {{ $link['color'] }} flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $link['svg'] !!}
                </svg>
            </div>
            <h3 class="font-semibold text-slate-800 text-sm sm:text-base group-hover:text-emerald-600 transition-colors">{{ $link['label'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">{{ $link['desc'] }}</p>
        </a>
    @endforeach
    </div>
</section>

{{-- ================= BENTO GRID: PROFIL & INFO CEPAT ================= --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="mb-10 text-center">
        <span class="text-emerald-600 font-semibold text-sm uppercase tracking-wide">Selayang Pandang</span>
        <h2 class="text-3xl font-bold text-[#0B1F3A] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Mengenal Kelurahan Kami
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-4">
        {{-- Peta Wilayah Dinamis --}}
        <div class="md:col-span-2 md:row-span-2 bg-white rounded-2xl shadow-md p-6 border border-slate-100 flex flex-col justify-between">
            <div>
                <h3 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Peta Wilayah
                </h3>
                <div class="w-full h-64 md:h-80 rounded-xl overflow-hidden border border-slate-100 bg-slate-50 shadow-inner">
                    <iframe
                        width="100%"
                        height="100%"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="{{ $mapUrl }}">
                    </iframe>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-3 flex items-center gap-1">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Kelurahan Tebing Tinggi Okura, Kec. Rumbai Timur, Pekanbaru.
            </p>
        </div>

        {{-- Visi Misi --}}
        <div class="md:col-span-2 bg-[#009B3A] rounded-2xl shadow-md p-6 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="font-semibold mb-2 flex items-center gap-2 text-amber-300">
                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Visi Kelurahan
                </h3>
                <p class="text-sm text-slate-200 leading-relaxed">
                    Terwujudnya Kelurahan Tebing Tinggi Okura sebagai Pusat Pariwisata, Pertanian, Perikanan dan Pusat Kebudayaan Melayu di Kota Pekanbaru.

                </p>
            </div>
            <div class="relative z-10 pt-4">
                <a href="{{ route('profil') }}" class="inline-flex items-center gap-1 text-amber-300 text-sm font-medium hover:text-amber-200 transition">
                    Selengkapnya <span>→</span>
                </a>
            </div>
        </div>

        {{-- Pengumuman Terbaru --}}
        <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100 flex flex-col justify-between">
            <div>
                <h3 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Pengumuman Terbaru
                </h3>
                <div class="space-y-2">
                    @forelse ($pengumumanTerbaru ?? [] as $item)
                        <a href="{{ route('pengumuman.show', $item) }}" class="block text-xs text-slate-600 hover:text-emerald-600 py-1 border-b border-slate-50 last:border-0 truncate transition-colors">
                            • {{ $item->judul ?? $item['judul'] ?? '-' }}
                        </a>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada pengumuman aktif.</p>
                    @endforelse
                </div>
            </div>
            <div class="pt-3">
                <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-1 text-emerald-600 text-sm font-medium hover:underline">
                    Lihat Semua <span>→</span>
                </a>
            </div>
        </div>

        {{-- Chart Anggaran --}}
        <div class="bg-amber-50/80 rounded-2xl shadow-md p-6 border border-amber-100 flex flex-col justify-between">
            <div>
                <h3 class="font-semibold text-amber-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Transparansi Anggaran {{ date('Y') }}
                </h3>
                @php
                    $anggaranList = isset($anggaranTahunIni) && is_iterable($anggaranTahunIni) ? collect($anggaranTahunIni) : collect();
                @endphp
                @if ($anggaranList->isNotEmpty())
                    <div class="mt-2">
                        <canvas id="chartAnggaranHome" class="w-full max-h-32"></canvas>
                    </div>
                @else
                    <p class="text-xs text-amber-700/80 mt-2 italic">Data anggaran belum tersedia untuk tahun ini.</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ================= WISATA OKURA ================= --}}
<section class="bg-slate-50 py-16 border-t border-slate-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wide">Jelajahi</span>
                <h2 class="text-3xl font-bold text-[#0B1F3A] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Potensi Wisata Okura
                </h2>
            </div>
            <a href="{{ route('wisata.index') }}" class="hidden sm:inline-flex items-center gap-1 text-emerald-600 font-medium text-sm hover:underline">
                Lihat Semua <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($wisatas ?? [] as $wisata)
                @php
                    $wisataObj = (object) $wisata;
                @endphp
                <a href="{{ route('wisata.show', $wisataObj->slug ?? '#') }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img src="{{ !empty($wisataObj->thumbnail) ? asset('storage/' . $wisataObj->thumbnail) : asset('images/placeholder.jpg') }}"
                             alt="{{ $wisataObj->nama ?? 'Wisata' }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $wisataObj->nama ?? '-' }}</h3>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $wisataObj->deskripsi ?? '' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                    <p class="text-sm text-slate-400">Belum ada data wisata yang ditampilkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('wisata.index') }}" class="inline-flex items-center gap-1 text-emerald-600 font-medium text-sm hover:underline">
                Lihat Semua Wisata <span>→</span>
            </a>
        </div>
    </div>
</section>

{{-- ================= UMKM WARGA ================= --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-rose-600 font-semibold text-sm uppercase tracking-wide">Dukung Lokal</span>
            <h2 class="text-3xl font-bold text-[#0B1F3A] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                UMKM Warga Okura
            </h2>
        </div>
        <a href="{{ route('umkm.index') }}" class="hidden sm:inline-flex items-center gap-1 text-emerald-600 font-medium text-sm hover:underline">
            Lihat Semua <span>→</span>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse ($umkms ?? [] as $umkm)
            @php
                $umkmObj = (object) $umkm;
            @endphp
            <a href="{{ route('umkm.show', $umkmObj->id ?? '#') }}"
               class="group rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-300 p-4 border border-slate-100 flex flex-col">
                <div class="h-28 rounded-xl overflow-hidden mb-3 bg-slate-100">
                    <img src="{{ !empty($umkmObj->foto) ? asset('storage/' . $umkmObj->foto) : asset('images/placeholder.jpg') }}"
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="{{ $umkmObj->nama_usaha ?? 'UMKM' }}">
                </div>
                <h3 class="font-semibold text-sm text-slate-800 truncate group-hover:text-emerald-600 transition-colors">{{ $umkmObj->nama_usaha ?? '-' }}</h3>
                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $umkmObj->kategori ?? 'UMKM' }}</p>
            </a>
        @empty
            <div class="col-span-2 lg:col-span-4 text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-sm text-slate-400">Belum ada data UMKM yang ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8 text-center sm:hidden">
        <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-1 text-emerald-600 font-medium text-sm hover:underline">
            Lihat Semua UMKM <span>→</span>
        </a>
    </div>
</section>

@endsection

@push('scripts')
@php
    $anggaranChartData = isset($anggaranTahunIni) && is_iterable($anggaranTahunIni) ? collect($anggaranTahunIni) : collect();
@endphp
@if ($anggaranChartData->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartAnggaranHome');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($anggaranChartData->pluck('kategori')),
                    datasets: [{
                        data: @json($anggaranChartData->pluck('jumlah')),
                        backgroundColor: '#D97706',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            ticks: {
                                callback: (v) => 'Rp' + (v >= 1000000 ? (v/1000000) + 'jt' : v.toLocaleString('id-ID'))
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush

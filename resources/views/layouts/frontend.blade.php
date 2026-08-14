{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon Absolut --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- SEO Dinamis & OpenGraph --}}
    <title>{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}</title>
    <meta name="description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura - Layanan publik, wisata, dan UMKM warga.' }}">

    <meta property="og:title" content="{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}">
    <meta property="og:description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura - Layanan publik, wisata, dan UMKM warga.' }}">
    <meta property="og:image" content="{{ $seoImage ?? asset('images/default-og.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind (build via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet (Peta Interaktif) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Mencegah flicker pada Alpine.js sebelum JavaScript selesai dirender */
        [x-cloak] { display: none !important; }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            display: inline-block;
            animation: marquee 25s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="bg-[#FAF9F6] text-slate-800 antialiased">

@php
    $isHome = Route::is('home');
@endphp

{{-- ============ HEADER (TOPBAR + NAVBAR MENYATU) ============ --}}
<header x-data="{ open: false, scrolled: false, isHome: {{ $isHome ? 'true' : 'false' }} }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">

    {{-- TOPBAR EMERGENCY (Ikut Berubah Warna saat Scroll + Running Text Kontak) --}}
    <div :class="{
            'bg-white/95 backdrop-blur border-b border-slate-200/80 text-slate-700 shadow-sm': scrolled || !isHome,
            'bg-[#071426]/80 backdrop-blur border-b border-white/10 text-white': !scrolled && isHome
         }"
         class="text-xs transition-all duration-300 py-1.5">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-4">

            {{-- Badge Fixed "Kontak Darurat" --}}
            <div class="flex items-center gap-1.5 flex-shrink-0 font-bold z-10 pr-2"
                 :class="(scrolled || !isHome) ? 'text-emerald-700' : 'text-amber-400'">
                <span class="animate-pulse">🚨</span>
                <span class="hidden sm:inline">Kontak Darurat:</span>
            </div>

            {{-- Running Text Kontak Darurat (Berjalan ke Kiri) --}}
            <div class="flex-1 overflow-hidden relative">
                @if (isset($emergencyContacts) && count($emergencyContacts) > 0)
                    <div class="whitespace-nowrap animate-marquee flex items-center gap-8">
                        @foreach ($emergencyContacts as $contact)
                            <a href="tel:{{ $contact->nomor_telepon }}"
                               :class="(scrolled || !isHome) ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-200 hover:text-amber-300'"
                               class="inline-flex items-center gap-1.5 transition">
                                📞 <span class="font-semibold">{{ $contact->nama ?? $contact->label }}</span>:
                                <span class="font-mono font-bold" :class="(scrolled || !isHome) ? 'text-emerald-600' : 'text-amber-300'">
                                    {{ $contact->nomor_telepon }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="whitespace-nowrap animate-marquee flex items-center gap-8">
                        <span :class="(scrolled || !isHome) ? 'text-slate-600' : 'text-slate-200'">
                            📞 Kantor Kelurahan: <span class="font-mono font-bold text-amber-400">(0761) 000-000</span>
                        </span>
                    </div>
                @endif
            </div>

            {{-- Running Text Pengumuman Darurat Singkat (Sisi Kanan) --}}
            @if (isset($pengumumanDarurat) && $pengumumanDarurat)
                <div class="hidden lg:block flex-shrink-0 text-amber-500 font-medium text-[11px] pl-2">
                    ⚠️ {{ Str::limit($pengumumanDarurat->judul, 35) }}
                </div>
            @endif

        </div>
    </div>

    {{-- NAVBAR UTAMA --}}
    <div :class="{
            'bg-white/95 backdrop-blur shadow-md': scrolled || !isHome,
            'bg-gradient-to-b from-black/60 to-transparent': !scrolled && isHome
         }"
         class="transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14 sm:h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                        TO
                    </div>
                    <span :class="(scrolled || !isHome) ? 'text-[#0B1F3A]' : 'text-white'"
                          class="font-bold text-sm sm:text-base transition-colors">
                        Tebing Tinggi Okura
                    </span>
                </a>

                {{-- Menu Desktop --}}
                <nav class="hidden md:flex items-center gap-8">
                    @foreach ([
                        ['label' => 'Profil', 'route' => 'profil'],
                        ['label' => 'Layanan', 'route' => 'layanan.index'],
                        ['label' => 'Wisata', 'route' => 'wisata.index'],
                        ['label' => 'UMKM', 'route' => 'umkm.index'],
                        ['label' => 'Berita', 'route' => 'berita.index'],
                        ['label' => 'Agenda', 'route' => 'agenda.index'],
                    ] as $nav)
                        <a href="{{ route($nav['route']) }}"
                           :class="(scrolled || !isHome) ? 'text-slate-700 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                           class="text-sm font-medium transition-colors {{ Route::is($nav['route']) ? 'font-bold text-emerald-600' : '' }}">
                            {{ $nav['label'] }}
                        </a>
                    @endforeach
                </nav>

                {{-- Tombol Lapor --}}
                <a href="{{ route('pengaduan.create') }}"
                   class="hidden md:inline-flex items-center px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    Lapor Sekarang
                </a>

                {{-- Tombol Mobile Menu --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-lg"
                        :class="(scrolled || !isHome) ? 'text-slate-700' : 'text-white'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div x-show="open" x-cloak x-transition class="md:hidden bg-white shadow-xl border-t border-slate-100">
            <div class="px-4 py-4 space-y-1">
                @foreach ([
                    ['label' => 'Profil', 'route' => 'profil'],
                    ['label' => 'Layanan Surat', 'route' => 'layanan.index'],
                    ['label' => 'Wisata', 'route' => 'wisata.index'],
                    ['label' => 'UMKM', 'route' => 'umkm.index'],
                    ['label' => 'Berita', 'route' => 'berita.index'],
                    ['label' => 'Lapor Pengaduan', 'route' => 'pengaduan.create'],
                ] as $nav)
                    <a href="{{ route($nav['route']) }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is($nav['route']) ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</header>

{{-- ============ FLASH MESSAGES ============ --}}
<div class="fixed top-24 right-4 z-50 space-y-2">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition x-cloak
             class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <span>{{ session('info') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif
</div>

{{-- ============ MAIN CONTENT ============ --}}
<main class="{{ $isHome ? '' : 'pt-24 sm:pt-28' }}">
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="bg-[#0B1F3A] text-slate-300 pt-16 pb-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-10 border-b border-white/10">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-sm">TO</div>
                    <span class="font-bold text-white">Kelurahan Tebing Tinggi Okura</span>
                </div>
                <p class="text-sm text-slate-400 max-w-sm leading-relaxed">
                    Portal resmi pelayanan publik, informasi, dan potensi wisata & UMKM Kelurahan Tebing Tinggi Okura, Kecamatan Rumbai Timur, Pekanbaru.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Tautan Cepat</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li><a href="{{ route('home') }}#lacak" class="hover:text-amber-300 transition">Lacak Pengajuan</a></li>
                    <li><a href="{{ route('pengumuman.index') }}" class="hover:text-amber-300 transition">Pengumuman</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="hover:text-amber-300 transition">Galeri Kegiatan</a></li>
                    <li><a href="{{ route('wisata.index') }}" class="hover:text-amber-300 transition">Wisata Okura</a></li>
                    <li><a href="{{ route('umkm.index') }}" class="hover:text-amber-300 transition">Direktori UMKM</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Kontak</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li>Jl. Kelurahan Okura, Rumbai Pesisir, Pekanbaru</li>
                    <li>kelurahan.okura@pekanbaru.go.id</li>
                    <li>(0761) 000-000</li>
                </ul>
            </div>
        </div>
        <p class="text-center text-xs text-slate-500 pt-6">
            &copy; {{ date('Y') }} Kelurahan Tebing Tinggi Okura — Persembahan dari KKN Kelompok 10 GOKURA USTI 2026. Seluruh Hak Dilindungi.
        </p>
    </div>
</footer>

@yield('scripts')
@stack('scripts')
</body>
</html>

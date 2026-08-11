{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Dinamis & OpenGraph (Preview WhatsApp / Social Media) --}}
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
    </style>
</head>
<body class="bg-[#FAF9F6] text-slate-800 antialiased">

<div class="bg-[#0B1F3A] text-white text-xs">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-2 flex items-center justify-between gap-4">
        {{-- Emergency Hotline --}}
        <div class="flex items-center gap-3 flex-shrink-0">
            @foreach ($emergencyContacts->take(4) as $contact)
                <a href="tel:{{ $contact->nomor_telepon }}" class="flex items-center gap-1 hover:text-amber-300 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="hidden sm:inline">{{ $contact->label }}</span>
                </a>
            @endforeach
        </div>

        {{-- Running Text Darurat --}}
        @if ($pengumumanDarurat)
            <div class="flex-1 overflow-hidden relative hidden md:block">
                <div class="whitespace-nowrap animate-marquee text-amber-300">
                    ⚠️ {{ $pengumumanDarurat->judul }} — {{ Str::limit($pengumumanDarurat->isi, 100) }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    .animate-marquee {
        display: inline-block;
        animation: marquee 20s linear infinite;
    }
</style>

    {{-- ============ NAVBAR ============ --}}
    <header x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'bg-white/95 backdrop-blur shadow-sm' : 'bg-gradient-to-b from-black/40 to-transparent'"
        class="fixed top-0 left-0 right-0 z-40 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-sm">
                        TO
                    </div>
                    <span :class="scrolled ? 'text-[#0B1F3A]' : 'text-white'" class="font-bold text-sm sm:text-base transition-colors">
                        Tebing Tinggi Okura
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    @foreach ([
                        ['label' => 'Profil', 'route' => 'profil'],
                        ['label' => 'Layanan', 'route' => 'layanan.index'],
                        ['label' => 'Wisata', 'route' => 'wisata.index'],
                        ['label' => 'UMKM', 'route' => 'umkm.index'],
                        ['label' => 'Berita', 'route' => 'berita.index'],
                    ] as $nav)
                        <a href="{{ route($nav['route']) }}"
                           :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                           class="text-sm font-medium transition-colors">
                            {{ $nav['label'] }}
                        </a>
                    @endforeach
                </nav>

                <a href="{{ route('pengaduan.create') }}"
                   class="hidden md:inline-flex items-center px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition">
                    Lapor Sekarang
                </a>

                <button @click="open = !open" class="md:hidden p-2 rounded-lg" :class="scrolled ? 'text-slate-700' : 'text-white'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak x-transition class="md:hidden bg-white shadow-lg border-t border-slate-100">
            <div class="px-4 py-4 space-y-1">
                @foreach ([
                    ['label' => 'Profil', 'route' => 'profil'],
                    ['label' => 'Layanan Surat', 'route' => 'layanan.index'],
                    ['label' => 'Wisata', 'route' => 'wisata.index'],
                    ['label' => 'UMKM', 'route' => 'umkm.index'],
                    ['label' => 'Berita', 'route' => 'berita.index'],
                    ['label' => 'Lapor Pengaduan', 'route' => 'pengaduan.create'],
                ] as $nav)
                    <a href="{{ route($nav['route']) }}" class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    {{-- ============ FLASH MESSAGES ============ --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('info') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- ============ MAIN CONTENT ============ --}}
    <main>
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
                        Portal resmi pelayanan publik, informasi, dan potensi wisata & UMKM Kelurahan Tebing Tinggi Okura, Kecamatan Rumbai Pesisir, Pekanbaru.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        {{-- 1 Link Lacak Pengajuan Universal --}}
                        <li><a href="{{ route('home') }}#lacak" class="hover:text-amber-300">Lacak Pengajuan</a></li>
                        <li><a href="{{ route('wisata.index') }}" class="hover:text-amber-300">Wisata Okura</a></li>
                        <li><a href="{{ route('umkm.index') }}" class="hover:text-amber-300">Direktori UMKM</a></li>
                        <li><a href="{{ route('berita.index') }}" class="hover:text-amber-300">Berita & Agenda</a></li>
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

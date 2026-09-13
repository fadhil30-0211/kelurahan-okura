{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="max-w-full overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Pengaturan Dinamis dari Database --}}
    @php
        $activeSettings = $settings ?? $siteSetting ?? null;

        $logoPath   = data_get($activeSettings, 'logo');
        $faviconUrl = $logoPath ? asset('storage/' . $logoPath) : asset('logo.png');

        // Split Nama Website Header dan Footer secara terpisah
        $namaHeader = data_get($activeSettings, 'nama_website') ?? data_get($activeSettings, 'nama_instansi') ?? 'Kelurahan Tebing Tinggi Okura';
        $namaFooter = data_get($activeSettings, 'nama_website_footer') ?? $namaHeader;

        $defaultDesc   = data_get($activeSettings, 'deskripsi_footer') ?? data_get($activeSettings, 'footer_description') ?? 'Portal resmi Kelurahan Tebing Tinggi Okura - Layanan publik, wisata, dan UMKM warga.';
        $defaultTelp   = data_get($activeSettings, 'telepon') ?? data_get($activeSettings, 'phone') ?? '(0761) 000-000';
        $defaultEmail  = data_get($activeSettings, 'email') ?? 'kelurahan.okura@pekanbaru.go.id';
        $defaultAlamat = data_get($activeSettings, 'alamat') ?? data_get($activeSettings, 'address') ?? 'Jl. Kelurahan Okura, Rumbai Timur, Pekanbaru';

        // Jam Pelayanan Dinamis
        $jamSeninKamis = data_get($activeSettings, 'jam_kerja_senin_kamis') ?? '08:00 - 16:00 WIB';
        $jamJumat      = data_get($activeSettings, 'jam_kerja_jumat') ?? '08:00 - 16:30 WIB';
        $jamSabtuMinggu= data_get($activeSettings, 'jam_kerja_sabtu_minggu') ?? 'Libur';

        // Media Sosial Dinamis
        $fbUrl = data_get($activeSettings, 'facebook_url');
        $igUrl = data_get($activeSettings, 'instagram_url');
        $ytUrl = data_get($activeSettings, 'youtube_url');
        $ttUrl = data_get($activeSettings, 'tiktok_url');

        // Format WhatsApp Dinamis (Mengubah 08xx menjadi 628xx)
        $rawWa = data_get($activeSettings, 'whatsapp')
              ?? data_get($activeSettings, 'no_wa')
              ?? data_get($activeSettings, 'nomor_whatsapp')
              ?? '085923287344';

        $cleanWa  = preg_replace('/[^0-9]/', '', $rawWa);
        $waNumber = preg_replace('/^0/', '62', $cleanWa);

        $rawWaText = data_get($activeSettings, 'pesan_wa')
                  ?? data_get($activeSettings, 'pesan_otomatis_wa')
                  ?? 'Halo Admin ' . $namaHeader;

        $waText = ctype_digit(trim($rawWaText)) ? ('Halo Admin ' . $namaHeader) : $rawWaText;

        $isHome = Route::is('home');
    @endphp

    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">

    {{-- SEO Dinamis & OpenGraph --}}
    <title>{{ $seoTitle ?? $namaHeader }}</title>
    <meta name="description" content="{{ $seoDescription ?? $defaultDesc }}">

    <meta property="og:title" content="{{ $seoTitle ?? $namaHeader }}">
    <meta property="og:description" content="{{ $seoDescription ?? $defaultDesc }}">
    <meta property="og:image" content="{{ $seoImage ?? $faviconUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- FontAwesome Icons untuk Media Sosial --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind & AlpineJS (build via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet (Peta Interaktif) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>

    <style>
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        .leaflet-pane { z-index: 10 !important; }
        .leaflet-top, .leaflet-bottom { z-index: 11 !important; }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            animation: marquee 25s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#FAF9F6] text-slate-800 antialiased max-w-full overflow-x-hidden">

{{-- ============ HEADER (TOPBAR + NAVBAR) ============ --}}
<header x-data="{ open: false, scrolled: false, isHome: @json($isHome) }"
        @scroll.window="scrolled = (window.scrollY > 20)"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 w-full">

    {{-- TOPBAR EMERGENCY --}}
    <div :class="{
            'bg-white/95 backdrop-blur border-b border-slate-200/80 text-slate-700 shadow-sm': scrolled || !isHome,
            'bg-[#071426]/80 backdrop-blur border-b border-white/10 text-white': !scrolled && isHome
         }"
         class="text-xs transition-all duration-300 py-1.5 w-full overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-4 overflow-hidden">

            <div class="flex items-center gap-1.5 flex-shrink-0 font-bold z-10 pr-2"
                 :class="(scrolled || !isHome) ? 'text-emerald-700' : 'text-amber-400'">
                {{-- Lucide: Siren / Alert-Circle --}}
                <svg class="w-4 h-4 animate-pulse shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span class="hidden sm:inline">Kontak Darurat:</span>
            </div>

            <div class="flex-1 overflow-hidden relative w-full">
                @if (isset($emergencyContacts) && count($emergencyContacts) > 0)
                    <div class="whitespace-nowrap animate-marquee flex items-center gap-8 w-max">
                        @foreach ($emergencyContacts as $contact)
                            @php
                                $contactNama = data_get($contact, 'nama') ?? data_get($contact, 'label') ?? 'Kontak';
                                $contactNo   = data_get($contact, 'nomor_telepon') ?? '';
                            @endphp
                            <a href="tel:{{ $contactNo }}"
                               :class="(scrolled || !isHome) ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-200 hover:text-amber-300'"
                               class="inline-flex items-center gap-1.5 transition">
                                {{-- Lucide: PhoneCall --}}
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14 2a6 6 0 0 1 6 6"/><path d="M14 6a2 2 0 0 1 2 2"/>
                                </svg>
                                <span class="font-semibold">{{ $contactNama }}</span>:
                                <span class="font-mono font-bold" :class="(scrolled || !isHome) ? 'text-emerald-600' : 'text-amber-300'">
                                    {{ $contactNo }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="whitespace-nowrap animate-marquee flex items-center gap-8 w-max">
                        <span :class="(scrolled || !isHome) ? 'text-slate-600' : 'text-slate-200'" class="inline-flex items-center gap-1.5">
                            {{-- Lucide: Building-2 --}}
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>
                            </svg>
                            Kantor Kelurahan: <span class="font-mono font-bold text-amber-400">{{ $defaultTelp }}</span>
                        </span>
                    </div>
                @endif
            </div>

            @if (isset($pengumumanDarurat) && $pengumumanDarurat)
                <div class="hidden lg:flex items-center gap-1 flex-shrink-0 text-amber-500 font-medium text-[11px] pl-2">
                    {{-- Lucide: Megaphone --}}
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                    </svg>
                    <span>{{ Str::limit(data_get($pengumumanDarurat, 'judul'), 35) }}</span>
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

                <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="flex items-center gap-2.5 shrink-0">
                    <img src="{{ $faviconUrl }}"
                         alt="Logo {{ $namaHeader }}"
                         class="w-8 h-8 object-contain rounded-lg">
                    <span :class="(scrolled || !isHome) ? 'text-[#0B1F3A]' : 'text-white'"
                          class="font-bold text-sm sm:text-base transition-colors truncate max-w-[180px] sm:max-w-none">
                        {{ $namaHeader }}
                    </span>
                </a>

                {{-- Navigation Links --}}
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8 h-full">

                    @if (Route::has('profil'))
                        @php $activeProfil = Route::is('profil*'); @endphp
                        <a href="{{ route('profil') }}"
                           :class="scrolled || !isHome
                               ? '{{ $activeProfil ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                               : '{{ $activeProfil ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                           class="text-sm font-medium transition-colors flex items-center h-full">
                            Profil
                        </a>
                    @endif

                    @if (Route::has('layanan.index'))
                        @php $activeLayanan = Route::is('layanan*'); @endphp
                        <a href="{{ route('layanan.index') }}"
                           :class="scrolled || !isHome
                               ? '{{ $activeLayanan ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                               : '{{ $activeLayanan ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                           class="text-sm font-medium transition-colors flex items-center h-full">
                            Layanan
                        </a>
                    @endif

                    @php
                        $activeInfo = Route::is('berita*', 'agenda*', 'pengumuman*', 'janji-temu*');
                    @endphp
                    <div class="relative flex items-center h-full" x-data="{ dropOpen: false }" @mouseleave="dropOpen = false">
                        <button @click="dropOpen = !dropOpen"
                                @mouseover="dropOpen = true"
                                type="button"
                                :class="scrolled || !isHome
                                    ? '{{ $activeInfo ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                                    : '{{ $activeInfo ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                                class="flex items-center gap-1.5 text-sm font-medium transition-colors focus:outline-none cursor-pointer h-full">
                            <span>Informasi</span>
                            {{-- Lucide: ChevronDown --}}
                            <svg class="w-4 h-4 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': dropOpen }" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div x-show="dropOpen"
                             x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-1/2 -translate-x-1/2 top-full mt-1 w-48 rounded-xl bg-white shadow-2xl border border-slate-100 py-2 z-[99999] text-slate-800">

                            @if (Route::has('berita.index'))
                                <a href="{{ route('berita.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ Route::is('berita*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : '' }}">
                                    {{-- Lucide: Newspaper --}}
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/>
                                    </svg>
                                    Berita
                                </a>
                            @endif
                            @if (Route::has('agenda.index'))
                                <a href="{{ route('agenda.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ Route::is('agenda*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : '' }}">
                                    {{-- Lucide: CalendarDays --}}
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
                                    </svg>
                                    Agenda
                                </a>
                            @endif
                            @if (Route::has('pengumuman.index'))
                                <a href="{{ route('pengumuman.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ Route::is('pengumuman*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : '' }}">
                                    {{-- Lucide: BellRing --}}
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/><path d="M4 2C2.8 3.7 2 5.7 2 8"/><path d="M22 8c0-2.3-.8-4.3-2-6"/>
                                    </svg>
                                    Pengumuman
                                </a>
                            @endif
                            @if (Route::has('janji-temu.index'))
                                <a href="{{ route('janji-temu.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors {{ Route::is('janji-temu*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : '' }}">
                                    {{-- Lucide: CalendarClock --}}
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><circle cx="16" cy="16" r="6"/><path d="M16 14v2l1 1"/>
                                    </svg>
                                    Janji Temu
                                </a>
                            @endif
                        </div>
                    </div>

                    @if (Route::has('wisata.index'))
                        @php $activeWisata = Route::is('wisata*'); @endphp
                        <a href="{{ route('wisata.index') }}"
                           :class="scrolled || !isHome
                               ? '{{ $activeWisata ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                               : '{{ $activeWisata ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                           class="text-sm font-medium transition-colors flex items-center h-full">
                            Wisata
                        </a>
                    @endif

                    @if (Route::has('umkm.index'))
                        @php $activeUmkm = Route::is('umkm*'); @endphp
                        <a href="{{ route('umkm.index') }}"
                           :class="scrolled || !isHome
                               ? '{{ $activeUmkm ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                               : '{{ $activeUmkm ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                           class="text-sm font-medium transition-colors flex items-center h-full">
                            UMKM
                        </a>
                    @endif

                    @if (Route::has('galeri.index'))
                        @php $activeGaleri = Route::is('galeri*'); @endphp
                        <a href="{{ route('galeri.index') }}"
                           :class="scrolled || !isHome
                               ? '{{ $activeGaleri ? 'text-emerald-600 font-bold' : 'text-slate-700 hover:text-emerald-600' }}'
                               : '{{ $activeGaleri ? 'text-amber-300 font-bold' : 'text-slate-100 hover:text-amber-300' }}'"
                           class="text-sm font-medium transition-colors flex items-center h-full">
                            Galeri
                        </a>
                    @endif

                </nav>

                @if (Route::has('pengaduan.create'))
                    <a href="{{ route('pengaduan.create') }}"
                       class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-semibold transition shadow-sm shrink-0">
                        {{-- Lucide: MessageSquarePlus --}}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="12" y1="8" x2="12" y2="14"/><line x1="9" y1="11" x2="15" y2="11"/>
                        </svg>
                        <span>Lapor Sekarang</span>
                    </a>
                @endif

                <button @click="open = !open"
                        aria-label="Toggle Menu"
                        :aria-expanded="open"
                        class="lg:hidden p-2 rounded-lg transition"
                        :class="(scrolled || !isHome) ? 'text-slate-700' : 'text-white'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path x-show="!open" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Dropdown Mobile Menu --}}
        <div x-show="open"
             @click.outside="open = false"
             x-cloak
             x-transition
             class="lg:hidden bg-white shadow-xl border-t border-slate-100 text-slate-800">
            <div class="px-4 py-4 space-y-1">
                @if (Route::has('profil'))
                    <a href="{{ route('profil') }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is('profil*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Profil
                    </a>
                @endif

                @if (Route::has('layanan.index'))
                    <a href="{{ route('layanan.index') }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is('layanan*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Layanan Surat
                    </a>
                @endif

                <div class="py-1 px-3">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Informasi</p>
                    <div class="pl-2 border-l-2 border-slate-200 space-y-1">
                        @if (Route::has('berita.index'))
                            <a href="{{ route('berita.index') }}"
                               class="flex items-center gap-2 py-1.5 px-2 rounded text-sm {{ Route::is('berita*') ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-slate-600 hover:text-emerald-600' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                                Berita
                            </a>
                        @endif
                        @if (Route::has('agenda.index'))
                            <a href="{{ route('agenda.index') }}"
                               class="flex items-center gap-2 py-1.5 px-2 rounded text-sm {{ Route::is('agenda*') ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-slate-600 hover:text-emerald-600' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                Agenda
                            </a>
                        @endif
                        @if (Route::has('pengumuman.index'))
                            <a href="{{ route('pengumuman.index') }}"
                               class="flex items-center gap-2 py-1.5 px-2 rounded text-sm {{ Route::is('pengumuman*') ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-slate-600 hover:text-emerald-600' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/><path d="M4 2C2.8 3.7 2 5.7 2 8"/><path d="M22 8c0-2.3-.8-4.3-2-6"/></svg>
                                Pengumuman
                            </a>
                        @endif
                        @if (Route::has('janji-temu.index'))
                            <a href="{{ route('janji-temu.index') }}"
                               class="flex items-center gap-2 py-1.5 px-2 rounded text-sm {{ Route::is('janji-temu*') ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-slate-600 hover:text-emerald-600' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><circle cx="16" cy="16" r="6"/><path d="M16 14v2l1 1"/></svg>
                                Janji Temu
                            </a>
                        @endif
                    </div>
                </div>

                @if (Route::has('wisata.index'))
                    <a href="{{ route('wisata.index') }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is('wisata*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Wisata
                    </a>
                @endif

                @if (Route::has('umkm.index'))
                    <a href="{{ route('umkm.index') }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is('umkm*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        UMKM
                    </a>
                @endif

                @if (Route::has('galeri.index'))
                    <a href="{{ route('galeri.index') }}"
                       class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ Route::is('galeri*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Galeri
                    </a>
                @endif

                @if (Route::has('pengaduan.create'))
                    <a href="{{ route('pengaduan.create') }}"
                       class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold bg-amber-500 text-white text-center mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="12" y1="8" x2="12" y2="14"/><line x1="9" y1="11" x2="15" y2="11"/></svg>
                        <span>Lapor Pengaduan</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

{{-- ============ FLASH MESSAGES ============ --}}
<div class="fixed top-24 right-4 z-50 space-y-2 max-w-sm sm:max-w-md w-full px-4 sm:px-0">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition x-cloak
             class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                {{-- Lucide: CheckCircle2 --}}
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                {{-- Lucide: Info --}}
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span>{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                {{-- Lucide: AlertTriangle --}}
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-white/80 hover:text-white">&times;</button>
        </div>
    @endif
</div>

{{-- ============ MAIN CONTENT ============ --}}
<main class="{{ $isHome ? '' : 'pt-24 sm:pt-28' }} pb-12 overflow-x-hidden">
    @yield('content')
</main>

{{-- ============ TOMBOL WHATSAPP TUNGGAL ============ --}}
<div id="wa-button-container" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50">
    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ rawurlencode($waText) }}"
       target="_blank"
       rel="noopener noreferrer"
       class="flex items-center gap-2.5 bg-[#25D366] hover:bg-[#1EBE57] text-white px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-full shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95"
       aria-label="Hubungi WhatsApp Admin">
        <svg class="w-5 h-5 sm:w-6 sm:h-6 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
        <span class="font-bold text-xs sm:text-sm tracking-wide">Hubungi Kami</span>
    </a>
</div>

{{-- ============ FOOTER ============ --}}
<footer class="bg-[#0B1F3A] text-slate-300 pt-16 pb-8 overflow-x-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-10 border-b border-white/10">

            {{-- Kolom 1 & 2: Identitas & Deskripsi --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <img src="{{ $faviconUrl }}"
                         alt="Logo Footer" class="w-9 h-9 object-contain rounded-lg">
                    <span class="font-bold text-white text-lg">{{ $namaFooter }}</span>
                </div>
                <p class="text-sm text-slate-400 max-w-sm leading-relaxed mb-6">
                    {{ $defaultDesc }}
                </p>

                {{-- Link Media Sosial --}}
                @if($fbUrl || $igUrl || $ytUrl || $ttUrl)
                    <div class="flex items-center gap-3">
                        @if($fbUrl)
                            <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 text-white flex items-center justify-center transition">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                        @endif
                        @if($igUrl)
                            <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 text-white flex items-center justify-center transition">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                        @endif
                        @if($ytUrl)
                            <a href="{{ $ytUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 text-white flex items-center justify-center transition">
                                <i class="fab fa-youtube text-sm"></i>
                            </a>
                        @endif
                        @if($ttUrl)
                            <a href="{{ $ttUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 text-white flex items-center justify-center transition">
                                <i class="fab fa-tiktok text-sm"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Kolom 3: Tautan Cepat --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Tautan Cepat</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li>
                        @if (Route::has('pengajuan.lacak'))
                            <a href="{{ route('pengajuan.lacak') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                {{-- Lucide: ChevronRight --}}
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Lacak Pengajuan
                            </a>
                        @elseif (Route::has('pengaduan.lacak'))
                            <a href="{{ route('pengaduan.lacak') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Lacak Pengaduan
                            </a>
                        @else
                            <a href="{{ url('/') }}#lacak" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Lacak Pengajuan
                            </a>
                        @endif
                    </li>
                    @if (Route::has('pengumuman.index'))
                        <li>
                            <a href="{{ route('pengumuman.index') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Pengumuman
                            </a>
                        </li>
                    @endif
                    @if (Route::has('galeri.index'))
                        <li>
                            <a href="{{ route('galeri.index') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Galeri Kegiatan
                            </a>
                        </li>
                    @endif
                    @if (Route::has('wisata.index'))
                        <li>
                            <a href="{{ route('wisata.index') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Wisata Okura
                            </a>
                        </li>
                    @endif
                    @if (Route::has('umkm.index'))
                        <li>
                            <a href="{{ route('umkm.index') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Direktori UMKM
                            </a>
                        </li>
                    @endif
                    @if (Route::has('berita.index'))
                        <li>
                            <a href="{{ route('berita.index') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                Berita & Kegiatan
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Kolom 4: Kontak & Jam Pelayanan --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Kontak & Jam Kerja</h4>
                <ul class="space-y-2.5 text-sm text-slate-400 mb-4">
                    <li class="flex items-start gap-2.5">
                        {{-- Lucide: MapPin --}}
                        <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-10a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $defaultAlamat }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        {{-- Lucide: Mail --}}
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <span>{{ $defaultEmail }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        {{-- Lucide: Phone --}}
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>{{ $defaultTelp }}</span>
                    </li>
                </ul>

                <h5 class="text-white font-semibold text-xs uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    {{-- Lucide: Clock --}}
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>Jam Pelayanan</span>
                </h5>
                <div class="text-xs text-slate-400 space-y-1 bg-slate-900/50 p-3 rounded-xl border border-white/5">
                    <p><span class="font-medium text-slate-200">Senin - Kamis:</span> {{ $jamSeninKamis }}</p>
                    <p><span class="font-medium text-slate-200">Jum'at:</span> {{ $jamJumat }}</p>
                    <p><span class="font-medium text-slate-200">Sabtu - Minggu:</span> {{ $jamSabtuMinggu }}</p>
                </div>
            </div>

        </div>

        {{-- Copyright --}}
        <p class="text-center text-xs text-slate-500 pt-6">
            &copy; {{ date('Y') }} {{ $namaFooter }} — Persembahan dari KKN Kelompok 10 GOKURA USTI 2026. Seluruh Hak Dilindungi.
        </p>
    </div>
</footer>

@stack('scripts')
</body>
</html>

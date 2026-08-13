{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Kelurahan Tebing Tinggi Okura')

@section('content')

{{-- ================= HERO SECTION — CAROUSEL DINAMIS ================= --}}
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden"
         x-data="{
             slides: {{ $banners->count() ? $banners->count() : 1 }},
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
                 clearInterval(this.autoplay);
                 if (this.slides > 1) this.autoplay = setInterval(() => this.next(), 6000);
             }
         }">

    <div class="absolute inset-0">
        @forelse ($banners as $i => $banner)
            <div x-show="current === {{ $i }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 class="absolute inset-0">
                <img src="{{ asset('storage/'.$banner->gambar) }}" alt="{{ $banner->judul }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0B1F3A]/80 via-[#0B1F3A]/60 to-[#0B1F3A]/90"></div>
            </div>
        @empty
            <div class="absolute inset-0">
                <img src="{{ asset('images/hero-okura.jpg') }}" alt="Okura" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0B1F3A]/80 via-[#0B1F3A]/60 to-[#0B1F3A]/90"></div>
            </div>
        @endforelse
    </div>

    @if ($banners->count() > 1)
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            @foreach ($banners as $i => $banner)
                <button @click="goTo({{ $i }})" :class="current === {{ $i }} ? 'w-8 bg-amber-400' : 'w-2 bg-white/40'" class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
    @endif

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center pt-32 sm:pt-28 pb-10" x-data="{ counted: false }" x-intersect="counted = true">
        <span class="inline-block px-4 py-1.5 mb-5 rounded-full bg-amber-400/20 text-amber-300 text-sm font-medium border border-amber-400/30">
            Portal Resmi Kelurahan
        </span>

        <h1 class="text-4xl sm:text-6xl font-bold text-white leading-tight tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            @if ($banners->isNotEmpty() && $banners->first()->judul)
                <span x-text="{{ json_encode($banners->pluck('judul')) }}[current] || '{{ $banners->first()->judul }}'"></span>
            @else
                Tebing Tinggi Okura
            @endif
        </h1>
        <p class="mt-4 text-lg sm:text-xl text-slate-200 max-w-2xl mx-auto">
            Menyajikan pelayanan, informasi, dan potensi wisata & UMKM warga secara cepat, transparan, dan modern.
        </p>

        <div id="lacak" class="mt-8 max-w-xl mx-auto" x-data="{ tab: window.location.hash === '#lacak' ? 'lacak' : 'cari' }">
            <div class="flex bg-white/10 backdrop-blur rounded-xl p-1 mb-3 max-w-xs mx-auto">
                <button @click="tab = 'cari'"
                        :class="tab === 'cari' ? 'bg-white text-emerald-700' : 'text-white/70'"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition">
                    Cari Informasi
                </button>
                <button @click="tab = 'lacak'"
                        :class="tab === 'lacak' ? 'bg-white text-emerald-700' : 'text-white/70'"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition">
                    Lacak Pengajuan
                </button>
            </div>

            <form x-show="tab === 'cari'" action="{{ route('search') }}" method="GET">
                <div class="flex items-center bg-white/95 backdrop-blur rounded-2xl shadow-lg p-2">
                    <svg class="w-5 h-5 text-slate-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari: Syarat SKTM, Wisata Sungai Siak, UMKM..."
                           class="flex-1 px-3 py-2.5 bg-transparent focus:outline-none text-slate-700 text-sm sm:text-base">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Cari
                    </button>
                </div>
            </form>

            <form x-show="tab === 'lacak'" x-cloak action="{{ route('tracking.universal') }}" method="POST">
                @csrf
                <div class="flex items-center bg-white/95 backdrop-blur rounded-2xl shadow-lg p-2">
                    <svg class="w-5 h-5 text-slate-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <input type="text" name="kode_tiket" placeholder="Masukkan kode tiket, contoh: ADU-20260809-001"
                           class="flex-1 px-3 py-2.5 bg-transparent focus:outline-none text-slate-700 text-sm sm:text-base font-mono">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Lacak
                    </button>
                </div>
                @error('kode_tiket')
                    <p class="text-xs text-red-300 mt-2 text-center bg-red-900/30 rounded-lg py-1.5">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <div class="mt-12 mb-6 grid grid-cols-3 gap-4 max-w-lg mx-auto">
            <div class="text-center" x-data="{ val: 0 }" x-init="if (counted) { let t = setInterval(() => { val += 89; if (val >= 5342) { val = 5342; clearInterval(t); } }, 15) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val.toLocaleString('id-ID')"></p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Jumlah Penduduk</p>
            </div>
            <div class="text-center" x-data="{ val: 0 }" x-init="if (counted) { let t = setInterval(() => { val += 1; if (val >= 12) { val = 12; clearInterval(t); } }, 80) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val"></p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Destinasi Wisata</p>
            </div>
            <div class="text-center" x-data="{ val: 0 }" x-init="if (counted) { let t = setInterval(() => { val += 2; if (val >= 48) { val = 48; clearInterval(t); } }, 30) }">
                <p class="text-2xl sm:text-3xl font-bold text-amber-300" x-text="val"></p>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">UMKM Terdaftar</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= QUICK ACCESS CARDS (Melayang) ================= --}}
<section class="relative z-20 -mt-10 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $quickLinks = [
                ['icon' => '📄', 'label' => 'Layanan Surat', 'desc' => 'Ajukan & lacak', 'route' => 'layanan.index', 'color' => 'bg-emerald-50 text-emerald-700'],
                ['icon' => '📢', 'label' => 'Lapor Pengaduan', 'desc' => 'Sampaikan keluhan', 'route' => 'pengaduan.create', 'color' => 'bg-amber-50 text-amber-700'],
                ['icon' => '🏞️', 'label' => 'Wisata Okura', 'desc' => 'Jelajahi destinasi', 'route' => 'wisata.index', 'color' => 'bg-sky-50 text-sky-700'],
                ['icon' => '🛍️', 'label' => 'UMKM Warga', 'desc' => 'Dukung usaha lokal', 'route' => 'umkm.index', 'color' => 'bg-rose-50 text-rose-700'],
            ];
        @endphp

        @foreach ($quickLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-5 transition-all duration-300 hover:-translate-y-1 border border-slate-100">
                <div class="w-12 h-12 rounded-xl {{ $link['color'] }} flex items-center justify-center text-2xl mb-3">
                    {{ $link['icon'] }}
                </div>
                <h3 class="font-semibold text-slate-800 text-sm sm:text-base">{{ $link['label'] }}</h3>
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
        {{-- Card besar: Peta --}}
        <div class="md:col-span-2 md:row-span-2 bg-white rounded-2xl shadow-md p-6 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-3">📍 Peta Wilayah</h3>
            <div id="peta-kelurahan" class="w-full h-64 md:h-80 rounded-xl bg-slate-100"></div>
            <p class="text-xs text-slate-500 mt-3">Kelurahan Tebing Tinggi Okura, Kec. Rumbai Pesisir, Pekanbaru.</p>
        </div>

        {{-- Card: Visi Misi --}}
        <div class="md:col-span-2 bg-[#0B1F3A] rounded-2xl shadow-md p-6 text-white">
            <h3 class="font-semibold mb-2">🎯 Visi Kelurahan</h3>
            <p class="text-sm text-slate-200 leading-relaxed">
                Mewujudkan kelurahan yang mandiri, sejahtera, dan berdaya saing berbasis potensi lokal dan pelayanan prima.
            </p>
            <a href="{{ route('profil') }}" class="inline-block mt-4 text-amber-300 text-sm font-medium hover:underline">
                Selengkapnya →
            </a>
        </div>

        {{-- Card: Pengumuman Terbaru --}}
        <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-2">📢 Pengumuman Terbaru</h3>
            @forelse ($pengumumanTerbaru as $item)
                <a href="{{ route('pengumuman.show', $item) }}" class="block text-xs text-slate-500 hover:text-emerald-600 py-1 truncate">
                    • {{ $item->judul }}
                </a>
            @empty
                <p class="text-xs text-slate-400">Belum ada pengumuman aktif.</p>
            @endforelse
            <a href="{{ route('pengumuman.index') }}" class="inline-block mt-3 text-emerald-600 text-sm font-medium hover:underline">
                Lihat Semua →
            </a>
        </div>

        {{-- Card: Transparansi Anggaran (CHART BENERAN) --}}
        <div class="bg-amber-50 rounded-2xl shadow-md p-6 border border-amber-100">
            <h3 class="font-semibold text-amber-800 mb-2">📊 Transparansi Anggaran {{ now()->year }}</h3>
            @if ($anggaranTahunIni->count())
                <canvas id="chartAnggaranHome" height="120"></canvas>
            @else
                <p class="text-xs text-amber-700">Data anggaran belum tersedia untuk tahun ini. Silakan input data di menu Admin &rarr; Anggaran.</p>
            @endif
        </div>
    </div>
</section>

{{-- ================= WISATA OKURA ================= --}}
<section class="bg-slate-50 py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wide">Jelajahi</span>
                <h2 class="text-3xl font-bold text-[#0B1F3A] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Potensi Wisata Okura
                </h2>
            </div>
            <a href="{{ route('wisata.index') }}" class="hidden sm:block text-emerald-600 font-medium text-sm hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($wisatas ?? [] as $wisata)
                <a href="{{ route('wisata.show', $wisata->slug) }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $wisata->thumbnail ? asset('storage/' . $wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                             alt="{{ $wisata->nama }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-800">{{ $wisata->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $wisata->deskripsi }}</p>
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-400 col-span-3 text-center py-10">Belum ada data wisata.</p>
            @endforelse
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
        <a href="{{ route('umkm.index') }}" class="hidden sm:block text-emerald-600 font-medium text-sm hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse ($umkms ?? [] as $umkm)
            <a href="{{ route('umkm.show', $umkm->id) }}"
               class="rounded-2xl bg-white shadow-md hover:shadow-xl transition p-4 border border-slate-100">
                <div class="h-28 rounded-xl overflow-hidden mb-3">
                    <img src="{{ $umkm->foto ? asset('storage/' . $umkm->foto) : asset('images/placeholder.jpg') }}"
                         loading="lazy"
                         class="w-full h-full object-cover" alt="{{ $umkm->nama_usaha }}">
                </div>
                <h3 class="font-semibold text-sm text-slate-800 truncate">{{ $umkm->nama_usaha }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $umkm->kategori }}</p>
            </a>
        @empty
            <p class="text-sm text-slate-400 col-span-4 text-center py-10">Belum ada data UMKM.</p>
        @endforelse
    </div>
</section>

{{-- ================= WIDGET SURVEI KEPUASAN ================= --}}
<section class="max-w-2xl mx-auto px-4 sm:px-6 py-16">
    @include('frontend.partials.widget-survei')
</section>

{{-- ================= FLOATING WHATSAPP BUTTON ================= --}}
<a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kelurahan%20Tebing%20Tinggi%20Okura"
   target="_blank"
   class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 rounded-full bg-emerald-500 shadow-xl hover:bg-emerald-600 transition-all hover:scale-110">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.86 9.86 0 004.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.13a8.2 8.2 0 01-4.18-1.14l-.3-.18-3.11.82.83-3.04-.2-.31a8.22 8.22 0 01-1.26-4.37c0-4.54 3.7-8.24 8.24-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 012.41 5.83c0 4.54-3.7 8.21-8.26 8.21z"/>
    </svg>
</a>

@endsection

@push('scripts')
<script>
    // Inisialisasi Leaflet Map (Peta Interaktif)
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('peta-kelurahan')) {
            const map = L.map('peta-kelurahan').setView([0.6183, 101.5854], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([0.6183, 101.5854]).addTo(map).bindPopup('Kantor Lurah Tebing Tinggi Okura');
        }
    });
</script>

{{-- Chart Transparansi Anggaran --}}
@if ($anggaranTahunIni->count())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartAnggaranHome');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($anggaranTahunIni->pluck('kategori')),
                    datasets: [{
                        data: @json($anggaranTahunIni->pluck('jumlah')),
                        backgroundColor: '#D97706',
                        borderRadius: 6,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { ticks: { callback: (v) => 'Rp' + (v/1000000) + 'jt' } } }
                }
            });
        }
    });
</script>
@endif
@endpush

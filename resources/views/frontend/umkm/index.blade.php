{{-- resources/views/frontend/umkm/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'UMKM Warga')

@section('content')
<section class="pt-20 pb-12 sm:pt-24 sm:pb-16 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8 sm:mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-semibold mb-3">
                Dukung Lokal
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A] leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                UMKM Warga Tebing Tinggi Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Dukung produk lokal masyarakat dan temukan berbagai usaha unggulan
                Kelurahan Tebing Tinggi Okura.
            </p>
        </div>

        {{-- Banner Highlight UMKM Unggulan dengan Lengkungan yang Pasti Terlihat --}}
        @if ($umkms->count() > 0)
            @php
                // Pilih UMKM secara acak agar banner berganti setiap halaman ditampilkan.
                $highlight = $umkms->random();
                $highlightImg = $highlight->foto ?? $highlight->foto_produk;
            @endphp

            {{--
                Kunci lengkungan:
                1. relative & overflow-hidden (wajib agar gambar di dalam terpotong ikut lekukan)
                2. rounded-[28px] sm:rounded-[36px] (membuat lekukan sangat jelas)
            --}}
            <div class="relative w-full min-h-[420px] h-[120vw] max-h-[440px] sm:h-[400px] md:h-[440px] rounded-2xl sm:rounded-[36px] overflow-hidden mb-8 sm:mb-12 shadow-xl border border-slate-200/60 transform-gpu">

                {{-- Gambar Banner Background --}}
                 <img id="umkm-highlight-image" src="{{ $highlightImg ? asset('storage/'.$highlightImg) : asset('images/placeholder.jpg') }}"
                     alt="{{ $highlight->nama_usaha }}"
                     class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-700 ease-in-out">

                {{-- Overlay hitam merata agar warna banner tidak berbeda-beda mengikuti posisi gambar --}}
                <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

                {{-- Konten Teks di Atas Gambar --}}
                <div class="relative z-10 h-full flex items-center p-4 sm:p-12 md:p-14">
                    <div class="w-full max-w-xl text-white min-w-0 rounded-2xl bg-black/30 backdrop-blur-[2px] p-4 sm:p-6 drop-shadow-md">

                        <span class="inline-block text-[11px] sm:text-xs font-bold tracking-widest uppercase text-emerald-300 mb-2 drop-shadow-sm">
                            UMKM UNGGULAN
                        </span>

                        <h2 class="text-xl sm:text-3xl md:text-4xl font-extrabold leading-tight mb-3 tracking-tight text-white drop-shadow-lg break-words">
                            <span id="umkm-highlight-name">{{ $highlight->nama_usaha }}</span>
                        </h2>

                        <p class="text-xs sm:text-sm text-white/90 leading-relaxed line-clamp-3 mb-4 sm:mb-6 font-normal max-w-lg break-words drop-shadow-md">
                            <span id="umkm-highlight-description">{{ $highlight->deskripsi ?? 'Di tempat ini kita bisa menemukan berbagai produk unggulan dan karya lokal khas warga Kelurahan Tebing Tinggi Okura.' }}</span>
                        </p>

                        <a id="umkm-highlight-link" href="{{ route('umkm.show', $highlight->id) }}"
                           class="inline-flex max-w-full items-center gap-2 px-4 sm:px-5 py-2.5 bg-white text-slate-900 hover:bg-emerald-600 hover:text-white rounded-xl text-xs sm:text-sm font-bold transition duration-300 shadow-md group">
                            <span>Lihat Detail</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>

                    </div>
                </div>

            </div>
        @endif

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 justify-center mb-6 sm:mb-8 px-1">
            @foreach (['' => 'Semua', 'kuliner' => 'Kuliner', 'kerajinan' => 'Kerajinan', 'jasa' => 'Jasa', 'pertanian' => 'Pertanian', 'lainnya' => 'Lainnya'] as $val => $label)
                <a href="{{ route('umkm.index', ['kategori' => $val]) }}"
                   class="px-3 sm:px-4 py-1.5 rounded-full text-[11px] sm:text-xs font-medium transition {{ request('kategori', '') == $val ? 'bg-emerald-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Grid Daftar UMKM --}}
        <div class="grid grid-cols-1 min-[360px]:grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($umkms as $umkm)
                <a href="{{ route('umkm.show', $umkm->id) }}"
                         class="group h-full rounded-xl sm:rounded-2xl bg-white shadow-md hover:shadow-xl transition p-3 sm:p-4 border border-slate-100 flex flex-col justify-between min-w-0">
                    <div>
                        <div class="aspect-square w-full rounded-lg sm:rounded-xl overflow-hidden mb-3 relative">
                            @php
                                $imgSrc = $umkm->foto ?? $umkm->foto_produk;
                            @endphp
                            <img src="{{ $imgSrc ? asset('storage/'.$imgSrc) : asset('images/placeholder.jpg') }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                 alt="{{ $umkm->nama_usaha }}"
                                 loading="lazy">

                            {{-- Badge Views Transparan --}}
                            <div class="absolute top-2 right-2 bg-black/50 backdrop-blur-md text-white text-[10px] font-medium px-2 py-0.5 rounded-full flex items-center gap-1 border border-white/20">
                                <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ number_format($umkm->views ?? 0) }}</span>
                            </div>
                        </div>
                        <h3 class="font-semibold text-xs sm:text-sm text-slate-800 truncate group-hover:text-emerald-600 transition">{{ $umkm->nama_usaha }}</h3>
                    </div>

                    <p class="text-[10px] sm:text-xs text-slate-500 mt-2 capitalize flex items-center justify-between gap-1 border-t border-slate-50 pt-2">
                        <span>{{ $umkm->kategori }}</span>
                        <span class="text-emerald-600 font-medium">Detail &rarr;</span>
                    </p>
                </a>
            @empty
                <p class="col-span-full text-center text-slate-400 text-sm py-12 sm:py-16">Belum ada data UMKM.</p>
            @endforelse
        </div>

        @if ($umkms->hasPages())
            <div class="mt-8 sm:mt-10 overflow-x-auto">{{ $umkms->links() }}</div>
        @endif
    </div>
</section>

@if ($umkms->count() > 1)
    @php
        $slides = $umkms->map(function ($umkm) {
            $image = $umkm->foto ?? $umkm->foto_produk;

            return [
                'name' => $umkm->nama_usaha,
                'description' => $umkm->deskripsi ?? 'Di tempat ini kita bisa menemukan berbagai produk unggulan dan karya lokal khas warga Kelurahan Tebing Tinggi Okura.',
                'image' => $image ? asset('storage/' . $image) : asset('images/placeholder.jpg'),
                'url' => route('umkm.show', $umkm->id),
            ];
        })->values();
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = @json($slides);
            const image = document.getElementById('umkm-highlight-image');
            const name = document.getElementById('umkm-highlight-name');
            const description = document.getElementById('umkm-highlight-description');
            const link = document.getElementById('umkm-highlight-link');
            let index = {{ $umkms->search($highlight) }};

            setInterval(function () {
                image.style.opacity = '0';
                setTimeout(function () {
                    index = (index + 1) % slides.length;
                    const slide = slides[index];
                    image.src = slide.image;
                    image.alt = slide.name;
                    name.textContent = slide.name;
                    description.textContent = slide.description;
                    link.href = slide.url;
                    image.style.opacity = '1';
                }, 700);
            }, 15000);
        });
    </script>
@endif
@endsection

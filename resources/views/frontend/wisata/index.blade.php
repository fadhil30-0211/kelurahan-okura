{{-- resources/views/frontend/wisata/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Wisata Okura')

@section('content')
<section class="pt-20 pb-12 sm:pt-24 sm:pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold mb-3">
                Jelajahi
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A] leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Potensi Wisata Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Jelajahi potensi wisata alam, tepian Sungai Siak, dan suasana khas Kelurahan Tebing Tinggi Okura.
            </p>
        </div>

        {{-- Banner Highlight Wisata Unggulan --}}
        @if ($wisatas->count() > 0)
            @php
                $highlight = $wisatas->random();
                $highlightItems = $wisatas->map(fn ($wisata) => [
                    'nama' => $wisata->nama,
                    'deskripsi' => $wisata->deskripsi ?? 'Jelajahi keindahan dan potensi wisata Kelurahan Tebing Tinggi Okura.',
                    'slug' => $wisata->slug,
                    'image' => $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg'),
                ])->values();
            @endphp

            <div id="wisata-highlight" class="relative w-full min-h-[420px] h-[120vw] max-h-[440px] sm:h-[400px] md:h-[440px] rounded-2xl sm:rounded-[36px] overflow-hidden mb-8 sm:mb-12 shadow-xl border border-slate-200/60 transform-gpu">
                <img src="{{ $highlight->thumbnail ? asset('storage/'.$highlight->thumbnail) : asset('images/placeholder.jpg') }}"
                     id="highlight-image"
                     alt="{{ $highlight->nama }}"
                     class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-700 ease-in-out"
                     loading="eager">

                <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

                <div class="relative z-10 h-full flex items-center p-4 sm:p-12 md:p-14">
                    <div class="w-full max-w-xl text-white min-w-0 rounded-2xl bg-black/30 backdrop-blur-[2px] p-4 sm:p-6 drop-shadow-md">
                        <span class="inline-block text-[11px] sm:text-xs font-bold tracking-widest uppercase text-emerald-300 mb-2 drop-shadow-sm">
                            WISATA UNGGULAN
                        </span>

                        <h2 id="highlight-title" class="text-xl sm:text-3xl md:text-4xl font-extrabold leading-tight mb-3 tracking-tight text-white drop-shadow-lg break-words transition-opacity duration-500">
                            {{ $highlight->nama }}
                        </h2>

                        <p id="highlight-description" class="text-xs sm:text-sm text-white/90 leading-relaxed line-clamp-3 mb-4 sm:mb-6 font-normal max-w-lg break-words drop-shadow-md transition-opacity duration-500">
                            {{ $highlight->deskripsi ?? 'Jelajahi keindahan dan potensi wisata Kelurahan Tebing Tinggi Okura.' }}
                        </p>

                        <a id="highlight-link" href="{{ route('wisata.show', $highlight->slug) }}"
                           class="inline-flex max-w-full items-center gap-2 px-4 sm:px-5 py-2.5 bg-white text-slate-900 hover:bg-emerald-600 hover:text-white rounded-xl text-xs sm:text-sm font-bold transition duration-300 shadow-md group">
                            <span>Lihat Detail</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const items = @json($highlightItems);
                    if (items.length < 2) return;

                    const image = document.getElementById('highlight-image');
                    const title = document.getElementById('highlight-title');
                    const description = document.getElementById('highlight-description');
                    const link = document.getElementById('highlight-link');
                    let index = items.findIndex(item => item.slug === @json($highlight->slug));

                    setInterval(() => {
                        index = (index + 1) % items.length;
                        const item = items[index];

                        [image, title, description].forEach(element => element.classList.add('opacity-0'));
                        setTimeout(() => {
                            image.src = item.image;
                            image.alt = item.nama;
                            title.textContent = item.nama;
                            description.textContent = item.deskripsi;
                            link.href = '{{ url('/wisata') }}/' + item.slug;
                            [image, title, description].forEach(element => element.classList.remove('opacity-0'));
                        }, 450);
                    }, 15000);
                });
            </script>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($wisatas as $wisata)
                     <a href="{{ route('wisata.show', $wisata->slug) }}"
                         class="group min-w-0 rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="h-44 sm:h-48 overflow-hidden relative">
                            {{-- Mempertahankan tag gambar yang memanggil variabel $wisata dan menambahkan loading="lazy" --}}
                            <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $wisata->nama }}"
                                 loading="lazy">

                            {{-- Badge Views di atas gambar --}}
                            <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-md text-white text-[10px] font-medium px-2.5 py-1 rounded-full flex items-center gap-1 border border-white/20">
                                <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ number_format($wisata->views ?? 0) }}</span>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="font-semibold text-slate-800 break-words group-hover:text-emerald-600 transition-colors">{{ $wisata->nama }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 break-words">{{ $wisata->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-0 flex flex-wrap items-center justify-between gap-x-3 border-t border-slate-50 mt-2">
                        <p class="text-xs text-emerald-600 font-semibold pt-3 break-words">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                        <span class="text-xs text-slate-400 pt-3 group-hover:text-slate-600 flex items-center gap-0.5 transition-colors whitespace-nowrap">
                            Lihat Detail &rarr;
                        </span>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-slate-400 text-sm py-16">Belum ada data wisata.</p>
            @endforelse
        </div>

        @if ($wisatas->hasPages())
            <div class="mt-10">{{ $wisatas->links() }}</div>
        @endif
    </div>
</section>
@endsection

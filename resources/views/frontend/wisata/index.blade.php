{{-- resources/views/frontend/wisata/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Wisata Okura')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold mb-3">
                Jelajahi
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Potensi Wisata Okura
            </h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($wisatas as $wisata)
                <a href="{{ route('wisata.show', $wisata->slug) }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="h-48 overflow-hidden relative">
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
                            <h3 class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $wisata->nama }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $wisata->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-0 flex items-center justify-between border-t border-slate-50 mt-2">
                        <p class="text-xs text-emerald-600 font-semibold pt-3">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                        <span class="text-xs text-slate-400 pt-3 group-hover:text-slate-600 flex items-center gap-0.5 transition-colors">
                            Lihat Detail &rarr;
                        </span>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-slate-400 text-sm py-16">Belum ada data wisata.</p>
            @endforelse
        </div>

        @if ($wisatas->hasPages())
            <div class="mt-10">{{ $wisatas->links() }}</div>
        @endif
    </div>
</section>
@endsection

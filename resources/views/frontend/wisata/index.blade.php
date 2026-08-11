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
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="h-48 overflow-hidden">
                        {{-- Mempertahankan tag gambar yang memanggil variabel $wisata dan menambahkan loading="lazy" --}}
                        <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $wisata->nama }}"
                             loading="lazy">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-800">{{ $wisata->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $wisata->deskripsi }}</p>
                        <p class="text-xs text-emerald-600 font-medium mt-3">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
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

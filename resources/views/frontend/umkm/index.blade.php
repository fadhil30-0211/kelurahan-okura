{{-- resources/views/frontend/umkm/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'UMKM Warga')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-semibold mb-3">
                Dukung Lokal
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                UMKM Warga Okura
            </h1>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            @foreach (['' => 'Semua', 'kuliner' => 'Kuliner', 'kerajinan' => 'Kerajinan', 'jasa' => 'Jasa', 'pertanian' => 'Pertanian', 'lainnya' => 'Lainnya'] as $val => $label)
                <a href="{{ route('umkm.index', ['kategori' => $val]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-medium {{ request('kategori', '') == $val ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($umkms as $umkm)
                <a href="{{ route('umkm.show', $umkm->id) }}"
                   class="group rounded-2xl bg-white shadow-md hover:shadow-xl transition p-4 border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="h-32 rounded-xl overflow-hidden mb-3 relative">
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
                        <h3 class="font-semibold text-sm text-slate-800 truncate group-hover:text-emerald-600 transition">{{ $umkm->nama_usaha }}</h3>
                    </div>

                    <p class="text-xs text-slate-500 mt-2 capitalize flex items-center justify-between border-t border-slate-50 pt-2">
                        <span>{{ $umkm->kategori }}</span>
                        <span class="text-emerald-600 font-medium">Detail &rarr;</span>
                    </p>
                </a>
            @empty
                <p class="col-span-4 text-center text-slate-400 text-sm py-16">Belum ada data UMKM.</p>
            @endforelse
        </div>

        @if ($umkms->hasPages())
            <div class="mt-10">{{ $umkms->links() }}</div>
        @endif
    </div>
</section>
@endsection

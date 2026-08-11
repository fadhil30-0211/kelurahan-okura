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
                   class="rounded-2xl bg-white shadow-md hover:shadow-xl transition p-4 border border-slate-100">
                    <div class="h-28 rounded-xl overflow-hidden mb-3">
                        <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                             class="w-full h-full object-cover" alt="{{ $umkm->nama_usaha }}">

                        <img src="{{ $umkm->foto_produk ? asset('storage/' . $umkm->foto_produk) : asset('images/placeholder.jpg') }}"
                        alt="{{ $umkm->nama_usaha }}"
                        class="w-full h-48 object-cover"
                        loading="lazy">
                    </div>
                    <h3 class="font-semibold text-sm text-slate-800 truncate">{{ $umkm->nama_usaha }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5 capitalize">{{ $umkm->kategori }}</p>
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

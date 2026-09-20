@extends('layouts.app') {{-- Gunakan layout utama project Anda --}}

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">Direktori UMKM Okura</h1>
    <p class="text-slate-600 mb-8">Daftar usaha dan produk lokal Kelurahan Tebing Tinggi Okura.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($umkms as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_usaha }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-800">{{ $item->nama_usaha }}</h3>
                    <p class="text-slate-500 text-sm mt-1">{{ Str::limit($item->deskripsi ?? '', 100) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs bg-emerald-100 text-emerald-800 font-medium px-2.5 py-1 rounded-full">
                            {{ $item->kategori ?? 'UMKM' }}
                        </span>
                        @if($item->no_wa)
                            <a href="https://wa.me/{{ $item->no_wa }}" target="_blank" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                                Hubungi WA &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-slate-500">Belum ada data UMKM yang terdaftar.</p>
            </div>
        @forelse
    </div>

    <div class="mt-8">
        {{ $umkms->links() }}
    </div>
</div>
@endsection

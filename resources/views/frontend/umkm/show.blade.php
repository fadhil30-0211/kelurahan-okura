{{-- resources/views/frontend/umkm/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $umkm->nama_usaha)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
            <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                 class="w-full h-64 sm:h-80 object-cover" alt="{{ $umkm->nama_usaha }}">

            <div class="p-6 sm:p-8">
                <span class="inline-block px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-semibold mb-3 capitalize">
                    {{ $umkm->kategori }}
                </span>
                <h1 class="text-2xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $umkm->nama_usaha }}
                </h1>
                <p class="text-sm text-slate-500 mt-1">Pemilik: {{ $umkm->nama_pemilik }}</p>

                <p class="text-sm text-slate-600 leading-relaxed mt-5 whitespace-pre-line">{{ $umkm->deskripsi }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Alamat</p>
                        <p class="text-sm text-slate-700">{{ $umkm->alamat }}</p>
                    </div>
                    @if ($umkm->no_hp)
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Kontak</p>
                            <p class="text-sm text-slate-700">{{ $umkm->no_hp }}</p>
                        </div>
                    @endif
                </div>

                @if ($umkm->no_hp)
                    <a href="https://wa.me/62{{ ltrim($umkm->no_hp, '0') }}?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($umkm->nama_usaha) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                        Hubungi via WhatsApp
                    </a>
                @endif
            </div>
        </div>

        @if ($umkmLainnya->count())
            <div class="mt-10">
                <h2 class="font-semibold text-slate-800 mb-4">UMKM Lainnya</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach ($umkmLainnya as $item)
                        <a href="{{ route('umkm.show', $item->id) }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-3">
                            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : asset('images/placeholder.jpg') }}"
                                 class="w-full h-24 object-cover rounded-lg mb-2" alt="">
                            <p class="text-xs font-medium text-slate-700 truncate">{{ $item->nama_usaha }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

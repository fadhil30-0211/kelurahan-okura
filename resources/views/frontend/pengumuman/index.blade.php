{{-- resources/views/frontend/pengumuman/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Pengumuman Kelurahan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Informasi Resmi
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Pengumuman Kelurahan
            </h1>
        </div>

        <div class="space-y-4">
            @forelse ($pengumumans as $item)
                @php
                    $kategoriColor = match($item->kategori) {
                        'darurat' => 'bg-red-50 text-red-700 border-red-100',
                        'penting' => 'bg-amber-50 text-amber-700 border-amber-100',
                        default => 'bg-slate-50 text-slate-600 border-slate-100',
                    };
                @endphp
                <a href="{{ route('pengumuman.show', $item) }}"
                   class="block bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition p-6">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <h3 class="font-semibold text-slate-800">{{ $item->judul }}</h3>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium flex-shrink-0 border {{ $kategoriColor }}">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 line-clamp-2">{{ $item->isi }}</p>
                    <p class="text-xs text-slate-400 mt-3">{{ $item->tanggal_mulai->translatedFormat('d F Y') }}</p>
                </a>
            @empty
                <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center text-slate-400 text-sm">
                    Belum ada pengumuman aktif saat ini.
                </div>
            @endforelse
        </div>

        @if ($pengumumans->hasPages())
            <div class="mt-8">{{ $pengumumans->links() }}</div>
        @endif
    </div>
</section>
@endsection

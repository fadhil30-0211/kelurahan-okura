{{-- resources/views/frontend/berita/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Berita Kelurahan')

@section('content')
<section class="pt-20 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Informasi
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Berita & Kegiatan Kelurahan
            </h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($beritas as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="h-44 overflow-hidden bg-slate-100 relative">
                            @if ($berita->thumbnail)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($berita->thumbnail) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     alt="{{ $berita->judul }}"
                                     loading="lazy"
                                     onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/475569?text=Berita';">
                            @else
                                <img src="https://placehold.co/600x400/e2e8f0/475569?text=Berita"
                                     class="w-full h-full object-cover"
                                     alt="Gambar Default">
                            @endif
                        </div>
                        <div class="p-5 pb-2">
                            <span class="text-xs text-emerald-600 font-medium capitalize">{{ $berita->kategori }}</span>
                            <h3 class="font-semibold text-slate-800 mt-1 line-clamp-2">{{ $berita->judul }}</h3>
                        </div>
                    </div>

                    {{-- Section Footer Kartu: Tanggal & Jumlah Views --}}
                    <div class="px-5 pb-5 pt-2 flex items-center justify-between text-xs text-slate-400 border-t border-slate-50 mt-2">
                        <span>
                            {{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : $berita->created_at->translatedFormat('d F Y') }}
                        </span>

                        <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ number_format($berita->views ?? 0) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-slate-400 text-sm py-16">Belum ada berita dipublikasikan.</p>
            @endforelse
        </div>

        @if ($beritas->hasPages())
            <div class="mt-10">{{ $beritas->links() }}</div>
        @endif
    </div>
</section>
@endsection

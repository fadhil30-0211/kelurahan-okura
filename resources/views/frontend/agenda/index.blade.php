{{-- resources/views/frontend/agenda/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Agenda Kelurahan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold mb-3">
                Kalender Kegiatan
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Agenda Kelurahan
            </h1>
        </div>

        {{-- Agenda Mendatang --}}
        <div class="mb-12">
            <h2 class="font-semibold text-slate-800 mb-4">📅 Agenda Mendatang</h2>
            <div class="space-y-3">
                @forelse ($agendaMendatang as $agenda)
                    <div class="flex gap-4 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
                        <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-emerald-50 flex flex-col items-center justify-center text-emerald-700">
                            <span class="text-xs font-medium">{{ $agenda->tanggal->translatedFormat('M') }}</span>
                            <span class="text-lg font-bold leading-none">{{ $agenda->tanggal->format('d') }}</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800 text-sm">{{ $agenda->nama_acara }}</h3>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ $agenda->waktu }} @if($agenda->lokasi) · {{ $agenda->lokasi }} @endif
                            </p>
                            @if ($agenda->deskripsi)
                                <p class="text-xs text-slate-400 mt-1.5">{{ $agenda->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-100 p-8 text-center text-slate-400 text-sm">
                        Belum ada agenda mendatang.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Agenda Lalu --}}
        @if ($agendaLalu->count())
            <div>
                <h2 class="font-semibold text-slate-800 mb-4">🗂️ Agenda Sebelumnya</h2>
                <div class="space-y-3">
                    @foreach ($agendaLalu as $agenda)
                        <div class="flex gap-4 bg-slate-50 rounded-2xl border border-slate-100 p-4 opacity-75">
                            <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-slate-200 flex flex-col items-center justify-center text-slate-500">
                                <span class="text-xs font-medium">{{ $agenda->tanggal->translatedFormat('M') }}</span>
                                <span class="text-lg font-bold leading-none">{{ $agenda->tanggal->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-600 text-sm">{{ $agenda->nama_acara }}</h3>
                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $agenda->waktu }} @if($agenda->lokasi) · {{ $agenda->lokasi }} @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($agendaLalu->hasPages())
                    <div class="mt-6">{{ $agendaLalu->links() }}</div>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection

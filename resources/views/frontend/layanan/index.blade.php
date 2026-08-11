{{-- resources/views/frontend/layanan/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Layanan Surat')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Pelayanan Publik
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Layanan Surat Kelurahan
            </h1>
            <p class="text-sm text-slate-500 mt-2 max-w-lg mx-auto">
                Pilih jenis surat yang ingin diajukan. Pastikan berkas persyaratan sudah siap sebelum mengisi form.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">
            @foreach ($jenisSurat as $key => $surat)
                <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6">
                    <h3 class="font-semibold text-slate-800 mb-2">{{ $surat['label'] }}</h3>
                    <p class="text-xs text-slate-500 mb-3">Syarat yang perlu disiapkan:</p>
                    <ul class="space-y-1.5 mb-5">
                        @foreach ($surat['syarat'] as $item)
                            <li class="flex items-center gap-2 text-xs text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('layanan.create', $key) }}"
                       class="block text-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Ajukan Sekarang
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('layanan.track.form') }}" class="text-sm text-emerald-600 font-medium hover:underline">
                Sudah mengajukan? Lacak status surat Anda →
            </a>

            {{-- Tambahan di dalam foreach card jenis surat, resources/views/frontend/layanan/index.blade.php --}}
            <div class="flex gap-2">
                <a href="{{ route('layanan.create', $key) }}"
                class="flex-1 text-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                    Ajukan Sekarang
                </a>
                @if (file_exists(public_path($surat['template'])))
                    <a href="{{ asset($surat['template']) }}" download
                    class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition" title="Download Template">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

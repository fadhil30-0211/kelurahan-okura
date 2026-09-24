@extends('layouts.frontend')

@section('title', 'Lacak Status Tiket')

@section('content')
<section class="py-16 bg-slate-50 min-h-[70vh] flex items-center">
    <div class="max-w-xl mx-auto px-4 w-full">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100">
            <h1 class="text-2xl font-bold text-slate-800 text-center mb-2">Lacak Status Layanan / Pengaduan</h1>
            <p class="text-xs text-slate-500 text-center mb-6">
                Masukkan Kode Tiket (misal: AHW-20260828-003, WST-EE2786, atau UMKM-04C689)
            </p>

            {{-- Form Menggunakan POST dan Route Universal --}}
            <form action="{{ route('lacak.search') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Tiket</label>
                    <div class="flex gap-2">
                        <input type="text" name="kode_tiket" value="{{ old('kode_tiket') }}" placeholder="Contoh: AHW-20260828-003" required
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                            Cari
                        </button>
                    </div>
                    @error('kode_tiket')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

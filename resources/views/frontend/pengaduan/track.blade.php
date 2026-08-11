{{-- resources/views/frontend/pengaduan/track.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Lacak Pengaduan')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen flex items-center">
    <div class="max-w-md mx-auto px-4 sm:px-6 w-full">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Lacak Status Pengaduan
            </h1>
            <p class="text-sm text-slate-500 mt-2">Masukkan kode tiket dan nomor HP yang Anda gunakan saat melapor.</p>
        </div>

        <form action="{{ route('pengaduan.track') }}" method="POST"
              class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Tiket</label>
                <input type="text" name="kode_tiket" value="{{ old('kode_tiket') }}" required placeholder="ADU-20260809-XXXX"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                @error('kode_tiket') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Lacak Sekarang
            </button>
        </form>
    </div>
</section>
@endsection

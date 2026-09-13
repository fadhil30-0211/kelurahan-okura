@extends('layouts.frontend')

@section('title', 'Janji Temu Lurah')

@section('content')

<section class="pt-28 pb-16 min-h-screen bg-slate-50">
    <div class="max-w-xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8">
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold mb-3">
                Layanan Publik
            </span>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]">
                Janji Temu Lurah
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Ajukan janji temu dengan Lurah Tebing Tinggi Okura.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8">

            <form action="{{ route('janji-temu.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nama Pemohon
                    </label>

                    <input
                        type="text"
                        name="nama_pemohon"
                        value="{{ old('nama_pemohon') }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Masukkan nama lengkap"
                    >

                    @error('nama_pemohon')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Contoh: 081234567890"
                    >

                    @error('no_hp')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Keperluan
                    </label>

                    <textarea
                        name="keperluan"
                        rows="4"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Jelaskan keperluan janji temu..."
                    >{{ old('keperluan') }}</textarea>

                    @error('keperluan')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tanggal Diinginkan
                    </label>

                    <input
                        type="date"
                        name="tanggal_diinginkan"
                        value="{{ old('tanggal_diinginkan') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >

                    @error('tanggal_diinginkan')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Waktu Diinginkan
                    </label>

                    <input
                        type="time"
                        name="waktu_diinginkan"
                        value="{{ old('waktu_diinginkan') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >

                    @error('waktu_diinginkan')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                    Ajukan Janji Temu
                </button>

            </form>

            <div class="mt-5 text-center">
                <a
                    href="{{ route('home') }}"
                    class="text-sm text-slate-400 hover:text-emerald-600 transition">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>
</section>

@endsection
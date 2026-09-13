@extends('layouts.frontend')

@section('title', 'Lacak Janji Temu')

@section('content')

<section class="pt-28 pb-16 min-h-screen bg-slate-50">
    <div class="max-w-xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8">
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold mb-3">
                Janji Temu
            </span>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]">
                Lacak Janji Temu
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                Masukkan kode tiket dan nomor HP untuk melihat status janji temu.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8">

            <form action="{{ route('janji-temu.track') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kode Tiket
                    </label>

                    <input
                        type="text"
                        name="kode_tiket"
                        value="{{ old('kode_tiket') }}"
                        required
                        autocomplete="off"
                        placeholder="Contoh: JTM-20260901-001"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 font-mono uppercase focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    @error('kode_tiket')
                        <p class="text-xs text-red-500 mt-1.5">
                            {{ $message }}
                        </p>
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
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    @error('no_hp')
                        <p class="text-xs text-red-500 mt-1.5">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                    Lacak Status
                </button>

            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('home') }}"
                   class="text-sm text-slate-400 hover:text-emerald-600">
                    ← Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>
</section>

@endsection
{{-- resources/views/frontend/pendaftaran/wisata.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Daftarkan Objek Wisata')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Partisipasi Warga
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Daftarkan Objek Wisata
            </h1>
            <p class="text-sm text-slate-500 mt-2">
                Punya usulan tempat wisata atau potensi alam di Okura? Daftarkan agar dapat direview dan masuk direktori wisata.
            </p>
        </div>

        {{-- ALERT SUKSES DENGAN KODE TIKET --}}
        @if(session('success'))
            <div class="mb-6 p-5 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-sm shadow-sm">
                <div class="flex items-center gap-2 font-bold text-emerald-800 text-base mb-1">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Pengajuan Berhasil Dikirim!
                </div>
                <p class="text-xs text-emerald-700 mb-3">{{ session('success') }}</p>

                @if(session('kode_tiket'))
                    <div class="bg-white p-3.5 rounded-xl border border-emerald-200 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Kode Tiket Anda</span>
                            <span class="font-mono font-extrabold text-lg text-emerald-700 tracking-wider">
                                {{ session('kode_tiket') }}
                            </span>
                        </div>
                        <span class="text-[11px] bg-amber-100 text-amber-800 font-medium px-2.5 py-1 rounded-lg">
                            Simpan/Catat Kode Ini
                        </span>
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('pendaftaran.wisata.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Objek Wisata <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_wisata" value="{{ old('nama_wisata') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('nama_wisata') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Pengaju <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pengaju" value="{{ old('nama_pengaju') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('nama_pengaju') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi / Alamat Wisata <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Jl. Wisata Okura RT 02 / RW 01"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('lokasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi & Daya Tarik Wisata <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="4" required minlength="20" placeholder="Ceritakan keunikan, fasilitas, dan keunggulan tempat wisata ini..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP / WhatsApp Pengaju <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Sampul / Gambar Wisata <span class="text-red-500">*</span></label>
                <input type="file" name="foto" accept="image/*" required
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
                @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-xs text-amber-700">
                📋 Pengajuan tempat wisata akan diverifikasi oleh tim kelurahan sebelum ditayangkan pada katalog wisata publik.
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Ajukan Tempat Wisata
            </button>
        </form>
    </div>
</section>
@endsection

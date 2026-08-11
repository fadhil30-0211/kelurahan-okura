{{-- resources/views/frontend/pendaftaran/wisata.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Daftarkan Wisata Baru')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold mb-3">
                Daftarkan Destinasi
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Usulkan Wisata Baru
            </h1>
            <p class="text-sm text-slate-500 mt-2">
                Punya destinasi wisata menarik di Okura? Daftarkan di sini. Tim kami akan verifikasi sebelum tayang di halaman Wisata.
            </p>
        </div>

        <form action="{{ route('pendaftaran.wisata.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8 space-y-5">
            @csrf

            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-slate-600 mb-3">Data Pengaju</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Anda <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pengaju" value="{{ old('nama_pengaju') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('nama_pengaju') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">No. HP Anda <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp_pengaju" value="{{ old('no_hp_pengaju') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        @error('no_hp_pengaju') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Destinasi Wisata <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="4" required minlength="20" placeholder="Ceritakan keunikan destinasi ini..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat / Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Tiket</label>
                    <input type="text" name="harga_tiket" value="{{ old('harga_tiket') }}" placeholder="Gratis / Rp 15.000"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jam Operasional</label>
                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}" placeholder="08.00 - 17.00 WIB"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kontak Pengelola Wisata</label>
                <input type="text" name="kontak" value="{{ old('kontak') }}" placeholder="Nomor WA pengelola (jika beda dengan Anda)"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Utama <span class="text-red-500">*</span></label>
                <input type="file" name="thumbnail" accept="image/*" required
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
                @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-xs text-amber-700">
                📋 Pengajuan Anda akan direview oleh tim kelurahan sebelum tayang di halaman Wisata publik. Anda akan mendapat kode tiket untuk memantau status verifikasi.
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Ajukan Pendaftaran
            </button>
        </form>
    </div>
</section>
@endsection

{{-- resources/views/admin/hero-banner/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Tambah Banner')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.hero-banner.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul <span class="text-slate-400">(opsional)</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Selamat Datang di Okura"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Sub Judul</label>
            <textarea name="subjudul" rows="2"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('subjudul') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Teks Tombol</label>
                <input type="text" name="tombol_teks" value="{{ old('tombol_teks') }}" placeholder="Contoh: Lihat Wisata"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Link Tombol</label>
                <input type="text" name="tombol_link" value="{{ old('tombol_link') }}" placeholder="/wisata"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner <span class="text-red-500">*</span></label>
            <input type="file" name="gambar" accept="image/*" required
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            <p class="text-xs text-slate-400 mt-1.5">Rasio landscape (16:9) direkomendasikan, minimal 1600x900px.</p>
            @error('gambar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                Tampilkan banner ini
            </label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Simpan</button>
            <a href="{{ route('admin.hero-banner.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

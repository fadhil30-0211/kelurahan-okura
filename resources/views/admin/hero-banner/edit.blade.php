{{-- resources/views/admin/hero-banner/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Banner')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.hero-banner.update', $heroBanner) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $heroBanner->judul) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Sub Judul</label>
            <textarea name="subjudul" rows="2"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('subjudul', $heroBanner->subjudul) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Teks Tombol</label>
                <input type="text" name="tombol_teks" value="{{ old('tombol_teks', $heroBanner->tombol_teks) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Link Tombol</label>
                <input type="text" name="tombol_link" value="{{ old('tombol_link', $heroBanner->tombol_link) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner</label>
            <img src="{{ asset('storage/'.$heroBanner->gambar) }}" class="w-full h-32 rounded-xl object-cover border border-slate-200 mb-2" alt="">
            <input type="file" name="gambar" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            <p class="text-xs text-slate-400 mt-1.5">Kosongkan jika tidak ingin mengganti gambar.</p>
        </div>

        <div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $heroBanner->is_active) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                Tampilkan banner ini
            </label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Perbarui</button>
            <a href="{{ route('admin.hero-banner.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

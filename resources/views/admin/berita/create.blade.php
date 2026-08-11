{{-- resources/views/admin/berita/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Tambah Berita')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="sosial" {{ old('kategori') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                </select>
                @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Sekarang</option>
                </select>
                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Ringkasan <span class="text-slate-400">(opsional, maks. 500 karakter)</span></label>
            <textarea name="ringkasan" rows="2" maxlength="500"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('ringkasan') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
            <textarea name="isi" rows="10" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('isi') }}</textarea>
            @error('isi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-slate-400 mt-1.5">Tip: untuk editor teks yang lebih rapi (bold, list, dsb), bisa tambahkan TinyMCE/Quill nanti.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Thumbnail <span class="text-red-500">*</span></label>
            <input type="file" name="thumbnail" accept="image/*" required
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Simpan Berita
            </button>
            <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

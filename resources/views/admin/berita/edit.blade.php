{{-- resources/views/admin/berita/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Berita')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @foreach (['umum' => 'Umum', 'kegiatan' => 'Kegiatan', 'sosial' => 'Sosial'] as $val => $label)
                        <option value="{{ $val }}" {{ old('kategori', $berita->kategori) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Ringkasan</label>
            <textarea name="ringkasan" rows="2" maxlength="500"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
            <textarea name="isi" rows="10" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('isi', $berita->isi) }}</textarea>
            @error('isi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Thumbnail</label>
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200" alt="">
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti thumbnail.</p>
            </div>
            <input type="file" name="thumbnail" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Perbarui Berita
            </button>
            {{-- Tambahkan di edit.blade.php masing-masing, dekat tombol submit --}}
            <a href="{{ route('admin.gallery.index', ['wisata', $wisata->id]) }}"
            class="px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-600 text-sm font-medium hover:bg-emerald-50">
                📷 Kelola Galeri Foto
            </a>
            <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

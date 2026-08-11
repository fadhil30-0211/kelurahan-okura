{{-- resources/views/admin/galeri/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Tambah Foto Galeri')

@section('content')
<div class="max-w-lg">
    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Foto <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="kegiatan">Kegiatan</option>
                <option value="fasilitas">Fasilitas</option>
                <option value="wisata">Wisata</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Kegiatan <span class="text-slate-400">(opsional)</span></label>
            <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto <span class="text-red-500">*</span></label>
            <input type="file" name="foto" accept="image/*" required
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Simpan</button>
            <a href="{{ route('admin.galeri.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

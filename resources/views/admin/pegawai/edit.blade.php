{{-- resources/views/admin/pegawai/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Pegawai')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.pegawai.update', $pegawai) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pegawai->nama) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('jabatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Jabatan</label>
            <textarea name="deskripsi_jabatan" rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi_jabatan', $pegawai->deskripsi_jabatan) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $pegawai->email) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-end">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $pegawai->urutan) }}" min="0"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="flex items-center gap-2 text-sm text-slate-700 mb-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pegawai->is_active) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    Tampilkan di halaman profil
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto</label>
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ asset('storage/'.$pegawai->foto) }}" class="w-16 h-16 rounded-full object-cover border border-slate-200" alt="">
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <input type="file" name="foto" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Perbarui</button>
            <a href="{{ route('admin.pegawai.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

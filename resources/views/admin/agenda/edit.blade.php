{{-- resources/views/admin/agenda/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Agenda')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Acara <span class="text-red-500">*</span></label>
            <input type="text" name="nama_acara" value="{{ old('nama_acara', $agenda->nama_acara) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('nama_acara') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $agenda->tanggal->format('Y-m-d')) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Waktu</label>
                <input type="text" name="waktu" value="{{ old('waktu', $agenda->waktu) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $agenda->lokasi) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Perbarui</button>
            <a href="{{ route('admin.agenda.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

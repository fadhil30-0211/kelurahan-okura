{{-- resources/views/admin/pengaturan/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="max-w-lg">
    <form action="{{ route('admin.pengaturan.update') }}" method="POST"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Penduduk</label>
            <input type="number" name="jumlah_penduduk" value="{{ old('jumlah_penduduk', $jumlahPenduduk) }}" required min="0"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <p class="text-xs text-slate-400 mt-1.5">Angka ini akan ditampilkan di counter homepage. Update sesuai data terbaru dari kelurahan.</p>
            @error('jumlah_penduduk') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            Simpan Pengaturan
        </button>
    </form>

    <div class="bg-slate-50 rounded-2xl border border-slate-100 p-5 mt-5">
        <p class="text-xs text-slate-500">
            💡 Angka <strong>Destinasi Wisata</strong> dan <strong>UMKM Terdaftar</strong> di homepage dihitung otomatis dari data yang sudah aktif di menu Wisata dan UMKM — tidak perlu diatur manual di sini.
        </p>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Data Anggaran</h1>
            <p class="text-slate-500 text-sm">Ubah informasi pos anggaran yang terdaftar.</p>
        </div>
        <a href="{{ route('admin.anggaran.index', ['tahun' => $anggaran->tahun]) }}"
           class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold rounded-lg transition">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.anggaran.update', $anggaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- Tahun --}}
                <div>
                    <label for="tahun" class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $anggaran->tahun) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                    @error('tahun')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-1">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $anggaran->jumlah) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                    @error('jumlah')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Kategori Pos Anggaran --}}
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori Pos Anggaran</label>
                <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $anggaran->kategori) }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                @error('kategori')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('keterangan', $anggaran->keterangan) }}</textarea>
                @error('keterangan')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.anggaran.index', ['tahun' => $anggaran->tahun]) }}"
                   class="px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

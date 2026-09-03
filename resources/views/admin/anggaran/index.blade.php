{{-- resources/views/admin/anggaran/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Transparansi Anggaran')
@section('page-title', 'Transparansi Anggaran')

@section('content')
<div class="space-y-6">

    {{-- TAB/FILTER TAHUN --}}
    <div class="flex flex-wrap items-center gap-2">
        @foreach ($tahunTersedia as $th)
            <a href="{{ route('admin.anggaran.index', ['tahun' => $th]) }}"
               class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ $tahun == $th ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-200/70 hover:bg-slate-200 text-slate-600' }}">
                {{ $th }}
            </a>
        @endforeach
    </div>

    {{-- GRID UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- KOLOM KIRI: TABEL DAFTAR ANGGARAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="pb-4">Kategori</th>
                            <th class="pb-4">Jumlah</th>
                            <th class="pb-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($anggarans as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 font-medium text-slate-700">
                                    {{ $item->kategori }}
                                </td>
                                <td class="py-4 text-slate-600 font-medium">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-4 text-right">
                                    <form action="{{ route('admin.anggaran.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus data anggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-10 text-center text-slate-400 text-sm">
                                    Belum ada data anggaran tahun {{ $tahun }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM TAMBAH DATA ANGGARAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-5 text-base">Tambah Data Anggaran</h3>

            <form action="{{ route('admin.anggaran.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Input Tahun --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Tahun</label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', $tahun) }}"
                           required
                           min="2000"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                    @error('tahun')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Kategori --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Kategori Pos Anggaran</label>
                    <input type="text"
                           name="kategori"
                           value="{{ old('kategori') }}"
                           required
                           placeholder="Contoh: Pembangunan, Sosial"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Jumlah --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Jumlah (Rp)</label>
                    <input type="number"
                           name="jumlah"
                           value="{{ old('jumlah') }}"
                           required
                           min="0"
                           step="0.01"
                           placeholder="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                    @error('jumlah')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Keterangan --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Keterangan</label>
                    <textarea name="keterangan"
                              rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition duration-200">
                    Tambah
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

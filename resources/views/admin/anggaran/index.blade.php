{{-- resources/views/admin/anggaran/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Transparansi Anggaran')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex gap-2">
            @foreach ($tahunTersedia as $th)
                <a href="{{ route('admin.anggaran.index', ['tahun' => $th]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $tahun == $th ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $th }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Kategori</th>
                        <th class="text-left px-5 py-3 font-medium">Jumlah</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($anggarans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 text-slate-700">{{ $item->kategori }}</td>
                            <td class="px-5 py-3.5 text-slate-700">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <form action="{{ route('admin.anggaran.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus data anggaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-10 text-slate-400 text-sm">Belum ada data anggaran tahun {{ $tahun }}.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-800 mb-4 text-sm">Tambah Data Anggaran</h3>
            <form action="{{ route('admin.anggaran.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun', $tahun) }}" required min="2000"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('tahun') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kategori Pos Anggaran</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" required placeholder="Contoh: Pembangunan, Sosial"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="0" step="0.01"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    @error('jumlah') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="2"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('keterangan') }}</textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                    Tambah
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

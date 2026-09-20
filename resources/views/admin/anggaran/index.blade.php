@extends('layouts.admin')

@section('title', 'Transparansi Anggaran')
@section('page-title', 'Transparansi Anggaran')

@section('content')
<div class="space-y-6">

    {{-- ALERT FLASH MESSAGE --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- HEADER & STATS RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Card Total --}}
        <div class="md:col-span-2 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider">
                        Total Anggaran ({{ $tahun }})
                    </p>
                    <h2 class="text-3xl font-extrabold text-white mt-1.5 drop-shadow-sm">
                        Rp {{ number_format($anggarans->sum('jumlah'), 0, ',', '.') }}
                    </h2>
                </div>
                <div class="p-3 bg-white/15 rounded-xl backdrop-blur-md border border-white/10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs font-medium text-emerald-100 mt-4">
                TOTAL POS ANGGARAN: <span class="font-bold text-white">{{ $anggarans->count() }} Item</span>
            </p>
        </div>

        {{-- Filter Tahun Card --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pilihan Tahun</span>
                <p class="text-sm text-slate-600 mt-1">Pilih untuk memfilter data:</p>
            </div>
            <div class="flex flex-wrap gap-1.5 mt-3">
                @foreach ($tahunTersedia as $th)
                    <a href="{{ route('admin.anggaran.index', ['tahun' => $th]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 {{ $tahun == $th ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        {{ $th }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- KOLOM KIRI: TABEL DAFTAR ANGGARAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Daftar Alokasi Anggaran</h3>
                    <p class="text-xs text-slate-400">Rincian alokasi anggaran untuk periode tahun {{ $tahun }}</p>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-100">
                    {{ $tahun }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/60 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-5">Kategori</th>
                            <th class="py-3 px-5">Jumlah Alokasi</th>
                            <th class="py-3 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($anggarans as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-5">
                                    <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-md bg-emerald-50 text-emerald-700 mb-1">
                                        {{ $item->kategori }}
                                    </span>
                                    @if($item->keterangan)
                                        <p class="text-xs text-slate-400">{{ $item->keterangan }}</p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 font-bold text-slate-700 whitespace-nowrap">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.anggaran.edit', $item) }}"
                                           class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        {{-- Form Hapus --}}
                                        <form action="{{ route('admin.anggaran.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition"
                                                    title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-sm">Belum ada data anggaran untuk tahun {{ $tahun }}.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM TAMBAH DATA ANGGARAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center gap-2 mb-5">
                <div class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Tambah Pos Anggaran</h3>
            </div>

            <form action="{{ route('admin.anggaran.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Input Tahun --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tahun Anggaran</label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', $tahun) }}"
                           required
                           min="2000"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition @error('tahun') border-red-500 @enderror">
                    @error('tahun')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori Pos Anggaran</label>
                    <input type="text"
                           name="kategori"
                           value="{{ old('kategori') }}"
                           required
                           placeholder="Contoh: Pembangunan, Sosial, Kesehatan"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition @error('kategori') border-red-500 @enderror">
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Jumlah (Addon Prefix Rp) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jumlah</label>
                    <div class="flex rounded-xl shadow-sm">
                        <span class="inline-flex items-center px-3.5 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-sm font-semibold">
                            Rp
                        </span>
                        <input type="number"
                               name="jumlah"
                               value="{{ old('jumlah') }}"
                               required
                               min="0"
                               step="1"
                               placeholder="0"
                               class="w-full min-w-0 flex-1 px-3.5 py-2.5 rounded-r-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition @error('jumlah') border-red-500 @enderror">
                    </div>
                    @error('jumlah')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Keterangan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="keterangan"
                              rows="3"
                              placeholder="Rincian singkat penggunaan anggaran..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-md shadow-emerald-600/10 transition duration-200 flex items-center justify-center gap-2">
                    Simpan Data
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

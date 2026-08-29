@extends('layouts.frontend')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">

        <div class="mb-8 border-b border-slate-100 pb-5">
            <h1 class="text-2xl font-bold text-slate-800">Form Laporan Pengaduan</h1>
            <p class="text-slate-500 text-sm mt-1">Sampaikan keluhan, saran, atau laporan masalah infrastruktur dan pelayanan di lingkungan kelurahan.</p>
        </div>

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-[#form-data]" x-data="{ anonim: false }">
            @csrf

            <div class="space-y-6">
                {{-- Opsi Anonim --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                    <input type="checkbox" id="is_anonim" name="is_anonim" value="1" x-model="anonim" class="mt-1 rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                    <label for="is_anonim" class="text-sm text-amber-900 cursor-pointer">
                        <span class="font-semibold block">Kirim sebagai Anonim</span>
                        Nama dan NIK Anda tidak akan ditampilkan di laporan publik demi menjaga privasi.
                    </label>
                </div>

                {{-- Data Pelapor --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="!anonim" x-cloak>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Sesuai KTP" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('nama_pelapor') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" maxlength="16" value="{{ old('nik') }}" placeholder="14710..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('nik') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nomor WhatsApp / HP <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_hp" required value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('no_hp') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kategori Pengaduan <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur & Jalan</option>
                            <option value="Pelayanan" {{ old('kategori') == 'Pelayanan' ? 'selected' : '' }}>Pelayanan Publik</option>
                            <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan & Sampah</option>
                            <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Ketertiban & Keamanan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Detail Laporan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Judul Laporan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" required value="{{ old('judul') }}" placeholder="Contoh: Lampu Jalan Rusak di RT 02" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Jl. Danau Okura dekat Masjid" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Isi Laporan Detail <span class="text-rose-500">*</span></label>
                    <textarea name="isi_laporan" rows="4" required placeholder="Jelaskan kronologi atau rincian masalah..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('isi_laporan') }}</textarea>
                    @error('isi_laporan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Lampiran Foto / Dokumen (Opsional)</label>
                    <input type="file" name="lampiran" accept="image/*,.pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                    @error('lampiran') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 px-6 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm transition shadow-sm">
                        Kirim Laporan Pengaduan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

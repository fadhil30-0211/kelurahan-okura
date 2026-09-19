@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Kelola Profil & Peta Wilayah</h2>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kelurahan</label>
                <input type="text" name="nama_kelurahan" value="{{ old('nama_kelurahan', $profil->nama_kelurahan ?? 'Tebing Tinggi Okura') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $profil->kecamatan ?? 'Rumbai Timur') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kota</label>
                <input type="text" name="kota" value="{{ old('kota', $profil->kota ?? 'Pekanbaru') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Karakter Wilayah</label>
                <input type="text" name="karakter_wilayah" value="{{ old('karakter_wilayah', $profil->karakter_wilayah ?? 'Tepian Sungai') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Visi Utama</label>
            <textarea name="visi" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">{{ old('visi', $profil->visi ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Sub Visi (Opsional)</label>
            <input type="text" name="sub_visi" value="{{ old('sub_visi', $profil->sub_visi ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Misi (Pisahkan tiap poin dengan baris baru)</label>
            <textarea name="misi" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500" placeholder="01. Judul Misi: Deskripsi Misi&#10;02. Judul Misi: Deskripsi Misi">{{ old('misi', is_array($profil->misi ?? null) ? implode("\n", $profil->misi) : ($profil->misi ?? '')) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Sejarah</label>
            <textarea name="deskripsi_sejarah" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">{{ old('deskripsi_sejarah', $profil->deskripsi_sejarah ?? '') }}</textarea>
        </div>

        <hr class="border-slate-100">

        {{-- SETTING PETA WILAYAH --}}
        <h3 class="text-lg font-bold text-slate-800">Pengaturan Peta Wilayah</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Latitude Kantor Lurah</label>
                <input type="text" name="latitude" value="{{ old('latitude', $profil->latitude ?? '0.5712465') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500" placeholder="0.5712465">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Longitude Kantor Lurah</label>
                <input type="text" name="longitude" value="{{ old('longitude', $profil->longitude ?? '101.5388905') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500" placeholder="101.5388905">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload File Batas Wilayah GeoJSON (.geojson / .json)</label>
            <input type="file" name="geojson_file" accept=".geojson,.json" class="w-full px-4 py-2 rounded-xl border border-slate-200">
            @if(!empty($profil->geojson_file))
                <p class="text-xs text-emerald-600 font-medium mt-2">✓ File GeoJSON aktif: {{ $profil->geojson_file }}</p>
            @endif
        </div>

        <button type="submit" class="w-full py-3 bg-[#009B3A] text-white font-bold rounded-xl shadow-md hover:bg-emerald-700 transition duration-200">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection

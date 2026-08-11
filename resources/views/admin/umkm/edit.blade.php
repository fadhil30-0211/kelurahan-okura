{{-- resources/views/admin/umkm/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit UMKM')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.umkm.update', $umkm) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Usaha <span class="text-red-500">*</span></label>
                <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('nama_usaha') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('nama_pemilik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @foreach (['kuliner' => 'Kuliner', 'kerajinan' => 'Kerajinan', 'jasa' => 'Jasa', 'pertanian' => 'Pertanian', 'lainnya' => 'Lainnya'] as $val => $label)
                    <option value="{{ $val }}" {{ old('kategori', $umkm->kategori) == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="deskripsi" rows="4" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
            @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
            <input type="text" name="alamat" value="{{ old('alamat', $umkm->alamat) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi di Peta</label>
            <div id="peta-pilih-lokasi" class="w-full h-64 rounded-xl border border-slate-200 mb-3"></div>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $umkm->latitude) }}" placeholder="Latitude" readonly
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50">
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $umkm->longitude) }}" placeholder="Longitude" readonly
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $umkm->no_hp) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="aktif" {{ old('status', $umkm->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $umkm->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto</label>
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                     class="w-16 h-16 rounded-lg object-cover border border-slate-200" alt="">
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <input type="file" name="foto" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Perbarui</button>
            {{-- Tambahkan di edit.blade.php masing-masing, dekat tombol submit --}}
            <a href="{{ route('admin.gallery.index', ['wisata', $wisata->id]) }}"
            class="px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-600 text-sm font-medium hover:bg-emerald-50">
                📷 Kelola Galeri Foto
            </a>
            <a href="{{ route('admin.umkm.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = {{ $umkm->latitude ?? 0.6183 }};
    const lng = {{ $umkm->longitude ?? 101.5854 }};
    const map = L.map('peta-pilih-lokasi').setView([lat, lng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    let marker = L.marker([lat, lng]).addTo(map);
    map.on('click', function (e) {
        document.getElementById('latitude').value = e.latlng.lat.toFixed(7);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(7);
        map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
    });
</script>
@endpush

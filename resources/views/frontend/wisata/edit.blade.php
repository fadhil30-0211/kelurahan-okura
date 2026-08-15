{{-- resources/views/admin/wisata/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Wisata')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.wisata.update', $wisata) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Wisata <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $wisata->nama) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="deskripsi" rows="4" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi', $wisata->deskripsi) }}</textarea>
            @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
            <input type="text" name="alamat" value="{{ old('alamat', $wisata->alamat) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi di Peta</label>
            <div id="peta-pilih-lokasi" class="w-full h-64 rounded-xl border border-slate-200 mb-3 bg-slate-100"></div>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $wisata->latitude) }}" placeholder="Latitude"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $wisata->longitude) }}" placeholder="Longitude"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Tiket</label>
                <input type="text" name="harga_tiket" value="{{ old('harga_tiket', $wisata->harga_tiket) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jam Operasional</label>
                <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $wisata->jam_operasional) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kontak</label>
                <input type="text" name="kontak" value="{{ old('kontak', $wisata->kontak) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="aktif" {{ old('status', $wisata->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $wisata->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Thumbnail</label>
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                     class="w-16 h-16 rounded-lg object-cover border border-slate-200" alt="">
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti thumbnail.</p>
            </div>
            <input type="file" name="thumbnail" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Perbarui</button>
            <a href="{{ route('admin.gallery.index', ['wisata', $wisata->id]) }}"
               class="px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-600 text-sm font-medium hover:bg-emerald-50">
                📷 Kelola Galeri Foto
            </a>
            <a href="{{ route('admin.wisata.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const initialLat = parseFloat(latInput.value) || 0.6183;
        const initialLng = parseFloat(lngInput.value) || 101.5854;

        const map = L.map('peta-pilih-lokasi').setView([initialLat, initialLng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        setTimeout(() => { map.invalidateSize(); }, 300);

        let marker = L.marker([initialLat, initialLng]).addTo(map);

        map.on('click', function (e) {
            latInput.value = e.latlng.lat.toFixed(7);
            lngInput.value = e.latlng.lng.toFixed(7);
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
        });

        function updateMapFromInput() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                const newLatLng = L.latLng(lat, lng);
                if (marker) map.removeLayer(marker);
                marker = L.marker(newLatLng).addTo(map);
                map.panTo(newLatLng);
            }
        }

        latInput.addEventListener('input', updateMapFromInput);
        lngInput.addEventListener('input', updateMapFromInput);
    });
</script>
@endpush

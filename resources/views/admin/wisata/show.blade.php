@extends('layouts.admin')
@section('page-title', 'Tambah Wisata')

@section('content')
<!-- Import Leaflet CSS langsung di sini agar tidak hilang -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<div class="max-w-2xl mx-auto p-4">
    <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Wisata <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="deskripsi" rows="4" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi di Peta</label>
            <div id="peta-pilih-lokasi" class="w-full h-64 rounded-xl border border-slate-200 mb-3 bg-slate-100"></div>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude (contoh: 0.6183)"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude (contoh: 101.5854)"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <p class="text-xs text-slate-400 mt-1.5">Klik pada peta untuk menandai lokasi atau ketik nilai koordinat secara manual.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Tiket</label>
                <input type="text" name="harga_tiket" value="{{ old('harga_tiket') }}" placeholder="Gratis / Rp 10.000"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jam Operasional</label>
                <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}" placeholder="08.00 - 17.00 WIB"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kontak</label>
            <input type="text" name="kontak" value="{{ old('kontak') }}" placeholder="08xxxxxxxxxx"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Thumbnail <span class="text-red-500">*</span></label>
            <input type="file" name="thumbnail" accept="image/*" required
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Simpan</button>
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

        const map = L.map('peta-pilih-lokasi').setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Fix leaflet container size render
        setTimeout(() => { map.invalidateSize(); }, 300);

        let marker;
        if (latInput.value && lngInput.value) {
            marker = L.marker([initialLat, initialLng]).addTo(map);
        }

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

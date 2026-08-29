@extends('layouts.admin')
@section('page-title', 'Edit UMKM')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
<div class="max-w-2xl space-y-6">
    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Usaha <span class="text-red-500">*</span></label>
            <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            @error('nama_usaha') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('nama_pemilik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none capitalize">
                    @foreach(['kuliner', 'kerajinan', 'jasa', 'pertanian', 'lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', $umkm->kategori) == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                    @endforeach
                </select>
                @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Usaha <span class="text-red-500">*</span></label>
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
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi Usaha di Peta</label>
            <div id="peta-pilih-lokasi" class="w-full h-64 rounded-xl border border-slate-200 mb-3 bg-slate-100"></div>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $umkm->latitude) }}" placeholder="Latitude"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $umkm->longitude) }}" placeholder="Longitude"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $umkm->no_hp) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="aktif" {{ old('status', $umkm->status) == 'aktif' ? 'selected' : '' }}>Aktif / Disetujui</option>
                    <option value="pending" {{ old('status', $umkm->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ditolak" {{ old('status', $umkm->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Utama Produk / Usaha</label>
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                     class="w-16 h-16 rounded-lg object-cover border border-slate-200" alt="">
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti foto utama.</p>
            </div>
            <input type="file" name="foto" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- UPLOAD GALERI FOTO BARU --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tambah Galeri Foto Baru</label>
            <input type="file" name="galleries[]" accept="image/*" multiple
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
            <p class="text-xs text-slate-400 mt-1">Pilih foto tambahan untuk dimasukkan ke dalam galeri UMKM.</p>
            @error('galleries.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">Simpan Perubahan</button>
            <a href="{{ route('admin.umkm.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">Batal</a>
        </div>
    </form>

    {{-- KELOLA DAFTAR GALERI FOTO YANG SUDAH TERUPLOAD --}}
    @if ($umkm->galleries->count())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
            <h3 class="font-semibold text-slate-800 text-sm mb-4">Galeri Foto Terpasang ({{ $umkm->galleries->count() }})</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ($umkm->galleries as $gallery)
                    <div class="relative group rounded-xl overflow-hidden border border-slate-100">
                        <img src="{{ asset('storage/' . $gallery->path) }}" class="w-full h-28 object-cover">
                        <form action="{{ route('admin.umkm.gallery.destroy', $gallery->id) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');"
                              class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg bg-red-600/80 hover:bg-red-600 text-white text-xs backdrop-blur-sm transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const initialLat = parseFloat(latInput.value) || 0.6231;
        const initialLng = parseFloat(lngInput.value) || 101.5889;

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

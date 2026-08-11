{{-- Tambahan khusus di admin/wisata/create.blade.php --}}
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi di Peta</label>
    <div id="peta-pilih-lokasi" class="w-full h-64 rounded-xl border border-slate-200 mb-3"></div>
    <div class="grid grid-cols-2 gap-4">
        <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude" readonly
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50">
        <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude" readonly
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50">
    </div>
    <p class="text-xs text-slate-400 mt-1.5">Klik pada peta untuk menandai lokasi wisata.</p>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('peta-pilih-lokasi').setView([0.6183, 101.5854], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    let marker;
    map.on('click', function (e) {
        document.getElementById('latitude').value = e.latlng.lat.toFixed(7);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(7);
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
    });
</script>
@endpush

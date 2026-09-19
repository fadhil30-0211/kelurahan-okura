@extends('layouts.frontend') {{-- Sesuaikan layout admin Anda --}}

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Kelola Profil & Struktur Organisasi</h1>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Profil Kelurahan --}}
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow mb-8">
        @csrf
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Informasi Profil Kelurahan</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Visi</label>
            <textarea name="visi" class="w-full border rounded p-2 text-sm" rows="3">{{ old('visi', $profil->visi) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Sejarah & Profil Deskripsi</label>
            <textarea name="deskripsi_sejarah" class="w-full border rounded p-2 text-sm" rows="4">{{ old('deskripsi_sejarah', $profil->deskripsi_sejarah) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Latitude</label>
                <input type="text" name="latitude" value="{{ old('latitude', $profil->latitude) }}" class="w-full border rounded p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Longitude</label>
                <input type="text" name="longitude" value="{{ old('longitude', $profil->longitude) }}" class="w-full border rounded p-2 text-sm">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">File GeoJSON (Optional)</label>
            <input type="file" name="geojson_file" class="w-full border rounded p-2 text-sm">
        </div>

        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-sm font-semibold">
            Simpan Perubahan Profil
        </button>
    </form>

    {{-- Form & Tabel Pegawai --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Tambah Struktur Pegawai</h2>
        <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @csrf
            <input type="text" name="nama" placeholder="Nama Pegawai" class="border rounded p-2 text-sm" required>
            <input type="text" name="jabatan" placeholder="Jabatan" class="border rounded p-2 text-sm" required>
            <input type="number" name="urutan" placeholder="Urutan (cth: 1)" class="border rounded p-2 text-sm" required>
            <input type="file" name="foto" class="border rounded p-2 text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold col-span-full md:col-span-1">
                + Tambah Pegawai
            </button>
        </form>

        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="border-b bg-slate-50">
                    <th class="p-2">Foto</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Jabatan</th>
                    <th class="p-2">Urutan</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawais as $p)
                <tr class="border-b">
                    <td class="p-2">
                        <img src="{{ $p->foto ? asset('storage/'.$p->foto) : asset('images/avatar-placeholder.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                    </td>
                    <td class="p-2 font-medium">{{ $p->nama }}</td>
                    <td class="p-2">{{ $p->jabatan }}</td>
                    <td class="p-2">{{ $p->urutan }}</td>
                    <td class="p-2">
                        <form action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pegawai ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-4 text-center text-slate-400">Belum ada data pegawai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

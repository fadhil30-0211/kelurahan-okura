<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profil = Profile::first() ?? new Profile();
        $pegawais = Pegawai::ordered()->get();

        return view('admin.profile.index', compact('profil', 'pegawais'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|array',
            'deskripsi_sejarah' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kota' => 'nullable|string',
            'karakter_wilayah' => 'nullable|string',
            'potensi' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'geojson_file' => 'nullable|file|mimes:json,geojson,txt',
        ]);

        $profil = Profile::first() ?? new Profile();

        if ($request->hasFile('geojson_file')) {
            // Hapus file GeoJSON lama jika ada
            if ($profil->geojson_file && Storage::disk('public')->exists($profil->geojson_file)) {
                Storage::disk('public')->delete($profil->geojson_file);
            }
            // Simpan file GeoJSON baru
            $validated['geojson_file'] = $request->file('geojson_file')->store('geojson', 'public');
        }

        $profil->fill($validated)->save();

        return back()->with('success', 'Data Profil Kelurahan berhasil diperbarui!');
    }

    public function storePegawai(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return back()->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function destroyPegawai($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return back()->with('success', 'Pegawai berhasil dihapus!');
    }
}

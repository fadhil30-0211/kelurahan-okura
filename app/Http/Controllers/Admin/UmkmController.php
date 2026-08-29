<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $umkms = Umkm::when($request->search, fn ($q) => $q->where('nama_usaha', 'like', "%{$request->search}%"))
            ->latest()->paginate(10);

        return view('admin.umkm.index', compact('umkms'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha'    => 'required|string|max:255',
            'nama_pemilik'  => 'required|string|max:255',
            'kategori'      => 'required|in:kuliner,kerajinan,jasa,pertanian,lainnya',
            'deskripsi'     => 'required|string',
            'alamat'        => 'required|string',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'no_hp'         => 'nullable|string|max:20',
            'foto'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'        => 'required|in:aktif,nonaktif',
            'galleries.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm = Umkm::create($validated);

        // PROSES UPLOAD GALERI FOTO (MULTIPLE)
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $index => $file) {
                $path = $file->store('umkm-galleries', 'public');
                $umkm->galleries()->create([
                    'path'   => $path,
                    'urutan' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        // Load relasi galleries agar bisa ditampilkan di form edit
        $umkm->load('galleries');
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_usaha'    => 'required|string|max:255',
            'nama_pemilik'  => 'required|string|max:255',
            'kategori'      => 'required|in:kuliner,kerajinan,jasa,pertanian,lainnya',
            'deskripsi'     => 'required|string',
            'alamat'        => 'required|string',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'no_hp'         => 'nullable|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'        => 'required|in:aktif,nonaktif',
            'galleries.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($umkm->foto) Storage::disk('public')->delete($umkm->foto);
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($validated);

        // PROSES TAMBAH GALERI FOTO BARU
        if ($request->hasFile('galleries')) {
            $lastOrder = $umkm->galleries()->max('urutan') ?? 0;
            foreach ($request->file('galleries') as $index => $file) {
                $path = $file->store('umkm-galleries', 'public');
                $umkm->galleries()->create([
                    'path'   => $path,
                    'urutan' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->foto) Storage::disk('public')->delete($umkm->foto);

        // HAPUS SEMUA FILE GALERI TERKAIT PADA STORAGE & DB
        foreach ($umkm->galleries as $gallery) {
            if ($gallery->path) Storage::disk('public')->delete($gallery->path);
            $gallery->delete();
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    // METHOD KHUSUS UNTUK HAPUS SATU FOTO GALERI DARI EDIT FORM
    public function deleteGallery(Gallery $gallery)
    {
        if ($gallery->path) {
            Storage::disk('public')->delete($gallery->path);
        }
        $gallery->delete();

        return redirect()->back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $galeris = Galeri::when($request->kategori, fn ($q) => $q->where('kategori', $request->kategori))
            ->latest()->paginate(12);

        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'foto'             => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori'         => 'required|in:kegiatan,fasilitas,wisata',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $validated['foto'] = $request->file('foto')->store('galeri', 'public');
        $validated['user_id'] = Auth::id();

        Galeri::create($validated);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete($galeri->foto);
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}

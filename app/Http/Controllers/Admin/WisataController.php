<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $wisatas = Wisata::when($request->search, fn ($q) => $q->where('nama', 'like', "%{$request->search}%"))
            ->latest()->paginate(10);

        return view('admin.wisata.index', compact('wisatas'));
    }

    public function create()
    {
        return view('admin.wisata.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'alamat'           => 'required|string',
            'latitude'         => 'nullable|numeric|between:-90,90',
            'longitude'        => 'nullable|numeric|between:-180,180',
            'thumbnail'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga_tiket'      => 'nullable|string|max:100',
            'jam_operasional'  => 'nullable|string|max:100',
            'kontak'           => 'nullable|string|max:100',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('wisata', 'public');
        }

        Wisata::create($validated);

        return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil ditambahkan.');
    }

    // 1. Method Edit
public function edit(Wisata $wisata) // <--- Pastikan $wisata
{
    return view('admin.wisata.edit', compact('wisata'));
}

// 2. Method Update
public function update(Request $request, Wisata $wisata) // <--- Pastikan $wisata
{
    $validated = $request->validate([
        'nama'             => 'required|string|max:255',
        'deskripsi'        => 'required|string',
        'alamat'           => 'required|string',
        'latitude'         => 'nullable|numeric|between:-90,90',
        'longitude'        => 'nullable|numeric|between:-180,180',
        'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'harga_tiket'      => 'nullable|string|max:100',
        'jam_operasional'  => 'nullable|string|max:100',
        'kontak'           => 'nullable|string|max:100',
        'status'           => 'required|in:aktif,nonaktif',
    ]);

    if ($request->hasFile('thumbnail')) {
        if ($wisata->thumbnail) \Illuminate\Support\Facades\Storage::disk('public')->delete($wisata->thumbnail);
        $validated['thumbnail'] = $request->file('thumbnail')->store('wisata', 'public');
    }

    $wisata->update($validated);

    return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil diperbarui.');
}

// 3. Method Destroy
public function destroy(Wisata $wisata) // <--- Pastikan $wisata
{
    if ($wisata->thumbnail) \Illuminate\Support\Facades\Storage::disk('public')->delete($wisata->thumbnail);
    $wisata->delete();

    return redirect()->route('admin.wisata.index')->with('success', 'Data wisata berhasil dihapus.');
}

// 4. Method Approve
public function approve(Wisata $wisata) // <--- Pastikan $wisata
{
    $wisata->update(['status' => 'aktif']);

    return redirect()->route('admin.wisata.index')
        ->with('success', "Wisata \"{$wisata->nama}\" berhasil disetujui.");
}
}

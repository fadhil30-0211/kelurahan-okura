<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('urutan')->get();
        return view('admin.hero-banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.hero-banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'nullable|string|max:255',
            'subjudul'     => 'nullable|string|max:500',
            'gambar'       => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'tombol_teks'  => 'nullable|string|max:50',
            'tombol_link'  => 'nullable|string|max:255',
            'urutan'       => 'nullable|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $validated['urutan'] ?? (HeroBanner::max('urutan') + 1);
        $validated['gambar'] = $request->file('gambar')->store('hero-banners', 'public');

        HeroBanner::create($validated);

        return redirect()->route('admin.hero-banner.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero-banner.edit', compact('heroBanner'));
    }

    public function update(Request $request, HeroBanner $heroBanner)
    {
        $validated = $request->validate([
            'judul'        => 'nullable|string|max:255',
            'subjudul'     => 'nullable|string|max:500',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'tombol_teks'  => 'nullable|string|max:50',
            'tombol_link'  => 'nullable|string|max:255',
            'urutan'       => 'nullable|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($heroBanner->gambar);
            $validated['gambar'] = $request->file('gambar')->store('hero-banners', 'public');
        }

        $heroBanner->update($validated);

        return redirect()->route('admin.hero-banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(HeroBanner $heroBanner)
    {
        Storage::disk('public')->delete($heroBanner->gambar);
        $heroBanner->delete();

        return redirect()->route('admin.hero-banner.index')->with('success', 'Banner berhasil dihapus.');
    }

    /**
     * Update urutan banner via drag-and-drop (dipanggil lewat AJAX/fetch dari JS).
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            HeroBanner::where('id', $id)->update(['urutan' => $index]);
        }

        return response()->json(['success' => true]);
    }
}

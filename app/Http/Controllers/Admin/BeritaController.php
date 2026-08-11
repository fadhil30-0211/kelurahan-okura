<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    use CompressesImages;

    public function index(Request $request)
    {
        $beritas = Berita::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:50',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status'    => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->storeCompressedImage($request->file('thumbnail'), 'berita');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:50',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status'    => 'required|in:draft,published',
        ]);

        if ($validated['judul'] !== $berita->judul) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        }

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $validated['thumbnail'] = $this->storeCompressedImage($request->file('thumbnail'), 'berita');
        }

        if ($validated['status'] === 'published' && $berita->status !== 'published') {
            $validated['published_at'] = now();
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }
}

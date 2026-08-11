<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Gallery;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    protected function resolveModel(string $type, int $id)
    {
        return match ($type) {
            'wisata' => Wisata::findOrFail($id),
            'umkm' => Umkm::findOrFail($id),
            'berita' => Berita::findOrFail($id),
            default => abort(404),
        };
    }

    public function index(string $type, int $id)
    {
        $item = $this->resolveModel($type, $id);
        $galleries = $item->galleries;

        return view('admin.gallery.index', compact('item', 'galleries', 'type'));
    }

    public function store(Request $request, string $type, int $id)
    {
        $item = $this->resolveModel($type, $id);

        $request->validate([
            'foto'   => 'required|array|max:20',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.max' => 'Maksimal 20 foto sekaligus per upload.',
        ]);

        $urutanAwal = $item->galleries()->max('urutan') + 1;

        foreach ($request->file('foto') as $i => $file) {
            $path = $file->store("galeri/{$type}", 'public');

            $item->galleries()->create([
                'path' => $path,
                'urutan' => $urutanAwal + $i,
            ]);
        }

        return redirect()->route('admin.gallery.index', [$type, $id])
            ->with('success', count($request->file('foto')) . ' foto berhasil ditambahkan ke galeri.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->path);
        $type = class_basename($gallery->galleryable_type);
        $id = $gallery->galleryable_id;
        $gallery->delete();

        return redirect()->route('admin.gallery.index', [strtolower($type), $id])
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}

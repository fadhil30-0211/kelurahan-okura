<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Gallery; // Sesuaikan jika nama model Anda 'Galeri'
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('frontend.berita.index', compact('beritas'));
    }

    public function show(string $slug)
    {
        $berita = Berita::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        if (method_exists($berita, 'incrementViews')) {
            $berita->incrementViews();
        } else {
            $berita->increment('views');
        }

        // Ambil galeri foto berita secara fleksibel & aman
        $galleries = collect();

        if (method_exists($berita, 'galleries')) {
            $galleries = $berita->galleries;
        } elseif (method_exists($berita, 'images')) {
            $galleries = $berita->images;
        } elseif (class_exists(Gallery::class)) {
            $query = Gallery::query();

            if (Schema::hasColumn('galleries', 'berita_id')) {
                $query->where('berita_id', $berita->id);
            } elseif (Schema::hasColumn('galleries', 'imageable_id')) {
                $query->where('imageable_id', $berita->id);
            } elseif (Schema::hasColumn('galleries', 'galleryable_id')) {
                $query->where('galleryable_id', $berita->id);
            } else {
                $query->whereRaw('1 = 0');
            }

            $galleries = $query->get();
        }

        $beritaLainnya = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.berita.show', [
            'berita'         => $berita,
            'galleries'      => $galleries,
            'beritaLainnya'  => $beritaLainnya,
            'seoTitle'       => $berita->judul . ' — Kelurahan Tebing Tinggi Okura',
            'seoDescription' => Str::limit(strip_tags($berita->ringkasan ?? $berita->isi), 160),
            'seoImage'       => asset('storage/' . $berita->thumbnail),
        ]);
    }
}

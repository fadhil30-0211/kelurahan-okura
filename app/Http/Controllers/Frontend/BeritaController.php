<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::published()->latest('published_at')->paginate(9);
        return view('frontend.berita.index', compact('beritas'));
    }

    public function show(string $slug)
{
    $berita = Berita::published()->where('slug', $slug)->firstOrFail();
    $berita->incrementViews();

    $beritaLainnya = Berita::published()->where('id', '!=', $berita->id)->latest('published_at')->take(3)->get();

    return view('frontend.berita.show', [
        'berita' => $berita,
        'beritaLainnya' => $beritaLainnya,
        'seoTitle' => $berita->judul . ' — Kelurahan Tebing Tinggi Okura',
        'seoDescription' => \Illuminate\Support\Str::limit(strip_tags($berita->ringkasan ?? $berita->isi), 160),
        'seoImage' => asset('storage/' . $berita->thumbnail),
    ]);
}
}

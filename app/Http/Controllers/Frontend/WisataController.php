<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wisata;

class WisataController extends Controller
{
    public function index()
    {
        $wisatas = Wisata::active()->latest()->paginate(9);
        return view('frontend.wisata.index', compact('wisatas'));
    }

    public function show(string $slug)
{
    $wisata = Wisata::active()->where('slug', $slug)->firstOrFail();
    $wisataLainnya = Wisata::active()->where('id', '!=', $wisata->id)->latest()->take(3)->get();

    return view('frontend.wisata.show', [
        'wisata' => $wisata,
        'wisataLainnya' => $wisataLainnya,
        'seoTitle' => $wisata->nama . ' — Wisata Okura',
        'seoDescription' => \Illuminate\Support\Str::limit(strip_tags($wisata->deskripsi), 160),
        'seoImage' => $wisata->thumbnail ? asset('storage/' . $wisata->thumbnail) : asset('images/placeholder.jpg'),
    ]);
}
}

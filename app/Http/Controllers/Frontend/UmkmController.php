<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $umkms = Umkm::active()
            ->kategori($request->kategori)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.umkm.index', compact('umkms'));
    }

    public function show($id)
    {
        // Cari data UMKM beserta galeri fotonya
        $umkm = Umkm::with('galleries')->findOrFail($id);

        // --- TAMBAHKAN PENAMBAH VIEWS DENGAN PROTEKSI SESSION ---
        $sessionKey = 'umkm_viewed_' . $umkm->id;
        if (!session()->has($sessionKey)) {
            $umkm->increment('views');
            session()->put($sessionKey, true);
        }

        $umkmLainnya = Umkm::active()
            ->where('id', '!=', $umkm->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.umkm.show', [
            'umkm'           => $umkm,
            'umkmLainnya'    => $umkmLainnya,
            'seoTitle'       => $umkm->nama_usaha . ' — UMKM Okura',
            'seoDescription' => Str::limit(strip_tags($umkm->deskripsi), 160),
            'seoImage'       => $umkm->foto
                                ? Storage::url($umkm->foto)
                                : asset('images/placeholder.jpg'),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $wisatas = collect();
        $umkms = collect();
        $beritas = collect();

        if ($keyword) {
            $wisatas = Wisata::active()
                ->where('nama', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%")
                ->take(6)->get();

            $umkms = Umkm::active()
                ->where('nama_usaha', 'like', "%{$keyword}%")
                ->orWhere('kategori', 'like', "%{$keyword}%")
                ->take(6)->get();

            $beritas = Berita::published()
                ->where('judul', 'like', "%{$keyword}%")
                ->orWhere('isi', 'like', "%{$keyword}%")
                ->take(6)->get();
        }

        $totalResults = $wisatas->count() + $umkms->count() + $beritas->count();

        return view('frontend.search', compact('keyword', 'wisatas', 'umkms', 'beritas', 'totalResults'));
    }
}

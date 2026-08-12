<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $galeris = Galeri::when($request->kategori, fn ($q) => $q->where('kategori', $request->kategori))
            ->latest()
            ->paginate(12);

        return view('frontend.galeri.index', compact('galeris'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;

class SurveiKepuasanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'nullable|string|max:255',
            'rating'           => 'required|integer|min:1|max:5',
            'saran'            => 'nullable|string|max:1000',
            'layanan_terkait'  => 'nullable|in:surat,aduan,wisata,umkm,umum',
        ]);

        SurveiKepuasan::create($validated);

        return back()->with('success', 'Terima kasih atas penilaian Anda! Masukan ini sangat membantu kami meningkatkan pelayanan.');
    }
}

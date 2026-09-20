<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartisipasiController extends Controller
{
    public function index()
    {
        return view('frontend.partisipasi.index');
    }

    public function create()
    {
        return view('frontend.partisipasi.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        // Simpan logika data (misal: ke model Partisipasi)

        return redirect()->back()->with('success', 'Partisipasi Anda berhasil dikirim!');
    }
}

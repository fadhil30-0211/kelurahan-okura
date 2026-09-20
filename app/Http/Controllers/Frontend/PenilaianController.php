<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        // Ambil beberapa ulasan terbaru untuk ditampilkan (opsional)
        $penilaians = Penilaian::latest()->take(5)->get();
        $rataRating = Penilaian::avg('rating');
        $totalUlasan = Penilaian::count();

        return view('frontend.penilaian.index', compact('penilaians', 'rataRating', 'totalUlasan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        Penilaian::create([
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Terima kasih! Penilaian dan ulasan Anda berhasil dikirim.');
    }
}

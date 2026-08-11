<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;

class JanjiTemuController extends Controller
{
    public function create()
    {
        return view('frontend.janji-temu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon'         => 'required|string|max:255',
            'no_hp'                => 'required|string|max:20',
            'keperluan'            => 'required|string|min:10',
            'tanggal_diinginkan'   => 'required|date|after_or_equal:today',
            'waktu_diinginkan'     => 'nullable|string|max:50',
        ]);

        $validated['kode_tiket'] = JanjiTemu::generateKodeTiket();
        $validated['status'] = 'menunggu';

        $janjiTemu = JanjiTemu::create($validated);

        return redirect()->route('resi.show', $janjiTemu->kode_tiket);
    }
}

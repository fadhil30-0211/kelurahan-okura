<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function createWisata()
    {
        return view('frontend.pendaftaran.wisata');
    }

    public function storeWisata(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string|min:20',
            'alamat'        => 'required|string',
            'harga_tiket'   => 'nullable|string|max:100',
            'jam_operasional' => 'nullable|string|max:100',
            'kontak'        => 'nullable|string|max:100',
            'thumbnail'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama_pengaju'  => 'required|string|max:255',
            'no_hp_pengaju' => 'required|string|max:20',
        ]);

        $validated['kode_tiket'] = Wisata::generateKodeTiket();
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        $validated['sumber'] = 'warga';
        $validated['status'] = 'pending';
        $validated['thumbnail'] = $request->file('thumbnail')->store('wisata', 'public');

        $wisata = Wisata::create($validated);

        return redirect()->route('resi.show', $wisata->kode_tiket);
    }

    public function createUmkm()
    {
        return view('frontend.pendaftaran.umkm');
    }

    public function storeUmkm(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha'    => 'required|string|max:255',
            'nama_pemilik'  => 'required|string|max:255',
            'kategori'      => 'required|in:kuliner,kerajinan,jasa,pertanian,lainnya',
            'deskripsi'     => 'required|string|min:20',
            'alamat'        => 'required|string',
            'no_hp'         => 'nullable|string|max:20',
            'foto'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama_pengaju'  => 'required|string|max:255',
            'no_hp_pengaju' => 'required|string|max:20',
        ]);

        $validated['kode_tiket'] = Umkm::generateKodeTiket();
        $validated['sumber'] = 'warga';
        $validated['status'] = 'pending';
        $validated['foto'] = $request->file('foto')->store('umkm', 'public');

        $umkm = Umkm::create($validated);

        return redirect()->route('resi.show', $umkm->kode_tiket);
    }
}

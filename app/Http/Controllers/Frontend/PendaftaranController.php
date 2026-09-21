<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PartisipasiUmkm;
use App\Models\PartisipasiWisata;
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
            'nama_pengaju' => 'required|string|max:255',
            'nama_wisata'  => 'required|string|max:255',
            'lokasi'       => 'required|string',
            'deskripsi'    => 'required|string|min:20',
            'no_hp'        => 'required|string|max:20',
            'foto'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['status'] = 'pending';

        // Generate kode tiket untuk Wisata
        $kodeTiket = PartisipasiWisata::generateKodeTiket();
        $validated['kode_tiket'] = $kodeTiket;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        PartisipasiWisata::create($validated);

        return redirect()->back()->with([
            'success'    => 'Pengajuan wisata berhasil dikirim!',
            'kode_tiket' => $kodeTiket
        ]);
    }

    public function createUmkm()
    {
        return view('frontend.pendaftaran.umkm');
    }

    public function storeUmkm(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nama_usaha'   => 'required|string|max:255',
            'kategori'     => 'required|in:kuliner,kerajinan,jasa,pertanian,lainnya',
            'deskripsi'    => 'required|string|min:20',
            'alamat'       => 'required|string',
            'no_hp'        => 'nullable|string|max:20',
            'foto'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Generate kode tiket
        $kodeTiket = PartisipasiUmkm::generateKodeTiket();

        // Mapping dari nama input form ke nama kolom database
        $data = [
            'nama_pemilik' => $request->nama_pemilik,
            'nama_umkm'    => $request->nama_usaha, // memetakan nama_usaha -> nama_umkm
            'kategori'     => $request->kategori,
            'deskripsi'    => $request->deskripsi,
            'alamat'       => $request->alamat,
            'no_hp'        => $request->no_hp ?? $request->no_hp_pengaju,
            'status'       => 'pending',
            'kode_tiket'   => $kodeTiket,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        PartisipasiUmkm::create($data);

        return redirect()->back()->with([
            'success'    => 'Pengajuan UMKM berhasil dikirim!',
            'kode_tiket' => $kodeTiket
        ]);
    }
}

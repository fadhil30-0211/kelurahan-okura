<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan; // Sesuaikan dengan nama Model Pengaduan kamu
use App\Models\PartisipasiUmkm;    // Sesuaikan dengan nama Model Wisata kamu
use App\Models\PartisipasiWisata;      // Sesuaikan dengan nama Model UMKM kamu

class TrackingController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ], [
            'kode_tiket.required' => 'Masukkan kode tiket pengaduan atau pendaftaran Anda.',
        ]);

        $kode = strtoupper(trim($request->kode_tiket));

        $result = null;
        $type = null;

        // 1. Cek Berdasarkan Prefix Kode Tiket
        if (str_starts_with($kode, 'ADU-')) {
            $result = Pengaduan::where('kode_tiket', $kode)->first();
            $type = 'pengaduan';
        } elseif (str_starts_with($kode, 'WIS-')) {
            $result = Wisata::where('kode_tiket', $kode)->first();
            $type = 'wisata';
        } elseif (str_starts_with($kode, 'UMK-')) {
            $result = Umkm::where('kode_tiket', $kode)->first();
            $type = 'umkm';
        } else {
            // 2. Fallback jika user tidak mengetikkan prefix
            $result = Pengaduan::where('kode_tiket', $kode)->first();
            if ($result) {
                $type = 'pengaduan';
            } else {
                $result = Wisata::where('kode_tiket', $kode)->first();
                if ($result) {
                    $type = 'wisata';
                } else {
                    $result = Umkm::where('kode_tiket', $kode)->first();
                    if ($result) {
                        $type = 'umkm';
                    }
                }
            }
        }

        if (!$result) {
            return back()->withErrors([
                'kode_tiket' => "Kode tiket '{$kode}' tidak ditemukan."
            ])->withInput();
        }

        // Arahkan ke view hasil tracking
        return view('frontend.tracking-detail', [
            'data' => $result,
            'type' => $type
        ]);
    }
}

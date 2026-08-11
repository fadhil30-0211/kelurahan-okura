<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class UniversalTrackingController extends Controller
{
    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        $kodeTiket = strtoupper(trim($request->kode_tiket));
        $prefix = substr($kodeTiket, 0, 3);

        $ditemukan = match (true) {
        $prefix === 'ADU' => Pengaduan::where('kode_tiket', $kodeTiket)->exists(),
        $prefix === 'JTM' => JanjiTemu::where('kode_tiket', $kodeTiket)->exists(),
        $prefix === 'WIS' => \App\Models\Wisata::where('kode_tiket', $kodeTiket)->exists(),
        $prefix === 'UMK' => \App\Models\Umkm::where('kode_tiket', $kodeTiket)->exists(),
        in_array($prefix, ['SKT', 'SKU', 'DOM', 'LHR', 'SRT']) =>
            LayananSurat::where('kode_tiket', $kodeTiket)->exists(),
        default => false,
    };

        if (! $ditemukan) {
            return back()
                ->withInput()
                ->withErrors(['kode_tiket' => 'Kode tiket tidak ditemukan. Periksa kembali penulisan kode Anda.']);
        }

        // Resi page kita sudah universal dan otomatis deteksi jenis tiket dari prefix,
        // jadi tinggal redirect ke situ — tidak perlu view lacak terpisah lagi.
        return redirect()->route('resi.show', $kodeTiket);
    }
}

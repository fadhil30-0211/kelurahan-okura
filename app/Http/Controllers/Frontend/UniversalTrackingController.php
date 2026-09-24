<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\LayananSurat;
use App\Models\PartisipasiUmkm;
use App\Models\PartisipasiWisata;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class UniversalTrackingController extends Controller
{
    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ], [
            'kode_tiket.required' => 'Masukkan kode tiket Anda.',
        ]);

        $kodeTiket = strtoupper(trim($request->kode_tiket));

        // 1. Deteksi cepat berdasarkan prefix awal kode tiket
        $ditemukan = match (true) {
            // Pengaduan (misal: ADU-XXXX)
            str_starts_with($kodeTiket, 'ADU') => Pengaduan::where('kode_tiket', $kodeTiket)->exists(),

            // Janji Temu (misal: JTM-XXXX)
            str_starts_with($kodeTiket, 'JTM') => JanjiTemu::where('kode_tiket', $kodeTiket)->exists(),

            // Partisipasi Wisata (WST-EE2786 atau WIS-XXXX)
            str_starts_with($kodeTiket, 'WST') || str_starts_with($kodeTiket, 'WIS')
                => PartisipasiWisata::where('kode_tiket', $kodeTiket)->exists(),

            // Partisipasi UMKM (UMKM-04C689 atau UMK-XXXX)
            str_starts_with($kodeTiket, 'UMKM') || str_starts_with($kodeTiket, 'UMK')
                => PartisipasiUmkm::where('kode_tiket', $kodeTiket)->exists(),

            // Layanan Surat (SKT, SKU, DOM, LHR, NKH, AHW, SKC, SRT, dsb)
            $this->isSuratPrefix($kodeTiket) => LayananSurat::where('kode_tiket', $kodeTiket)->exists(),

            default => false,
        };

        // 2. Fallback Safety: Jika prefix tidak standar/berbeda, cari secara menyeluruh
        if (! $ditemukan) {
            $ditemukan = Pengaduan::where('kode_tiket', $kodeTiket)->exists()
                || JanjiTemu::where('kode_tiket', $kodeTiket)->exists()
                || PartisipasiWisata::where('kode_tiket', $kodeTiket)->exists()
                || PartisipasiUmkm::where('kode_tiket', $kodeTiket)->exists()
                || LayananSurat::where('kode_tiket', $kodeTiket)->exists();
        }

        // 3. Jika tiket tidak ditemukan di semua tabel
        if (! $ditemukan) {
            return back()
                ->withInput()
                ->withErrors(['kode_tiket' => "Kode tiket '{$kodeTiket}' tidak ditemukan. Mohon periksa kembali kode Anda."]);
        }

        // 4. Jika ditemukan, arahkan ke halaman resi universal
        return redirect()->route('resi.show', $kodeTiket);
    }

    /**
     * Helper untuk mengecek prefix layanan surat
     */
    private function isSuratPrefix(string $kode): bool
    {
        $prefixSurat = ['SKT-', 'SKU-', 'DOM-', 'LHR-', 'NKH-', 'AHW-', 'SKC-', 'SRT-'];
        foreach ($prefixSurat as $prefix) {
            if (str_starts_with($kode, $prefix)) {
                return true;
            }
        }
        return false;
    }
}

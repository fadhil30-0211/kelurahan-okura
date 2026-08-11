<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ResiController extends Controller
{
    /**
     * Deteksi jenis tiket dari prefix kode, lalu ambil datanya.
     * Return null kalau tidak ketemu di semua tabel.
     */
    protected function resolveTiket(string $kodeTiket): ?array
    {
        $prefix = strtoupper(substr($kodeTiket, 0, 3));

        return match (true) {
            $prefix === 'ADU' => $this->wrap('pengaduan', \App\Models\Pengaduan::where('kode_tiket', $kodeTiket)->first()),
            $prefix === 'JTM' => $this->wrap('janji_temu', \App\Models\JanjiTemu::where('kode_tiket', $kodeTiket)->first()),
            $prefix === 'WIS' => $this->wrap('wisata', \App\Models\Wisata::where('kode_tiket', $kodeTiket)->first()),
            $prefix === 'UMK' => $this->wrap('umkm', \App\Models\Umkm::where('kode_tiket', $kodeTiket)->first()),
            in_array($prefix, ['SKT', 'SKU', 'DOM', 'LHR', 'SRT']) =>
                $this->wrap('layanan_surat', \App\Models\LayananSurat::where('kode_tiket', $kodeTiket)->first()),
            default => null,
        };
    }

    protected function wrap(string $jenis, $data): ?array
    {
        return $data ? ['jenis' => $jenis, 'data' => $data] : null;
    }

    public function show(string $kodeTiket)
    {
        $tiket = $this->resolveTiket($kodeTiket);

        if (! $tiket) {
            abort(404, 'Kode tiket tidak ditemukan.');
        }

        $trackingUrl = route('resi.show', $kodeTiket);
        $qrCode = QrCode::size(200)->generate($trackingUrl);

        return view('frontend.resi.show', [
            'jenis' => $tiket['jenis'],
            'item' => $tiket['data'],
            'qrCode' => $qrCode,
            'trackingUrl' => $trackingUrl,
        ]);
    }

    public function download(string $kodeTiket)
    {
        $tiket = $this->resolveTiket($kodeTiket);

        if (! $tiket) {
            abort(404, 'Kode tiket tidak ditemukan.');
        }

        $trackingUrl = route('resi.show', $kodeTiket);
        $qrCodeBase64 = base64_encode(QrCode::size(180)->generate($trackingUrl));

        $pdf = Pdf::loadView('frontend.resi.pdf', [
            'jenis' => $tiket['jenis'],
            'item' => $tiket['data'],
            'qrCodeBase64' => $qrCodeBase64,
        ])->setPaper([0, 0, 400, 600]); // ukuran resi memanjang seperti struk

        return $pdf->download("resi-{$kodeTiket}.pdf");
    }
}

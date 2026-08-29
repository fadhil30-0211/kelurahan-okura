<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\LayananSurat;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function lacak(Request $request)
    {
        $pengajuan = null;

        if ($request->filled('kode_tiket')) {
            $kode = trim($request->kode_tiket);

            // 1. Cari di tabel Pengaduan
            $pengajuan = Pengaduan::where('kode_tiket', $kode)
                ->orWhere('kode_tiket', strtoupper($kode))
                ->first();

            // 2. Jika tidak ada di Pengaduan, cari di Layanan Surat
            if (!$pengajuan && class_exists(LayananSurat::class)) {
                $pengajuan = LayananSurat::where('kode_tiket', $kode)
                    ->orWhere('kode_tiket', strtoupper($kode))
                    ->first();
            }

            if (!$pengajuan) {
                session()->now('error', 'Kode tiket "' . $kode . '" tidak ditemukan. Silakan periksa kembali.');
            }
        }

        return view('frontend.pengajuan.lacak', compact('pengajuan'));
    }
}

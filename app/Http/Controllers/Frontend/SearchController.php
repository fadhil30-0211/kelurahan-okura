<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LayananSurat;
use App\Models\Pengumuman;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('q'));

        $wisatas = collect();
        $umkms = collect();
        $beritas = collect();
        $layananSurats = collect();
        $pengumumans = collect();

        if ($keyword !== '') {
            $lowerKey = strtolower($keyword);

            // 1. Master Data 4 Layanan Surat Sesuai Halaman Frontend /layanan
            $masterLayanan = [
                [
                    'id' => 1,
                    'jenis_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
                    'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
                    'persyaratan' => 'KTP, KK, Surat Pengantar RT/RW',
                    'keperluan' => 'Permohonan Bantuan / Beasiswa / Keringanan Biaya',
                    'keywords' => ['sktm', 'tidak mampu', 'kurang mampu', 'beasiswa', 'bantuan', 'miskin']
                ],
                [
                    'id' => 2,
                    'jenis_surat' => 'Surat Keterangan Usaha (SKU)',
                    'nama_surat' => 'Surat Keterangan Usaha (SKU)',
                    'persyaratan' => 'KTP, KK, Foto Usaha',
                    'keperluan' => 'Persyaratan Izin Usaha / Pengajuan Kredit UMKM',
                    'keywords' => ['sku', 'usaha', 'keterangan usaha', 'izin usaha', 'foto usaha', 'dagang']
                ],
                [
                    'id' => 3,
                    'jenis_surat' => 'Surat Keterangan Domisili',
                    'nama_surat' => 'Surat Keterangan Domisili',
                    'persyaratan' => 'KTP, KK',
                    'keperluan' => 'Surat Keterangan Tempat Tinggal / Domisili',
                    'keywords' => ['skd', 'domisili', 'tempat tinggal', 'alamat', 'pindah']
                ],
                [
                    'id' => 4,
                    'jenis_surat' => 'Surat Pengantar Kelahiran',
                    'nama_surat' => 'Surat Pengantar Kelahiran',
                    'persyaratan' => 'KK, Surat Keterangan Lahir dari Bidan/RS',
                    'keperluan' => 'Pengurusan Akta Kelahiran Anak',
                    'keywords' => ['kelahiran', 'lahir', 'akta', 'bayi', 'bidan', 'rs']
                ],
            ];

            // 2. Filter Master Layanan berdasarkan Pencarian
            $matchedLayanan = collect();

            if (in_array($lowerKey, ['layanan', 'surat', 'layanan surat', 'persyaratan', 'pengajuan'])) {
                $matchedLayanan = collect($masterLayanan)->map(fn($item) => (object) $item);
            } else {
                foreach ($masterLayanan as $item) {
                    $isMatch = false;
                    if (str_contains(strtolower($item['jenis_surat']), $lowerKey) || str_contains(strtolower($item['persyaratan']), $lowerKey)) {
                        $isMatch = true;
                    } else {
                        foreach ($item['keywords'] as $kw) {
                            if (str_contains($kw, $lowerKey) || str_contains($lowerKey, $kw)) {
                                $isMatch = true;
                                break;
                            }
                        }
                    }

                    if ($isMatch) {
                        $matchedLayanan->push((object) $item);
                    }
                }
            }

            // 3. Cari juga data riwayat pengajuan di Database (jika ada)
            $dbLayanan = collect();
            if (Schema::hasTable('layanan_surats')) {
                $dbLayanan = LayananSurat::where(function ($q) use ($lowerKey) {
                    $q->orWhere('jenis_surat', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('keperluan', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('nama_pemohon', 'LIKE', '%' . $lowerKey . '%');
                })->take(5)->get();
            }

            $layananSurats = $matchedLayanan->merge($dbLayanan)->unique('jenis_surat');

            // 4. Pencarian Kategori Lain (UMKM, Wisata, Berita, Pengumuman)
            if (in_array($lowerKey, ['umkm', 'usaha', 'dagang', 'kuliner', 'jasa'])) {
                $umkms = Umkm::take(10)->get();
            } elseif (Schema::hasTable('umkms')) {
                $umkms = Umkm::where(function ($q) use ($lowerKey) {
                    $q->orWhere('nama_usaha', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('kategori', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('nama_pemilik', 'LIKE', '%' . $lowerKey . '%');
                })->take(10)->get();
            }

            if (in_array($lowerKey, ['wisata', 'destinasi', 'tempat wisata'])) {
                $wisatas = Wisata::take(10)->get();
            } elseif (Schema::hasTable('wisatas')) {
                $wisatas = Wisata::where(function ($q) use ($lowerKey) {
                    $q->orWhere('nama', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $lowerKey . '%');
                })->take(10)->get();
            }

            if (in_array($lowerKey, ['berita', 'kabar', 'artikel'])) {
                $beritas = Berita::take(10)->get();
            } elseif (Schema::hasTable('beritas')) {
                $beritas = Berita::where(function ($q) use ($lowerKey) {
                    $q->orWhere('judul', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('isi', 'LIKE', '%' . $lowerKey . '%');
                })->take(10)->get();
            }

            if (in_array($lowerKey, ['pengumuman', 'info', 'informasi'])) {
                $pengumumans = Pengumuman::take(10)->get();
            } elseif (Schema::hasTable('pengumumans')) {
                $pengumumans = Pengumuman::where(function ($q) use ($lowerKey) {
                    $q->orWhere('judul', 'LIKE', '%' . $lowerKey . '%')
                      ->orWhere('isi', 'LIKE', '%' . $lowerKey . '%');
                })->take(10)->get();
            }
        }

        $totalResults = $wisatas->count() + $umkms->count() + $beritas->count() + $layananSurats->count() + $pengumumans->count();

        return view('frontend.search', compact(
            'keyword',
            'wisatas',
            'umkms',
            'beritas',
            'layananSurats',
            'pengumumans',
            'totalResults'
        ));
    }
}

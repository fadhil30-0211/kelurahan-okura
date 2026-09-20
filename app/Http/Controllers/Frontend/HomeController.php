<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\HeroBanner;
use App\Models\Pegawai;
use App\Models\Pengumuman;
use App\Models\Setting;
use App\Models\Umkm;
use App\Models\Wisata;
use App\Models\PageView;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) // <--- UBAH DI SINI (Tambahkan Request $request)
    {
        PageView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $banners = HeroBanner::active()->ordered()->get();
        $wisatas = Wisata::active()->latest()->take(6)->get();
        $umkms = Umkm::active()->latest()->take(8)->get();
        $anggaranTahunIni = Anggaran::tahun(now()->year)->get();
        $pengumumanTerbaru = Pengumuman::active()->latest()->take(3)->get();

        // Mengambil data setting
        $siteSetting = Setting::first();
        $settings = $siteSetting;

        // Data counter
        $jumlahPenduduk = $siteSetting->jumlah_penduduk ?? 0;
        $jumlahWisata = Wisata::active()->count();
        $jumlahUmkm = Umkm::active()->count();

        return view('frontend.index', compact(
            'banners',
            'wisatas',
            'umkms',
            'anggaranTahunIni',
            'pengumumanTerbaru',
            'jumlahPenduduk',
            'jumlahWisata',
            'jumlahUmkm',
            'siteSetting',
            'settings'
        ));
    }

    public function profil()
    {
        $pegawais = Pegawai::active()->ordered()->get();
        $agendas = Agenda::upcoming()->take(5)->get();

        $siteSetting = Setting::first();

        return view('frontend.profil', compact('pegawais', 'agendas', 'siteSetting'));
    }
}

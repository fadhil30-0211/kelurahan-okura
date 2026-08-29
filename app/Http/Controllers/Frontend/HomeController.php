<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\HeroBanner;
use App\Models\Pegawai;
use App\Models\Pengumuman;
use App\Models\Setting; // Disamakan menggunakan Setting (atau sesuaikan jika nama modelmu SiteSetting)
use App\Models\Umkm;
use App\Models\Wisata;

class HomeController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::active()->ordered()->get();
        $wisatas = Wisata::active()->latest()->take(6)->get();
        $umkms = Umkm::active()->latest()->take(8)->get();
        $anggaranTahunIni = Anggaran::tahun(now()->year)->get();
        $pengumumanTerbaru = Pengumuman::active()->latest()->take(3)->get();

        // Mengambil data setting
        $siteSetting = Setting::first();
        $settings = $siteSetting; // Alias agar Blade $settings tidak error!

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
            'settings' // Ditambahkan ke compact
        ));
    }

    public function profil()
    {
        $pegawais = Pegawai::active()->ordered()->get();
        $agendas = Agenda::upcoming()->take(5)->get();

        // Ambil data setting untuk halaman profil
        $siteSetting = Setting::first();

        return view('frontend.profil', compact('pegawais', 'agendas', 'siteSetting'));
    }
}

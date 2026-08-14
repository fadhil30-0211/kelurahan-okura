<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\Berita;
use App\Models\Pegawai;
use App\Models\Umkm;
use App\Models\Wisata;
use App\Models\HeroBanner;          // Ditambahkan
use App\Models\EmergencyContact;    // Ditambahkan
use App\Models\Pengumuman;          // Ditambahkan

class HomeController extends Controller
{
        public function index()
    {
        $banners = \App\Models\HeroBanner::active()->ordered()->get();
        $wisatas = Wisata::active()->latest()->take(6)->get();
        $umkms = Umkm::active()->latest()->take(8)->get();
        $anggaranTahunIni = Anggaran::tahun(now()->year)->get();
        $pengumumanTerbaru = \App\Models\Pengumuman::active()->latest()->take(3)->get();

        // Data counter — sungguhan, bukan hardcode
        $jumlahPenduduk = \App\Models\SiteSetting::get('jumlah_penduduk', 0);
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
            'jumlahUmkm'
        ));
    }

    public function profil()
    {
        $pegawais = Pegawai::active()->ordered()->get();
        $agendas = Agenda::upcoming()->take(5)->get();

        return view('frontend.profil', compact('pegawais', 'agendas'));
    }
}

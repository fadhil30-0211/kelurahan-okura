<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\Berita;
use App\Models\Pegawai;
use App\Models\Umkm;
use App\Models\Wisata;

class HomeController extends Controller
{
    // app/Http/Controllers/Frontend/HomeController.php — update method index()
    public function index()
    {
        $banners = \App\Models\HeroBanner::active()->ordered()->get();
        $wisatas = Wisata::active()->latest()->take(6)->get();
        $umkms = Umkm::active()->latest()->take(8)->get();
        $anggaranTahunIni = Anggaran::tahun(now()->year)->get();
        $emergencyContacts = \App\Models\EmergencyContact::active()->get();
        $pengumumanDarurat = \App\Models\Pengumuman::active()->where('kategori', 'darurat')->latest()->first();

        return view('frontend.index', compact('banners', 'wisatas', 'umkms', 'anggaranTahunIni', 'emergencyContacts', 'pengumumanDarurat'));
    }

    public function profil()
    {
        $pegawais = Pegawai::active()->ordered()->get();
        $agendas = Agenda::upcoming()->take(5)->get();

        return view('frontend.profil', compact('pegawais', 'agendas'));
    }
}

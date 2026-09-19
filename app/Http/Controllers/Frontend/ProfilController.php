<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Pegawai; // Sesuaikan jika nama model pegawai/pemerintahan Anda berbeda

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil data profil pertama (atau buat record kosong jika belum ada data di DB)
        $profil = Profile::first() ?? new Profile();

        // Ambil data struktur organisasi / pegawai
        $pegawais = Pegawai::all(); // Sesuaikan query/ordering sesuai kebutuhan Anda

        return view('frontend.profil', compact('profil', 'pegawais'));
    }
}

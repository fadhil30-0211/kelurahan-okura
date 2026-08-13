<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function create()
    {
        return view('frontend.pengaduan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'nik'          => 'nullable|string|max:20',
            'no_hp'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'kategori'     => 'required|in:infrastruktur,sosial,keamanan,lingkungan,lainnya',
            'judul_aduan'  => 'required|string|max:255',
            'isi_aduan'    => 'required|string|min:20',
            'lampiran'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'isi_aduan.min' => 'Mohon jelaskan aduan Anda minimal 20 karakter agar mudah dipahami petugas.',
        ]);

        $validated['kode_tiket'] = Pengaduan::generateKodeTiket();
        $validated['status'] = 'diterima';

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create($validated);

        // BAGIAN YANG DIPERBAIKI: Menghapus perantaian ganda ->route()
        return redirect()
            ->route('resi.show', $pengaduan->kode_tiket)
            ->with('success', "Pengaduan berhasil dikirim! Kode tiket Anda: {$pengaduan->kode_tiket}. Simpan kode ini untuk melacak status.")
            ->with('kode_tiket', $pengaduan->kode_tiket);
    }

    public function trackForm()
    {
        return redirect()->route('home')->with('info', 'Gunakan kolom "Lacak Pengajuan" di halaman utama untuk melacak status.');
    }

    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
            'no_hp'      => 'required|string',
        ]);

        $pengaduan = Pengaduan::where('kode_tiket', $request->kode_tiket)
            ->where('no_hp', $request->no_hp)
            ->first();

        if (! $pengaduan) {
            return back()
                ->withInput()
                ->withErrors(['kode_tiket' => 'Kode tiket atau nomor HP tidak ditemukan. Periksa kembali data Anda.']);
        }

        return view('frontend.pengaduan.track-result', compact('pengaduan'));
    }
}

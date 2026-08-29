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
            'is_anonim'    => 'nullable|boolean',
            'nama_pelapor' => 'required_unless:is_anonim,1|nullable|string|max:255',
            'nik'          => 'nullable|string|max:20',
            'no_hp'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'kategori'     => 'required|in:infrastruktur,sosial,keamanan,lingkungan,lainnya',
            'judul_aduan'  => 'required|string|max:255',
            'isi_aduan'    => 'required|string|min:20',
            'lampiran'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_pelapor.required_unless' => 'Nama pelapor wajib diisi jika tidak memilih opsi anonim.',
            'isi_aduan.min'                => 'Mohon jelaskan aduan Anda minimal 20 karakter agar mudah dipahami petugas.',
        ]);

        // Tangani logika Anonim
        $isAnonim = $request->boolean('is_anonim');
        $validated['is_anonim'] = $isAnonim;

        if ($isAnonim) {
            $validated['nama_pelapor'] = 'Anonim';
        }

        $validated['kode_tiket'] = Pengaduan::generateKodeTiket();
        $validated['status']     = 'diterima';

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create($validated);

        return redirect()
            ->route('resi.show', $pengaduan->kode_tiket)
            ->with('success', "Pengaduan berhasil dikirim! Kode tiket Anda: {$pengaduan->kode_tiket}. Simpan kode ini untuk melacak status.")
            ->with('kode_tiket', $pengaduan->kode_tiket);
    }

    // Method Lacak Pengaduan (Menampilkan Form & Hasil Pencarian)
    public function lacak(Request $request)
{
    $pengaduan = null;

    if ($request->filled('kode_tiket')) {
        $kode = trim($request->kode_tiket);

        $query = Pengaduan::where('kode_tiket', $kode)
            ->orWhere('kode_tiket', strtoupper($kode))
            ->orWhere('kode_tiket', strtolower($kode));

        if ($request->filled('no_hp')) {
            $query->where('no_hp', $request->no_hp);
        }

        $pengaduan = $query->first();

        if (!$pengaduan) {
            session()->now('error', 'Kode tiket "' . $kode . '" tidak ditemukan. Periksa kembali kode Anda.');
        }
    }

    return view('frontend.pengaduan.lacak', compact('pengaduan'));
}

    public function trackForm()
    {
        return redirect()->route('pengaduan.lacak');
    }

    public function track(Request $request)
    {
        return $this->lacak($request);
    }
}

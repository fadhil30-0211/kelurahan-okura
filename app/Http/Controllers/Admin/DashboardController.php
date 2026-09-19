<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\JanjiTemu; // <-- Tambahkan Model JanjiTemu
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use App\Models\SiteSetting;
use App\Models\Umkm;
use App\Models\Wisata;
use App\Models\Profile;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'pengaduan_masuk'   => Pengaduan::where('status', 'diterima')->count(),
            'pengaduan_proses'  => Pengaduan::where('status', 'diproses')->count(),
            'surat_diajukan'    => LayananSurat::where('status', 'diajukan')->count(),
            'surat_proses'      => LayananSurat::where('status', 'diproses')->count(),
            'total_berita'      => Berita::count(),
            'berita_published'  => Berita::where('status', 'published')->count(),
            'total_wisata'      => Wisata::where('status', 'aktif')->count(),
            'total_umkm'        => Umkm::where('status', 'aktif')->count(),
        ];

        // Grafik aduan masuk 7 hari terakhir
        $aduanChart = Pengaduan::query()
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->translatedFormat('d M');
            $chartData[] = $aduanChart[$date]->total ?? 0;
        }

        // Distribusi kategori aduan (untuk pie chart)
        $kategoriAduan = Pengaduan::query()
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $pengaduanTerbaru = Pengaduan::latest()->take(5)->get();
        $suratTerbaru     = LayananSurat::latest()->take(5)->get();

        // Data Janji Temu Terbaru
        $janjiTemuTerbaru = JanjiTemu::latest()->take(5)->get();

        // Data Profil Kelurahan & Pegawai untuk ditampilkan di Dashboard
        $profil   = Profile::first() ?? new Profile();
        $pegawais = Pegawai::ordered()->get();

        return view('admin.dashboard', compact(
            'summary',
            'chartLabels',
            'chartData',
            'kategoriAduan',
            'pengaduanTerbaru',
            'suratTerbaru',
            'janjiTemuTerbaru', // <-- Dipassing ke view
            'profil',
            'pegawais'
        ));
    }

    // ==========================================
    // FUNGSI UNTUK PENGATURAN WEBSITE (SiteSetting)
    // ==========================================

    public function pengaturan()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function updatePengaturan(Request $request)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    // ==========================================
    // FUNGSI UNTUK PROFIL KELURAHAN & PEGAWAI
    // ==========================================

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'visi'              => 'nullable|string',
            'misi'              => 'nullable|string',
            'deskripsi_sejarah' => 'nullable|string',
            'kecamatan'         => 'nullable|string',
            'kota'              => 'nullable|string',
            'karakter_wilayah'  => 'nullable|string',
            'potensi'           => 'nullable|string',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'geojson_file'      => 'nullable|file|mimes:json,geojson,txt',
        ]);

        // Ubah teks misi per baris menjadi Array agar sesuai dengan casts model
        if ($request->filled('misi')) {
            $validated['misi'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->misi))));
        } else {
            $validated['misi'] = null;
        }

        $profil = Profile::first() ?? new Profile();

        if ($request->hasFile('geojson_file')) {
            if ($profil->geojson_file && Storage::disk('public')->exists($profil->geojson_file)) {
                Storage::disk('public')->delete($profil->geojson_file);
            }
            $validated['geojson_file'] = $request->file('geojson_file')->store('geojson', 'public');
        }

        if ($request->has('delete_geojson') && $profil->geojson_file) {
            Storage::delete('public/' . $profil->geojson_file); // hapus file dari storage
            $profil->geojson_file = null;
        }
        
        $profil->fill($validated)->save();

        return back()->with('success', 'Data profil kelurahan berhasil diperbarui!');
    }

    public function storePegawai(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'urutan'  => 'required|integer',
            'foto'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return back()->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function destroyPegawai($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return back()->with('success', 'Data pegawai berhasil dihapus!');
    }
}

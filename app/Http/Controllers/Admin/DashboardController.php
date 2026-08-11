<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Support\Facades\DB;

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
        $suratTerbaru = LayananSurat::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'summary',
            'chartLabels',
            'chartData',
            'kategoriAduan',
            'pengaduanTerbaru',
            'suratTerbaru'
        ));
    }
}

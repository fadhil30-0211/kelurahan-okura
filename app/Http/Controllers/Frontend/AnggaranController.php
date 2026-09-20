<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun yang dipilih dari filter, atau default ke tahun terbaru yang ada di DB
        $tahunSelected = $request->get('tahun');

        // Ambil daftar tahun unik untuk tab/filter
        $tahunList = Anggaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([date('Y')]);
        }

        if (!$tahunSelected) {
            $tahunSelected = $tahunList->first();
        }

        // Ambil data anggaran berdasarkan tahun yang dipilih
        $dataAnggaran = Anggaran::where('tahun', $tahunSelected)->get();

        // Hitung total anggaran tahun tersebut
        $totalAnggaran = $dataAnggaran->sum('jumlah');

        return view('frontend.anggaran.index', compact(
            'dataAnggaran',
            'tahunSelected',
            'tahunList',
            'totalAnggaran'
        ));
    }
}

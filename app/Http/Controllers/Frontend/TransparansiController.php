<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TransparansiAnggaran;
use Illuminate\Http\Request;

class TransparansiController extends Controller
{
    public function index(Request $request)
    {
        $tahunSelected = $request->get('tahun', date('Y'));

        $tahunList = TransparansiAnggaran::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([date('Y')]);
        }

        $dataAnggaran = TransparansiAnggaran::where('tahun', $tahunSelected)->get();

        $totalAnggaran = $dataAnggaran->sum('anggaran');
        $totalRealisasi = $dataAnggaran->sum('realisasi');
        $persentaseRealisasi = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 0;

        return view('transparansi.index', compact(
            'dataAnggaran',
            'tahunSelected',
            'tahunList',
            'totalAnggaran',
            'totalRealisasi',
            'persentaseRealisasi'
        ));
    }
}

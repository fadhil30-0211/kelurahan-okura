<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;

class SurveiKepuasanController extends Controller
{
    public function index(Request $request)
    {
        $surveis = SurveiKepuasan::when($request->layanan, fn ($q) => $q->where('layanan_terkait', $request->layanan))
            ->latest()
            ->paginate(15);

        $rataRata = SurveiKepuasan::avg('rating');
        $totalResponden = SurveiKepuasan::count();

        $distribusi = SurveiKepuasan::selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        return view('admin.survei.index', compact('surveis', 'rataRata', 'totalResponden', 'distribusi'));
    }
}

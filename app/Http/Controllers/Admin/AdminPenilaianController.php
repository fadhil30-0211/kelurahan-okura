<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class AdminPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = Penilaian::latest();

        // Filter berdasarkan rating jika ada
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        $penilaians = $query->paginate(10);

        // Statistik ringkasan
        $totalUlasan = Penilaian::count();
        $rataRating = Penilaian::avg('rating') ?? 0;
        $ulasanPositif = Penilaian::where('rating', '>=', 4)->count();

        return view('admin.penilaian.index', compact('penilaians', 'totalUlasan', 'rataRating', 'ulasanPositif'));
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->back()->with('success', 'Penilaian/ulasan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggaranController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $anggarans = Anggaran::tahun($tahun)->orderBy('jumlah', 'desc')->get();
        $tahunTersedia = Anggaran::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.anggaran.index', compact('anggarans', 'tahun', 'tahunTersedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun'       => 'required|digits:4|integer|min:2000',
            'kategori'    => 'required|string|max:100',
            'jumlah'      => 'required|numeric|min:0',
            'keterangan'  => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();

        Anggaran::create($validated);

        return redirect()->route('admin.anggaran.index', ['tahun' => $validated['tahun']])
            ->with('success', 'Data anggaran berhasil ditambahkan.');
    }

    public function destroy(Anggaran $anggaran)
    {
        $anggaran->delete();
        return redirect()->route('admin.anggaran.index')->with('success', 'Data anggaran berhasil dihapus.');
    }
}

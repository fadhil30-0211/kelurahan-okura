<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $jumlahPenduduk = SiteSetting::get('jumlah_penduduk', 0);

        return view('admin.pengaturan.index', compact('jumlahPenduduk'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'jumlah_penduduk' => 'required|integer|min:0',
        ]);

        SiteSetting::set('jumlah_penduduk', $validated['jumlah_penduduk']);

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}

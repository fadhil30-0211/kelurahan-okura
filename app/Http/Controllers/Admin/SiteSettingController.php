<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Ambil SELURUH data setting dari DB dalam format array ['key' => 'value']
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // Lempar array $settings ke view admin
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'jumlah_penduduk'       => 'required|numeric|min:0',
            'google_maps_embed_url' => 'nullable|string',
            'latitude'              => 'nullable|string',
            'longitude'             => 'nullable|string',
            'map_zoom'              => 'nullable|numeric',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}

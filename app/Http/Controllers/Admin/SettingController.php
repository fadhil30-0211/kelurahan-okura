<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data pengaturan baris pertama (ID 1)
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // Validasi input (Ditambahkan nama_website_footer)
        $request->validate([
            'nama_website'        => 'nullable|string|max:255',
            'nama_website_footer' => 'nullable|string|max:255', // <-- Ditambahkan
            'nama_instansi'       => 'nullable|string|max:255',
            'email'               => 'nullable|email',
            'telepon'             => 'nullable|string',
            'whatsapp'            => 'nullable|string',
            'pesan_wa'            => 'nullable|string',
            'alamat'              => 'nullable|string',
            'deskripsi'           => 'nullable|string',
            'deskripsi_footer'    => 'nullable|string',
            'jumlah_penduduk'     => 'nullable|numeric',
            'link_map'            => 'nullable|string',
            'latitude'            => 'nullable|string',
            'longitude'           => 'nullable|string',
            'logo'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Ambil data dari form (Ditambahkan nama_website_footer)
        $data = $request->only([
            'nama_website',
            'nama_website_footer', // <-- Ditambahkan
            'nama_instansi',
            'email',
            'telepon',
            'whatsapp',
            'pesan_wa',
            'alamat',
            'deskripsi',
            'deskripsi_footer',
            'jumlah_penduduk',
            'link_map',
            'latitude',
            'longitude'
        ]);

        // Menjaga kompatibilitas nama kolom tabel
        if ($request->filled('nama_website')) {
            $data['nama_instansi'] = $request->nama_website;
        }
        if ($request->filled('deskripsi')) {
            $data['deskripsi_footer'] = $request->deskripsi;
        }

        $setting = Setting::first();

        // Logika Simpan / Timpa Logo
        if ($request->hasFile('logo')) {
            if ($setting && $setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // Simpan ke ID = 1
        Setting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}

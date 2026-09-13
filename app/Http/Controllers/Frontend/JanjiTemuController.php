<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class JanjiTemuController extends Controller
{
    public function create()
    {
        if (SiteSetting::get('janji_temu_aktif', '1') !== '1') {
            abort(503, 'Layanan Janji Temu sedang dinonaktifkan.');
        }
        return view('frontend.janji-temu.create');
    }

    public function store(Request $request)
    {
        if (SiteSetting::get('janji_temu_aktif', '1') !== '1') {
            abort(503, 'Layanan Janji Temu sedang dinonaktifkan.');
        }
        $validated = $request->validate([
            'nama_pemohon'       => 'required|string|max:255',
            'no_hp'              => 'required|string|max:20',
            'keperluan'          => 'required|string|min:10',
            'tanggal_diinginkan' => 'required|date|after_or_equal:today',
            'waktu_diinginkan'   => 'nullable|string|max:50',
        ]);

        $validated['kode_tiket'] = JanjiTemu::generateKodeTiket();
        $validated['status'] = 'menunggu';

        $janjiTemu = JanjiTemu::create($validated);

        session([
            'resi_kode_tiket' => $janjiTemu->kode_tiket,
            'resi_expires_at' => now()->addMinutes(15)->timestamp,
        ]);

        return redirect()->route('resi.show', $janjiTemu->kode_tiket);
    }

    public function trackForm()
    {
        return view('frontend.janji-temu.track');
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'kode_tiket' => 'required|string|max:50',
            'no_hp'      => 'required|string|max:20',
        ]);

        $kodeTiket = strtoupper(trim($validated['kode_tiket']));
        $noHp = trim($validated['no_hp']);

        $janjiTemu = JanjiTemu::where('kode_tiket', $kodeTiket)
            ->where('no_hp', $noHp)
            ->first();

        if (! $janjiTemu) {
            return back()
                ->withInput()
                ->withErrors([
                    'kode_tiket' => 'Kode tiket atau nomor HP tidak sesuai.',
                ]);
        }

        /*
         * Session khusus tracking Janji Temu.
         * Berlaku selama 15 menit.
         */
        $request->session()->regenerate();

        $request->session()->put([
            'janji_temu_tracking_verified' => true,
            'janji_temu_tracking_kode_tiket' => $janjiTemu->kode_tiket,
            'janji_temu_tracking_expires_at' => now()->addMinutes(15)->timestamp,
        ]);

        return view('frontend.janji-temu.track-result', [
            'janjiTemu' => $janjiTemu,
        ]);
    }
}

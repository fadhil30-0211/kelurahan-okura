<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::active()->latest()->paginate(10);
        return view('frontend.pengumuman.index', compact('pengumumans'));
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->status === 'aktif', 404);
        return view('frontend.pengumuman.show', compact('pengumuman'));
    }
}

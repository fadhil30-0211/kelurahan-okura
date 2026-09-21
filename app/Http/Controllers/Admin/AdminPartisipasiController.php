<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartisipasiUmkm;
use App\Models\PartisipasiWisata;
use Illuminate\Http\Request;

class PartisipasiController extends Controller
{
    // ================= UMKM =================
    public function umkmIndex()
    {
        $partisipasi = class_exists(PartisipasiUmkm::class)
            ? PartisipasiUmkm::latest()->paginate(10)
            : collect();

        return view('admin.partisipasi.umkm', compact('partisipasi'));
    }

    public function umkmUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $item = PartisipasiUmkm::findOrFail($id);
        $item->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status partisipasi UMKM berhasil diperbarui.');
    }

    public function umkmDestroy($id)
    {
        $item = PartisipasiUmkm::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Pengajuan partisipasi UMKM berhasil dihapus.');
    }

    // ================= WISATA =================
    public function wisataIndex()
    {
        $partisipasi = class_exists(PartisipasiWisata::class)
            ? PartisipasiWisata::latest()->paginate(10)
            : collect();

        return view('admin.partisipasi.wisata', compact('partisipasi'));
    }

    public function wisataUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $item = PartisipasiWisata::findOrFail($id);
        $item->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status partisipasi Wisata berhasil diperbarui.');
    }

    public function wisataDestroy($id)
    {
        $item = PartisipasiWisata::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Pengajuan partisipasi Wisata berhasil dihapus.');
    }
}

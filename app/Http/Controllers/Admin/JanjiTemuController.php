<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    public function index(Request $request)
    {
        $janjiTemus = JanjiTemu::query()
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('kode_tiket', 'like', '%' . $request->search . '%')
                        ->orWhere('nama_pemohon', 'like', '%' . $request->search . '%')
                        ->orWhere('no_hp', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => JanjiTemu::count(),
            'menunggu' => JanjiTemu::where('status', 'menunggu')->count(),
            'disetujui' => JanjiTemu::where('status', 'disetujui')->count(),
            'ditolak' => JanjiTemu::where('status', 'ditolak')->count(),
            'selesai' => JanjiTemu::where('status', 'selesai')->count(),
        ];

        return view('admin.janji-temu.index', compact(
            'janjiTemus',
            'summary'
        ));
    }

    public function show(JanjiTemu $janjiTemu)
    {
        return view('admin.janji-temu.show', compact('janjiTemu'));
    }

    public function update(Request $request, JanjiTemu $janjiTemu)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string',
        ]);

        $janjiTemu->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        return redirect()
            ->route('admin.janji-temu.show', $janjiTemu)
            ->with('success', 'Status janji temu berhasil diperbarui.');
    }

    public function destroy(JanjiTemu $janjiTemu)
{
    $janjiTemu->delete();
    return back()->with('success', 'Data janji temu berhasil dihapus.');
}
}

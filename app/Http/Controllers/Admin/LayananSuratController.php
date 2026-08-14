<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayananSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LayananSuratController extends Controller
{
    public function index(Request $request)
    {
        $layananSurats = LayananSurat::query()
            ->status($request->status)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('kode_tiket', 'like', "%{$request->search}%")
                        ->orWhere('nama_pemohon', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total'     => LayananSurat::count(),
            'diajukan'  => LayananSurat::where('status', 'diajukan')->count(),
            'diproses'  => LayananSurat::where('status', 'diproses')->count(),
            'selesai'   => LayananSurat::where('status', 'selesai')->count(),
        ];

        return view('admin.layanan-surat.index', compact('layananSurats', 'summary'));
    }

    public function show(LayananSurat $layananSurat)
    {
        return view('admin.layanan-surat.show', compact('layananSurat'));
    }

    public function update(Request $request, LayananSurat $layananSurat)
    {
        $validated = $request->validate([
            'status'         => 'required|in:diajukan,diproses,disetujui,ditolak,selesai',
            'catatan_admin'  => 'nullable|string',
            'file_hasil'     => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $validated['diproses_oleh'] = Auth::id();

        if ($request->hasFile('file_hasil')) {
            if ($layananSurat->file_hasil) {
                Storage::disk('public')->delete($layananSurat->file_hasil);
            }
            $validated['file_hasil'] = $request->file('file_hasil')->store('layanan-surat/hasil', 'public');
        }

        $layananSurat->update($validated);

        return redirect()
            ->route('admin.layanan-surat.show', $layananSurat)
            ->with('success', 'Status layanan surat berhasil diperbarui.');
    }

    public function destroy(LayananSurat $layananSurat)
{
    if ($layananSurat->berkas_persyaratan) {
        foreach ($layananSurat->berkas_persyaratan as $berkas) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($berkas);
        }
    }

    if ($layananSurat->file_hasil) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($layananSurat->file_hasil);
    }

    $layananSurat->delete();

    return redirect()->route('admin.layanan-surat.index')
        ->with('success', 'Data layanan surat berhasil dihapus.');
}
}

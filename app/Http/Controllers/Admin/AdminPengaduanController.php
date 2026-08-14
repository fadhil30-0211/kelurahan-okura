<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $pengaduans = Pengaduan::query()
            ->status($request->status)
            ->when($request->kategori, fn ($q) => $q->where('kategori', $request->kategori))
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('kode_tiket', 'like', "%{$request->search}%")
                        ->orWhere('nama_pelapor', 'like', "%{$request->search}%")
                        ->orWhere('judul_aduan', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total'    => Pengaduan::count(),
            'diterima' => Pengaduan::where('status', 'diterima')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'summary'));
    }

    public function show(Pengaduan $pengaduan)
    {
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status'          => 'required|in:diterima,diproses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $validated['ditangani_oleh'] = Auth::id();

        if ($validated['status'] !== $pengaduan->status) {
            $validated['tanggal_tanggapan'] = now();
        }

        $pengaduan->update($validated);

        return redirect()
            ->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PengaduanExport($request->status, $request->tanggal_mulai, $request->tanggal_selesai),
            'rekap-pengaduan-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $pengaduans = Pengaduan::query()
            ->with('petugas')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->tanggal_mulai, fn ($q) => $q->whereDate('created_at', '>=', $request->tanggal_mulai))
            ->when($request->tanggal_selesai, fn ($q) => $q->whereDate('created_at', '<=', $request->tanggal_selesai))
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.pengaduan.export-pdf', [
            'pengaduans' => $pengaduans,
            'periode'    => $request->tanggal_mulai && $request->tanggal_selesai
                ? \Carbon\Carbon::parse($request->tanggal_mulai)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($request->tanggal_selesai)->translatedFormat('d M Y')
                : 'Semua Periode',
        ])->setPaper('a4', 'landscape');

        return $pdf->download('rekap-pengaduan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required_if:is_anonim,0|nullable|string|max:255',
            'nik'          => 'nullable|string|max:20',
            'no_hp'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'is_anonim'    => 'boolean',
            'kategori'     => 'required|in:infrastruktur,sosial,keamanan,lingkungan,lainnya',
            'judul_aduan'  => 'required|string|max:255',
            'isi_aduan'    => 'required|string|min:20',
            'lampiran'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['is_anonim'] = $request->boolean('is_anonim');
        if ($validated['is_anonim']) {
            $validated['nama_pelapor'] = 'Anonim';
        }

        $validated['kode_tiket'] = Pengaduan::generateKodeTiket();
        $validated['status'] = 'diterima';

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create($validated);

        return redirect()->route('resi.show', $pengaduan->kode_tiket);
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->lampiran) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Data pengaduan berhasil dihapus.');
    }
}

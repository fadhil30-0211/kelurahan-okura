<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LayananSurat;
use Illuminate\Http\Request;

class LayananSuratController extends Controller
{
    // Daftar jenis surat yang bisa diajukan, dengan syarat masing-masing
    public array $jenisSurat = [
        'sktm' => [
            'label' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'syarat' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            'template' => 'templates/sktm-template.pdf',
        ],
        'sku' => [
            'label' => 'Surat Keterangan Usaha (SKU)',
            'syarat' => ['KTP', 'KK', 'Foto Usaha'],
            'template' => 'templates/sku-template.pdf',
        ],
        'domisili' => [
            'label' => 'Surat Keterangan Domisili',
            'syarat' => ['KTP', 'KK'],
            'template' => 'templates/domisili-template.pdf',
        ],
        'kelahiran' => [
            'label' => 'Surat Pengantar Kelahiran',
            'syarat' => ['KK', 'Surat Keterangan Lahir dari Bidan/RS'],
            'template' => 'templates/kelahiran-template.pdf',
        ],
    ];

    public function index()
    {
        $jenisSurat = $this->jenisSurat;
        return view('frontend.layanan.index', compact('jenisSurat'));
    }

    public function create(?string $jenis = null)
    {
        if ($jenis && ! array_key_exists($jenis, $this->jenisSurat)) {
            abort(404);
        }

        $jenisSurat = $this->jenisSurat;
        return view('frontend.layanan.create', compact('jenisSurat', 'jenis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:' . implode(',', array_keys($this->jenisSurat)),
            'nama_pemohon' => 'required|string|max:255',
            'nik'          => 'required|string|size:16',
            'no_hp'        => 'required|string|max:20',
            'keperluan'    => 'required|string|min:10',
            'berkas.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
        ]);

        $validated['kode_tiket'] = LayananSurat::generateKodeTiket();
        $validated['status'] = 'diajukan';
        $validated['jenis_surat'] = $this->jenisSurat[$validated['jenis_surat']]['label'];

        // Upload multi-file persyaratan
        $berkasPaths = [];
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $berkasPaths[] = $file->store('layanan-surat', 'public');
            }
        }
        $validated['berkas_persyaratan'] = $berkasPaths;

        $surat = LayananSurat::create($validated);

        // PERBAIKAN: Arahkan langsung ke halaman resi/detail tiket setelah berhasil
        return redirect()
            ->route('resi.show', $surat->kode_tiket)
            ->with('success', "Pengajuan berhasil dikirim! Kode tiket Anda: {$surat->kode_tiket}. Simpan kode ini untuk melacak status.")
            ->with('kode_tiket', $surat->kode_tiket);
    }

    public function trackForm()
    {
        return view('frontend.layanan.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
            'nik'        => 'required|string',
        ]);

        $surat = LayananSurat::where('kode_tiket', $request->kode_tiket)
            ->where('nik', $request->nik)
            ->first();

        if (! $surat) {
            return back()
                ->withInput()
                ->withErrors(['kode_tiket' => 'Kode tiket atau NIK tidak ditemukan. Periksa kembali data Anda.']);
        }

        return view('frontend.layanan.track-result', compact('surat'));
    }
}

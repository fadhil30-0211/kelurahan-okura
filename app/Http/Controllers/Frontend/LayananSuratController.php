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
        ],
        'sku' => [
            'label' => 'Surat Keterangan Usaha (SKU)',
            'syarat' => ['KTP', 'KK', 'Foto Usaha'],
        ],
        'domisili' => [
            'label' => 'Surat Keterangan Domisili',
            'syarat' => ['KTP', 'KK'],
        ],
        'kelahiran' => [
            'label' => 'Surat Pengantar Kelahiran',
            'syarat' => ['KK', 'Surat Keterangan Lahir dari Bidan/RS'],
        ],
        'nikah' => [
            'label' => 'Surat Pengantar Nikah',
            'syarat' => ['KTP', 'KK', 'Akta Kelahiran', 'Surat Pengantar RT/RW'],
        ],
        'ahli_waris' => [
            'label' => 'Surat Keterangan Ahli Waris',
            'syarat' => ['KTP Seluruh Ahli Waris', 'KK', 'Surat Kematian', 'Surat Pengantar RT/RW'],
        ],
        'skck' => [
            'label' => 'Surat Pengantar SKCK',
            'syarat' => ['KTP', 'KK', 'Pas Foto 4x6'],
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

        $labelJenisSurat = $this->jenisSurat[$validated['jenis_surat']]['label'];

        $validated['kode_tiket'] = LayananSurat::generateKodeTiket($labelJenisSurat);
        $validated['status'] = 'diajukan';
        $validated['jenis_surat'] = $labelJenisSurat;

        // Upload multi-file persyaratan
        $berkasPaths = [];
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $berkasPaths[] = $file->store('layanan-surat', 'public');
            }
        }
        $validated['berkas_persyaratan'] = $berkasPaths;

        $surat = LayananSurat::create($validated);

        return redirect()->route('resi.show', $surat->kode_tiket);
    }

    public function trackForm()
    {
        return redirect()->route('home')->with('info', 'Gunakan kolom "Lacak Pengajuan" di halaman utama untuk melacak status.');
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

        return redirect()->route('resi.show', $surat->kode_tiket);
    }
}

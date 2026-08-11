<?php

namespace App\Exports;

use App\Models\LayananSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LayananSuratExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        protected ?string $status = null,
        protected ?string $tanggalMulai = null,
        protected ?string $tanggalSelesai = null,
    ) {}

    public function collection()
    {
        return LayananSurat::query()
            ->with('petugas')
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->tanggalMulai, fn ($q) => $q->whereDate('created_at', '>=', $this->tanggalMulai))
            ->when($this->tanggalSelesai, fn ($q) => $q->whereDate('created_at', '<=', $this->tanggalSelesai))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return ['Kode Tiket', 'Jenis Surat', 'Nama Pemohon', 'NIK', 'No. HP', 'Status', 'Diproses Oleh', 'Tanggal Ajuan'];
    }

    public function map($surat): array
    {
        return [
            $surat->kode_tiket,
            $surat->jenis_surat,
            $surat->nama_pemohon,
            $surat->nik,
            $surat->no_hp,
            ucfirst($surat->status),
            $surat->petugas->name ?? '-',
            $surat->created_at->format('d-m-Y H:i'),
        ];
    }
}

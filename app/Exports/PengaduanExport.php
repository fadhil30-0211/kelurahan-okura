<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $status = null,
        protected ?string $tanggalMulai = null,
        protected ?string $tanggalSelesai = null,
    ) {}

    public function collection()
    {
        return Pengaduan::query()
            ->with('petugas')
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->tanggalMulai, fn ($q) => $q->whereDate('created_at', '>=', $this->tanggalMulai))
            ->when($this->tanggalSelesai, fn ($q) => $q->whereDate('created_at', '<=', $this->tanggalSelesai))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Tiket',
            'Nama Pelapor',
            'No. HP',
            'Kategori',
            'Judul Aduan',
            'Status',
            'Ditangani Oleh',
            'Tanggal Lapor',
            'Tanggal Tanggapan',
        ];
    }

    public function map($pengaduan): array
    {
        return [
            $pengaduan->kode_tiket,
            $pengaduan->nama_pelapor,
            $pengaduan->no_hp,
            ucfirst($pengaduan->kategori),
            $pengaduan->judul_aduan,
            ucfirst($pengaduan->status),
            $pengaduan->petugas->name ?? '-',
            $pengaduan->created_at->format('d-m-Y H:i'),
            $pengaduan->tanggal_tanggapan?->format('d-m-Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
            ], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}

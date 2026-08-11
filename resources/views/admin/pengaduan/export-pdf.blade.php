{{-- resources/views/admin/pengaduan/export-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #059669; padding-bottom: 12px; }
        .header h1 { font-size: 16px; margin: 0; color: #0B1F3A; }
        .header p { font-size: 10px; color: #64748b; margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #059669; color: #fff; text-align: left; padding: 6px 8px; font-size: 10px; }
        td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 9px; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Data Pengaduan Warga</h1>
        <p>Kelurahan Tebing Tinggi Okura — Periode: {{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tiket</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Judul Aduan</th>
                <th>Status</th>
                <th>Petugas</th>
                <th>Tanggal Lapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduans as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode_tiket }}</td>
                    <td>{{ $item->nama_pelapor }}</td>
                    <td>{{ ucfirst($item->kategori) }}</td>
                    <td>{{ $item->judul_aduan }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->petugas->name ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center; padding: 20px;">Tidak ada data untuk periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
</body>
</html>

{{-- resources/views/frontend/resi/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; background: #0B1F3A; color: #fff; padding: 12px; border-radius: 8px 8px 0 0; }
        .card { border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; padding: 16px; }
        .kode { text-align: center; padding: 16px 0; border-bottom: 1px dashed #cbd5e1; }
        .kode-text { font-size: 20px; font-weight: bold; color: #059669; letter-spacing: 2px; }
        .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 11px; }
        .label { color: #94a3b8; }
        .value { font-weight: bold; }
        .qr { text-align: center; margin: 12px 0; }
        .footer { text-align: center; font-size: 9px; color: #94a3b8; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <p style="margin:0; font-size: 10px;">Kelurahan Tebing Tinggi Okura</p>
        <p style="margin:0; font-weight:bold;">Bukti Pengajuan</p>
    </div>
    <div class="card">
        <div class="kode">
            <p class="label">Kode Tiket</p>
            <p class="kode-text">{{ $item->kode_tiket }}</p>
            <div class="qr">
                <img src="data:image/png;base64,{{ $qrCodeBase64 }}" width="120" height="120">
            </div>
        </div>

        @if ($jenis === 'pengaduan')
            <div class="row"><span class="label">Jenis</span><span class="value">Pengaduan Warga</span></div>
            <div class="row"><span class="label">Pelapor</span><span class="value">{{ $item->nama_pelapor }}</span></div>
        @elseif ($jenis === 'layanan_surat')
            <div class="row"><span class="label">Jenis</span><span class="value">{{ $item->jenis_surat }}</span></div>
            <div class="row"><span class="label">Pemohon</span><span class="value">{{ $item->nama_pemohon }}</span></div>
        @elseif ($jenis === 'janji_temu')
            <div class="row"><span class="label">Jenis</span><span class="value">Janji Temu Lurah</span></div>
            <div class="row"><span class="label">Pemohon</span><span class="value">{{ $item->nama_pemohon }}</span></div>
        @endif
        <div class="row"><span class="label">Tanggal</span><span class="value">{{ $item->created_at->format('d-m-Y H:i') }}</span></div>
        <div class="row"><span class="label">Status</span><span class="value">{{ ucfirst($item->status) }}</span></div>
    </div>
    <p class="footer">Simpan resi ini sebagai bukti pengajuan. Scan QR untuk cek status terkini.</p>
</body>
</html>

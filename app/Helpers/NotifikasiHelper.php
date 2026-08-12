<?php

namespace App\Helpers;

class NotifikasiHelper
{
    public static function pesanPengaduan($pengaduan): string
    {
        $statusText = match ($pengaduan->status) {
            'diterima' => 'telah *diterima* dan akan segera kami tindak lanjuti',
            'diproses' => 'sedang *diproses* oleh petugas kelurahan',
            'selesai'  => 'telah *selesai* ditangani',
            'ditolak'  => 'tidak dapat kami proses lebih lanjut',
            default    => 'telah diperbarui statusnya',
        };

        $pesan = "Assalamu'alaikum {$pengaduan->nama_pelapor},\n\n";
        $pesan .= "Kami dari Kelurahan Tebing Tinggi Okura ingin menginformasikan bahwa pengaduan Anda dengan kode tiket *{$pengaduan->kode_tiket}* ({$pengaduan->judul_aduan}) {$statusText}.\n\n";

        if ($pengaduan->tanggapan_admin) {
            $pesan .= "Tanggapan kami:\n\"{$pengaduan->tanggapan_admin}\"\n\n";
        }

        $pesan .= "Untuk detail lengkap, silakan cek: " . route('resi.show', $pengaduan->kode_tiket) . "\n\n";
        $pesan .= "Terima kasih.";

        return $pesan;
    }

    public static function pesanLayananSurat($surat): string
    {
        $statusText = match ($surat->status) {
            'diajukan'  => 'telah kami terima dan sedang menunggu verifikasi',
            'diproses'  => 'sedang *diproses* oleh petugas kelurahan',
            'disetujui' => 'telah *disetujui*',
            'ditolak'   => 'tidak dapat kami proses, mohon periksa kembali persyaratan',
            'selesai'   => 'telah *selesai* dan siap diambil/diunduh',
            default     => 'telah diperbarui statusnya',
        };

        $pesan = "Assalamu'alaikum {$surat->nama_pemohon},\n\n";
        $pesan .= "Kami dari Kelurahan Tebing Tinggi Okura ingin menginformasikan bahwa pengajuan *{$surat->jenis_surat}* Anda dengan kode tiket *{$surat->kode_tiket}* {$statusText}.\n\n";

        if ($surat->catatan_admin) {
            $pesan .= "Catatan kami:\n\"{$surat->catatan_admin}\"\n\n";
        }

        if ($surat->status === 'selesai' && $surat->file_hasil) {
            $pesan .= "Silakan unduh surat Anda di: " . route('resi.show', $surat->kode_tiket) . "\n\n";
        } else {
            $pesan .= "Untuk detail lengkap, silakan cek: " . route('resi.show', $surat->kode_tiket) . "\n\n";
        }

        $pesan .= "Terima kasih.";

        return $pesan;
    }
}

{{-- resources/views/frontend/resi/show.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Bukti Pengajuan')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-lg mx-auto px-4 sm:px-6">

        {{-- Success Icon --}}
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-800">Pengajuan Berhasil Dikirim!</h1>
            <p class="text-sm text-slate-500 mt-1">Simpan bukti ini untuk melacak status pengajuan Anda.</p>
        </div>

        {{-- Resi Card --}}
        <div id="resi-card" class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-[#0B1F3A] px-6 py-4 text-center">
                <p class="text-xs text-slate-300">Kelurahan Tebing Tinggi Okura</p>
                <p class="text-white font-semibold text-sm">Bukti Pengajuan</p>
            </div>

            <div class="p-6 text-center border-b border-dashed border-slate-200">
                <p class="text-xs text-slate-400 mb-1">Kode Tiket</p>
                <p class="font-mono font-bold text-2xl text-emerald-700 tracking-wider">{{ $item->kode_tiket }}</p>

                <div class="flex justify-center my-4">
                    <div class="p-2 bg-white border border-slate-200 rounded-xl">
                        {!! $qrCode !!}
                    </div>
                </div>
                <p class="text-xs text-slate-400">Scan QR untuk melacak status kapan saja</p>
            </div>

            <div class="p-6 space-y-3 text-sm">
                @if ($jenis === 'pengaduan')
                    <div class="flex justify-between"><span class="text-slate-400">Jenis</span><span class="font-medium text-slate-700">Pengaduan Warga</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pelapor</span><span class="font-medium text-slate-700">{{ $item->nama_pelapor }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Kategori</span><span class="font-medium text-slate-700 capitalize">{{ $item->kategori }}</span></div>
                @elseif ($jenis === 'layanan_surat')
                    <div class="flex justify-between"><span class="text-slate-400">Jenis</span><span class="font-medium text-slate-700">{{ $item->jenis_surat }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pemohon</span><span class="font-medium text-slate-700">{{ $item->nama_pemohon }}</span></div>
                @elseif ($jenis === 'janji_temu')
                    <div class="flex justify-between"><span class="text-slate-400">Jenis</span><span class="font-medium text-slate-700">Janji Temu Lurah</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pemohon</span><span class="font-medium text-slate-700">{{ $item->nama_pemohon }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Diinginkan</span><span class="font-medium text-slate-700">{{ $item->tanggal_diinginkan->translatedFormat('d F Y') }}</span></div>
                @elseif ($jenis === 'wisata')
                    <div class="flex justify-between"><span class="text-slate-400">Jenis</span><span class="font-medium text-slate-700">Pendaftaran Wisata Baru</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Nama Wisata</span><span class="font-medium text-slate-700">{{ $item->nama }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pengaju</span><span class="font-medium text-slate-700">{{ $item->nama_pengaju }}</span></div>
                @elseif ($jenis === 'umkm')
                    <div class="flex justify-between"><span class="text-slate-400">Jenis</span><span class="font-medium text-slate-700">Pendaftaran UMKM Baru</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Nama Usaha</span><span class="font-medium text-slate-700">{{ $item->nama_usaha }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Pengaju</span><span class="font-medium text-slate-700">{{ $item->nama_pengaju }}</span></div>
                @endif

                <div class="flex justify-between"><span class="text-slate-400">Tanggal Pengajuan</span><span class="font-medium text-slate-700">{{ $item->created_at->translatedFormat('d F Y, H:i') }}</span></div>

                {{-- Status Badge yang Sudah Diperbarui --}}
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Status</span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->statusBadgeColor() }}">
                        {{ $item->status === 'pending' ? 'Menunggu Verifikasi' : ucfirst($item->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-2 gap-3 mt-5" x-data="{
            copied: false,
            copyCode() {
                navigator.clipboard.writeText('{{ $item->kode_tiket }}');
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }">

        <div class="mt-6">

        </div>

            <a href="{{ route('resi.download', $item->kode_tiket) }}"
               class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Download PDF
            </a>
            <button onclick="window.print()"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold">
                Cetak Resi
            </button>
            <button @click="copyCode()"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold">
                <span x-show="!copied">Salin Kode</span>
                <span x-show="copied" x-cloak class="text-emerald-600">Tersalin!</span>
            </button>
            <a href="https://wa.me/?text={{ urlencode('Cek status pengajuan saya di Kelurahan Tebing Tinggi Okura dengan kode: ' . $item->kode_tiket . ' — ' . $trackingUrl) }}"
               target="_blank"
               class="flex items-center justify-center gap-2 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold">
                Bagikan WA
            </a>
        </div>

        <a href="{{ route('home') }}" class="block text-center text-sm text-slate-400 mt-6 hover:text-emerald-600">
            ← Kembali ke Beranda
        </a>
    </div>
</section>

<style>
    @media print {
        header, footer, .grid, a[href="{{ route('home') }}"] { display: none !important; }
        #resi-card { box-shadow: none !important; border: 1px solid #ccc !important; }
    }
</style>
@endsection

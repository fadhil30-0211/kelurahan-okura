@extends('layouts.frontend')

@section('content')
    <div class="w-full max-w-xl mx-auto">

        @if(isset($data) || isset($pengaduan))
            @php
                $item = $data ?? $pengaduan;
                $kode = $item->kode_tiket ?? $item->kode_pengaduan ?? '-';
                $status = strtolower($item->status ?? 'diajukan');
                // File hasil pada layanan surat dapat disimpan dengan beberapa nama kolom.
                $fileSurat = $item->file_hasil ?? $item->file_surat ?? $item->file_surat_jadi ?? $item->surat_jadi ?? null;
                $typeLabel = isset($type) ? strtoupper(str_replace('_', ' ', $type)) : 'INFORMASI TIKET';
                $whatsappMessage = "Detail tracking tiket {$kode}\nStatus: " . ucfirst($status) . "\n" . url()->current();
                $whatsappUrl = 'https://wa.me/?text=' . urlencode($whatsappMessage);
            @endphp

            <!-- Card Utama -->
            <div class="w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100 transition-all">

                <!-- Header Kartu Bukti -->
                <div class="bg-slate-900 text-white text-center py-5 px-6 relative">
                    <p class="text-xs tracking-widest text-emerald-400 font-semibold uppercase">Kelurahan Tebing Tinggi Okura</p>
                    <h1 class="text-lg font-bold uppercase tracking-wider mt-1">Detail Status Tracking</h1>
                    <div class="mt-2 inline-block bg-emerald-500/20 text-emerald-300 text-xs px-3 py-1 rounded-full font-medium border border-emerald-500/30">
                        {{ $typeLabel }}
                    </div>
                </div>

                <!-- Content Kartu -->
                <div class="p-4 sm:p-8 space-y-6">

                    <!-- Section Kode Tiket -->
                    <div class="text-center pb-6 border-b border-dashed border-gray-200">
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-semibold block mb-1">Kode Tiket Anda</span>
                        <div class="inline-flex items-center justify-center bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-200">
                            <span class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-wider font-mono">
                                {{ $kode }}
                            </span>
                        </div>
                        <div class="mt-4 flex flex-col items-center">
                            <div id="ticket-qrcode" class="flex justify-center" aria-label="QR code kode tiket"></div>
                            <span class="mt-1 text-[10px] text-gray-400">Scan QR code untuk kode tiket</span>
                        </div>
                    </div>

                    <!-- Informasi Detail List -->
                    <div class="space-y-4 text-sm">
                        <!-- Status -->
                        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Status Saat Ini</span>
                            @if(in_array($status, ['selesai', 'disetujui', 'diterima']))
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    ✓ {{ ucfirst($status) }}
                                </span>
                            @elseif(in_array($status, ['ditolak', 'dibatalkan']))
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                    ✕ {{ ucfirst($status) }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 border border-amber-200 animate-pulse">
                                    ⏳ {{ ucfirst($status) }}
                                </span>
                            @endif
                        </div>

                        <!-- Pemohon / Pelapor -->
                        @if(!empty($item->nama_pemohon) || !empty($item->nama_pelapor) || !empty($item->nama))
                            <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-500 font-medium">Nama Pemohon / Pelapor</span>
                                <span class="max-w-full break-words text-left sm:text-right font-semibold text-slate-800">
                                    {{ $item->nama_pemohon ?? $item->nama_pelapor ?? $item->nama }}
                                </span>
                            </div>
                        @endif

                        <!-- Tanggal Pengajuan -->
                        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Tanggal Pengajuan</span>
                            <span class="max-w-full text-left sm:text-right font-semibold text-slate-800">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB
                            </span>
                        </div>

                    </div>

                    <!-- Tombol Aksi (Cetak / Kembali) -->
                    <div class="pt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
                        <button type="button" onclick="window.print()" class="group w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Detail
                        </button>

                        <a href="{{ url('/') }}" class="w-full flex items-center justify-center bg-slate-100 hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5 text-sm">
                            ← Ke Beranda
                        </a>

                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Kirim detail tiket ke WhatsApp" class="group w-full flex items-center justify-center gap-2.5 bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-200 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-sm {{ !($fileSurat && $status === 'selesai') ? 'lg:col-span-2' : '' }}" style="background: linear-gradient(90deg, #25D366 0%, #128C7E 100%);">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/20 transition-transform duration-200 group-hover:scale-110">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.52 3.48A11.86 11.86 0 0012.08 0C5.53 0 .2 5.33.2 11.88c0 2.09.55 4.13 1.59 5.93L.1 24l6.33-1.66a11.88 11.88 0 005.65 1.43h.01c6.55 0 11.88-5.33 11.88-11.88 0-3.18-1.24-6.16-3.45-8.41zM12.09 21.75h-.01a9.85 9.85 0 01-5.02-1.37l-.36-.21-3.76.99 1-3.67-.23-.38a9.84 9.84 0 01-1.51-5.23C2.2 6.57 6.63 2.14 12.08 2.14a9.8 9.8 0 016.97 2.89 9.8 9.8 0 012.89 6.97c0 5.45-4.43 9.88-9.85 9.88zm5.42-7.4c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.2 5.09 4.49.71.31 1.26.49 1.69.63.71.23 1.35.2 1.86.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/>
                                </svg>
                            </span>
                            Kirim ke WhatsApp
                        </a>

                        @if($fileSurat && $status === 'selesai')
                            <a href="{{ asset('storage/' . ltrim($fileSurat, '/')) }}" target="_blank" download rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 011.414.586l4.414 4.414A2 2 0 0119 9.414V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh Surat Jadi
                            </a>
                        @endif
                    </div>

                </div>
            </div>

        @else
            <!-- Tampilan Jika Data Tidak Ditemukan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center max-w-md mx-auto border border-rose-100">
                <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Tiket Tidak Ditemukan</h3>
                <p class="text-gray-500 text-sm mb-6">Kode tiket yang Anda masukkan tidak terdaftar dalam sistem kami. Silakan periksa kembali.</p>
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
                    Coba Lagi
                </a>
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrCode = document.getElementById('ticket-qrcode');

            if (qrCode) {
                new QRCode(qrCode, {
                    text: @json($kode),
                    width: 160,
                    height: 160,
                    colorDark: '#0f172a',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        });
    </script>
@endpush

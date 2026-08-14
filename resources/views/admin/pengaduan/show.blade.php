{{-- resources/views/admin/pengaduan/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Detail Pengaduan')

@section('content')
<div class="max-w-3xl space-y-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-xs text-slate-400">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-slate-800">{{ $pengaduan->kode_tiket }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $pengaduan->statusBadgeColor() }}">
                {{ ucfirst($pengaduan->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-5">
            <div>
                <p class="text-xs text-slate-400">Nama Pelapor</p>
                <p class="text-slate-700 font-medium">
                    @if ($pengaduan->is_anonim ?? false)
                        🔒 Anonim
                    @else
                        {{ $pengaduan->nama_pelapor }}
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-400">No. HP</p>
                <p class="text-slate-700">{{ $pengaduan->no_hp }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Kategori</p>
                <p class="text-slate-700 capitalize">{{ $pengaduan->kategori }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Tanggal Lapor</p>
                <p class="text-slate-700">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mb-5">
            <p class="text-xs text-slate-400 mb-1">Judul Aduan</p>
            <p class="text-sm font-medium text-slate-800">{{ $pengaduan->judul_aduan }}</p>
        </div>

        <div class="mb-5">
            <p class="text-xs text-slate-400 mb-1">Detail Aduan</p>
            <p class="text-sm text-slate-700">{{ $pengaduan->isi_aduan }}</p>
        </div>

        @if ($pengaduan->lampiran)
            <div>
                <p class="text-xs text-slate-400 mb-2">Lampiran</p>
                <img src="{{ asset('storage/'.$pengaduan->lampiran) }}" class="max-w-xs rounded-xl border border-slate-200" alt="Lampiran">
            </div>
        @endif
    </div>

    @if (auth()->user()->canApprove())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Tanggapi Pengaduan</h3>

            <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Ubah Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        @foreach (['diterima', 'diproses', 'selesai', 'ditolak'] as $status)
                            <option value="{{ $status }}" {{ $pengaduan->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggapan</label>
                    <textarea name="tanggapan_admin" rows="4"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('tanggapan_admin', $pengaduan->tanggapan_admin) }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                            Simpan Tanggapan
                        </button>
                        <a href="{{ route('admin.pengaduan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
                            Kembali
                        </a>
                    </div>
                </div>
            </form>

            <div class="flex justify-end -mt-10">
                <form action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengaduan ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold transition">
                        Hapus Pengaduan
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.86 9.86 0 004.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.13a8.2 8.2 0 01-4.18-1.14l-.3-.18-3.11.82.83-3.04-.2-.31a8.22 8.22 0 01-1.26-4.37c0-4.54 3.7-8.24 8.24-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 012.41 5.83c0 4.54-3.7 8.21-8.26 8.21z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-semibold text-emerald-800 text-sm mb-1">Beri Tahu Pelapor</h3>
                    <p class="text-xs text-emerald-700 mb-4">
                        Kirim update status terkini ke {{ $pengaduan->is_anonim ? 'pelapor' : $pengaduan->nama_pelapor }} melalui WhatsApp. Pesan sudah disiapkan otomatis sesuai status saat ini — Anda bisa mengedit sebelum mengirim.
                    </p>
                    <a href="https://wa.me/{{ $pengaduan->nomorWhatsApp() }}?text={{ urlencode(\App\Helpers\NotifikasiHelper::pesanPengaduan($pengaduan)) }}"
                       target="_blank"
                       onclick="fetch('{{ route('admin.pengaduan.mark-notified', $pengaduan) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                        Kirim Notifikasi via WhatsApp
                    </a>

                    @if ($pengaduan->notif_terakhir_dikirim)
                        <p class="text-xs text-emerald-600 mt-2">
                            ✓ Notifikasi terakhir dikirim: {{ $pengaduan->notif_terakhir_dikirim->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6 text-center text-sm text-slate-400">
            Anda hanya memiliki akses untuk melihat detail. Perubahan status memerlukan wewenang Lurah/Super Admin.
        </div>
    @endif
</div>
@endsection

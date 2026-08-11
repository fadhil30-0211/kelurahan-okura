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
                <p class="text-slate-700 font-medium">{{ $pengaduan->nama_pelapor }}</p>
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
                @csrf @method('PUT')

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

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                        Simpan Tanggapan
                    </button>
                    <a href="{{ route('admin.pengaduan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    @else
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6 text-center text-sm text-slate-400">
            Anda hanya memiliki akses untuk melihat detail. Perubahan status memerlukan wewenang Lurah/Super Admin.
        </div>
    @endif
</div>
@endsection

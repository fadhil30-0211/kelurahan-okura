{{-- resources/views/admin/layanan-surat/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Detail Pengajuan Surat')

@section('content')
<div class="max-w-3xl space-y-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-xs text-slate-400">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-slate-800">{{ $layananSurat->kode_tiket }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $layananSurat->statusBadgeColor() }}">
                {{ ucfirst($layananSurat->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-5">
            <div>
                <p class="text-xs text-slate-400">Jenis Surat</p>
                <p class="text-slate-700 font-medium">{{ $layananSurat->jenis_surat }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Nama Pemohon</p>
                <p class="text-slate-700 font-medium">{{ $layananSurat->nama_pemohon }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">NIK</p>
                <p class="text-slate-700">{{ $layananSurat->nik }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">No. HP</p>
                <p class="text-slate-700">{{ $layananSurat->no_hp }}</p>
            </div>
        </div>

        <div class="mb-5">
            <p class="text-xs text-slate-400 mb-1">Keperluan</p>
            <p class="text-sm text-slate-700">{{ $layananSurat->keperluan }}</p>
        </div>

        @if ($layananSurat->berkas_persyaratan && count($layananSurat->berkas_persyaratan))
            <div class="mb-5">
                <p class="text-xs text-slate-400 mb-2">Berkas Persyaratan</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($layananSurat->berkas_persyaratan as $berkas)
                        <a href="{{ asset('storage/'.$berkas) }}" target="_blank"
                           class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-xs hover:bg-slate-200">
                            📎 Berkas {{ $loop->iteration }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($layananSurat->file_hasil)
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                <p class="text-xs text-emerald-700 mb-1">File Surat Jadi</p>
                <a href="{{ asset('storage/'.$layananSurat->file_hasil) }}" target="_blank" class="text-sm text-emerald-800 font-medium underline">
                    Lihat / Unduh Surat
                </a>
            </div>
        @endif
    </div>

    @if (auth()->user()->canApprove())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Proses Pengajuan</h3>
            <form action="{{ route('admin.layanan-surat.update', $layananSurat) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Ubah Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        @foreach (['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'] as $status)
                            <option value="{{ $status }}" {{ $layananSurat->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Admin</label>
                    <textarea name="catatan_admin" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('catatan_admin', $layananSurat->catatan_admin) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload File Surat Jadi (PDF)</label>
                    <input type="file" name="file_hasil" accept=".pdf"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100">
                    <p class="text-xs text-slate-400 mt-1">Upload jika status sudah "Selesai" agar warga bisa mengunduhnya.</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.layanan-surat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50">
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

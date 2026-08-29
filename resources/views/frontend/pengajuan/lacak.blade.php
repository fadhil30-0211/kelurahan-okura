{{-- resources/views/frontend/pengajuan/lacak.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Lacak Status Pengajuan')

@section('content')
<section class="py-16 bg-slate-50 min-h-[70vh] flex items-center">
    <div class="max-w-xl mx-auto px-4 w-full">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100">
            <h1 class="text-2xl font-bold text-slate-800 text-center mb-2">Lacak Status Pengajuan</h1>
            <p class="text-xs text-slate-500 text-center mb-6">Masukkan Kode Tiket / Nomor Pengajuan Surat yang Anda dapatkan.</p>

            <form action="{{ route('pengajuan.lacak') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Tiket Pengajuan</label>
                    <div class="flex gap-2">
                        <input type="text" name="kode_tiket" value="{{ request('kode_tiket') }}" placeholder="Contoh: TKT-202608-001" required
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Hasil Pencarian --}}
            @if (isset($pengajuan) && $pengajuan)
                <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                    <h2 class="font-semibold text-slate-800 text-sm">Detail Pengajuan</h2>

                    <div class="bg-slate-50 p-4 rounded-xl space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kode Tiket:</span>
                            <span class="font-mono font-bold text-slate-700">{{ $pengajuan->kode_tiket ?? $pengajuan->nomor_pengajuan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama Pemohon:</span>
                            <span class="font-medium text-slate-800">{{ $pengajuan->nama_pemohon ?? $pengajuan->nama }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                            <span class="text-slate-500">Status:</span>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                {{ ($pengajuan->status == 'selesai') ? 'bg-emerald-100 text-emerald-800' :
                                   (($pengajuan->status == 'proses') ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-700') }}">
                                {{ $pengajuan->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

{{-- resources/views/admin/umkm/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Manajemen UMKM')

@section('content')
<div class="space-y-6">
    {{-- Alert Success --}}
    @if (session('success'))
        <div class="flex items-center justify-between p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm shadow-sm">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Control Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        {{-- Form Search Presisi (Inline CSS & Ikon Kaca Pembesar) --}}
        {{-- Form Search yang Terkunci (Tidak Akan Lepas Saat Scroll) --}}
<form method="GET" style="width: 100%; max-width: 24rem; margin: 0;">
    <div style="position: relative; width: 100%; display: flex; align-items: center;">

        {{-- Ikon Kaca Pembesar (Dikunci Vertikal) --}}
        <div style="position: absolute; left: 14px; display: flex; align-items: center; justify-content: center; pointer-events: none; color: #94a3b8; z-index: 5;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Input Search --}}
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama usaha atau pemilik..."
               style="width: 100%; height: 42px; padding-left: 42px !important; padding-right: {{ request('search') ? '36px' : '16px' }}; background-color: #ffffff !important; border-radius: 12px; border: 1px solid #cbd5e1 !important; font-size: 14px; color: #1e293b; outline: none; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">

        {{-- Tombol Reset Search --}}
        @if(request('search'))
            <a href="{{ route('admin.umkm.index') }}"
               style="position: absolute; right: 12px; display: flex; align-items: center; justify-content: center; color: #94a3b8; z-index: 5;"
               class="hover:text-slate-600">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        @endif

    </div>
</form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.umkm.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold shadow-sm transition-all shrink-0">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah UMKM</span>
        </a>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4" style="padding-left: 1.5rem;">Usaha</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse ($umkms as $umkm)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Usaha & Pemilik (Diperbaiki jarak padding kirinya) --}}
                            <td class="px-6 py-4 align-middle" style="padding-left: 1.5rem !important;">
                                <div style="display: flex; align-items: center; gap: 0.875rem;">
                                    <img src="{{ $umkm->foto ? asset('storage/'.$umkm->foto) : asset('images/placeholder.jpg') }}"
                                         style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover; flex-shrink: 0; border: 1px solid #e2e8f0; background-color: #f8fafc; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                                         alt="{{ $umkm->nama_usaha }}">
                                    <div style="min-width: 0;">
                                        <p class="font-semibold text-slate-800 truncate max-w-xs leading-snug" style="margin: 0;">{{ $umkm->nama_usaha }}</p>
                                        <p class="text-xs text-slate-400 truncate max-w-xs" style="margin-top: 2px;">Pemilik: {{ $umkm->nama_pemilik }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-4 font-medium text-slate-700 align-middle whitespace-nowrap capitalize">
                                {{ $umkm->kategori }}
                            </td>

                            {{-- Kontak --}}
                            <td class="px-6 py-4 align-middle whitespace-nowrap text-xs text-slate-500 font-medium">
                                {{ $umkm->no_hp ?? '-' }}
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                @if ($umkm->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        {{ ucfirst($umkm->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.umkm.edit', $umkm) }}"
                                       title="Edit Data"
                                       class="inline-flex items-center justify-center p-2 rounded-xl text-sky-600 bg-sky-50 hover:bg-sky-100 border border-sky-200/50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.umkm.destroy', $umkm) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data UMKM ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                title="Hapus Data"
                                                class="inline-flex items-center justify-center p-2 rounded-xl text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <p class="text-slate-600 font-medium text-sm">Belum ada data UMKM.</p>
                                    <p class="text-xs text-slate-400 mt-1">Silakan tambahkan data UMKM baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($umkms, 'hasPages') && $umkms->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $umkms->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

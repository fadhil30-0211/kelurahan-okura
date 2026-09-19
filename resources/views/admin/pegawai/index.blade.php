{{-- resources/views/admin/pegawai/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Struktur Pegawai')
@section('page-title', 'Struktur Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
        <!-- Judul Halaman -->
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Struktur Pegawai</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data pejabat, NIP, jabatan, dan urutan struktur organisasi kelurahan.</p>
        </div>

        <!-- Toolbar: Search Bar & Tombol Tambah -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 border-t border-slate-100">
            <!-- Search Form Terkunci (Ikon Tidak Lepas Saat Scroll) -->
            <form method="GET" style="width: 100%; max-width: 22rem; margin: 0;">
                <div style="position: relative; width: 100%; display: flex; align-items: center;">

                    {{-- Container Ikon Kaca Pembesar --}}
                    <div style="position: absolute; left: 14px; display: flex; align-items: center; justify-content: center; pointer-events: none; color: #94a3b8; z-index: 5;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    {{-- Input Search --}}
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama / NIP..."
                           style="width: 100%; height: 42px; padding-left: 42px !important; padding-right: {{ request('search') ? '36px' : '16px' }}; background-color: #ffffff !important; border-radius: 12px; border: 1px solid #cbd5e1 !important; font-size: 14px; color: #1e293b; outline: none; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">

                    {{-- Tombol Reset Search --}}
                    @if(request('search'))
                        <a href="{{ route('admin.pegawai.index') }}"
                           style="position: absolute; right: 12px; display: flex; align-items: center; justify-content: center; color: #94a3b8; z-index: 5;"
                           class="hover:text-slate-600">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif

                </div>
            </form>

            <!-- Tombol Tambah Pegawai -->
            <a href="{{ route('admin.pegawai.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 hover:shadow-emerald-200 hover:shadow-md shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pegawai
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-4 px-6" style="padding-left: 1.5rem;">Pegawai</th>
                        <th class="py-4 px-6">Jabatan</th>
                        <th class="py-4 px-6">Kontak</th>
                        <th class="py-4 px-6 text-center">Urutan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($pegawais as $pegawai)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 align-middle" style="padding-left: 1.5rem !important;">
                                <div style="display: flex; align-items: center; gap: 0.875rem;">
                                    @if($pegawai->foto && file_exists(public_path('storage/' . $pegawai->foto)))
                                        <img src="{{ asset('storage/' . $pegawai->foto) }}"
                                             alt="{{ $pegawai->nama }}"
                                             style="width: 40px; height: 40px; border-radius: 9999px; object-fit: cover; flex-shrink: 0; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);">
                                    @else
                                        <div style="width: 40px; height: 40px; border-radius: 9999px; background-color: #d1fae5; color: #047857; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #a7f3d0; font-size: 14px;">
                                            {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div style="min-width: 0;">
                                        <div class="font-semibold text-slate-800 truncate leading-snug">{{ $pegawai->nama }}</div>
                                        <div class="text-xs text-slate-400 font-medium" style="margin-top: 2px;">NIP. {{ $pegawai->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-700 align-middle">
                                {{ $pegawai->jabatan }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500 space-y-0.5 align-middle">
                                <div class="font-medium text-slate-600">{{ $pegawai->no_hp ?? '-' }}</div>
                                <div class="text-slate-400 truncate">{{ $pegawai->email ?? '' }}</div>
                            </td>
                            <td class="py-4 px-6 text-center align-middle">
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200/60">
                                    #{{ $pegawai->urutan }}
                                </span>
                            </td>
                            <td class="py-4 px-6 align-middle">
                                @if($pegawai->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap align-middle">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai) }}"
                                       class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-xs font-semibold rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 px-6 text-center text-slate-400 text-sm">
                                Belum ada data pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($pegawais, 'hasPages') && $pegawais->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $pegawais->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

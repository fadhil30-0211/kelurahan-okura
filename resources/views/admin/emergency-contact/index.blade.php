{{-- resources/views/admin/emergency-contact/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kontak Darurat')
@section('page-title', 'Kontak Darurat')

@section('content')
<div class="space-y-6">

    {{-- ALERT FLASH MESSAGE --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- TABEL KONTAK DARURAT (Kiri) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Daftar Kontak Darurat</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Kelola informasi kontak penting untuk publik</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/60 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-5">Label / Instansi</th>
                            <th class="py-3 px-5">Nomor Telepon</th>
                            <th class="py-3 px-5">Status</th>
                            <th class="py-3 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($contacts as $contact)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Label --}}
                                <td class="py-3.5 px-5 font-semibold text-slate-800">
                                    {{ $contact->label }}
                                </td>

                                {{-- Nomor Telepon --}}
                                <td class="py-3.5 px-5 font-mono text-xs text-slate-600 whitespace-nowrap">
                                    <span class="bg-slate-100 px-2.5 py-1 rounded-md">{{ $contact->nomor_telepon }}</span>
                                </td>

                                {{-- Status Toggle --}}
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <form action="{{ route('admin.emergency-contact.toggle', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                title="Klik untuk mengubah status"
                                                class="px-2.5 py-1 rounded-full text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $contact->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $contact->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            {{ $contact->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.emergency-contact.destroy', $contact) }}" method="POST"
                                          onsubmit="return confirm('Hapus kontak ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <p class="text-sm">Belum ada kontak darurat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FORM TAMBAH KONTAK (Kanan) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-extrabold text-slate-800 text-base mb-1">Tambah Kontak</h3>
            <p class="text-xs text-slate-400 mb-5">Tambahkan nomor penting/darurat baru.</p>

            <form action="{{ route('admin.emergency-contact.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label / Instansi</label>
                    <input type="text" name="label" required placeholder="Contoh: Babinsa, Puskesmas"
                           class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" required placeholder="0812xxxxxxx"
                           class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider shadow-sm transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kontak
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

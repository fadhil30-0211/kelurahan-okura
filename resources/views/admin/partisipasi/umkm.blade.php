@extends('layouts.admin')

@section('page-title', 'Partisipasi UMKM')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ openModal: false, selectedItem: null }">
    {{-- Header --}}
    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <h2 class="text-base font-bold text-slate-800">Daftar Pengajuan Partisipasi UMKM</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi, berkas, dan komunikasi pendaftaran usaha warga.</p>
        </div>
    </div>

    {{-- Tabel Utama --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-100/70 text-slate-700 uppercase text-[11px] tracking-wider font-bold">
                <tr>
                    <th class="px-5 py-3.5">Foto</th>
                    <th class="px-5 py-3.5">Nama Pemilik / Usaha</th>
                    <th class="px-5 py-3.5">Kode Tiket</th>
                    <th class="px-5 py-3.5">Kontak & Alamat</th>
                    <th class="px-5 py-3.5">Kategori</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($partisipasi as $item)
                    @php
                        // Format nomor telepon WhatsApp
                        $phone =$item->no_hp ?? '';
                        $phoneFormatted = preg_replace('/[^0-9]/', '',$phone);
                        if (str_starts_with($phoneFormatted, '0')) {
                            $phoneFormatted = '62' . substr($phoneFormatted, 1);
                        }

                        // Template Pesan WA
                        $namaPemilik =$item->nama_pemilik ?? 'Pemilik UMKM';
                        $namaUsaha   = $item->nama_umkm ?? $item->nama_usaha ?? '-';
                        $kodeTiket   =$item->kode_tiket ?? '-';
                        $status      = strtoupper($item->status ?? 'PENDING');

                        $waMessage = "Halo, Bapak/Ibu *{$namaPemilik}* 👋\n\n"
                                   . "Terima kasih telah mendaftar dalam program *Partisipasi UMKM Kelurahan Okura*.\n\n"
                                   . "📍 *Detail Pendaftaran:*\n"
                                   . "• *Nama Usaha:* {$namaUsaha}\n"
                                   . "• *Kode Tiket:* `{$kodeTiket}`\n"
                                   . "• *Status Saat Ini:* *{$status}*\n\n"
                                   . "---\n\n"
                                   . "💬 *Pesan/Catatan Admin:*\n"
                                   . "[Tuliskan balasan/instruksi Anda di sini]\n\n"
                                   . "Salam hangat,\n"
                                   . "*Tim Pelayanan Kelurahan Okura* 🏛️";

                        $waUrl = "https://wa.me/{$phoneFormatted}?text=" . urlencode($waMessage);
                    @endphp

                    <tr class="hover:bg-slate-50/80 transition">
                        {{-- 1. Thumbnail Foto --}}
                        <td class="px-5 py-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                     alt="Foto {{ $item->nama_umkm ?? $item->nama_usaha }}"
                                     class="w-12 h-12 object-cover rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:opacity-80 transition"
                                     @click="selectedItem = {{ json_encode($item) }}; openModal = true">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-[10px] text-center p-1 font-medium">
                                    No Image
                                </div>
                            @endif
                        </td>

                        {{-- 2. Nama Pemilik & Usaha --}}
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-800">{{ $item->nama_umkm ?? $item->nama_usaha ?? '-' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Pemilik: <span class="font-medium text-slate-700">{{ $item->nama_pemilik ?? '-' }}</span></div>
                        </td>

                        {{-- 3. Kode Tiket --}}
                        <td class="px-5 py-4">
                            <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-mono text-xs font-bold border border-slate-200">
                                {{ $item->kode_tiket ?? '-' }}
                            </span>
                        </td>

                        {{-- 4. Kontak & Alamat --}}
                        <td class="px-5 py-4">
                            <div class="font-semibold text-slate-700 text-xs">{{ $item->no_hp ?? '-' }}</div>
                            <div class="text-xs text-slate-500 max-w-[180px] truncate mt-0.5" title="{{ $item->alamat }}">{{ $item->alamat ?? '-' }}</div>
                        </td>

                        {{-- 5. Kategori --}}
                        <td class="px-5 py-4">
                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                {{ $item->kategori ?? 'Lainnya' }}
                            </span>
                        </td>

                        {{-- 6. Status Dropdown --}}
                        <td class="px-5 py-4">
                            <form action="{{ route('admin.partisipasi-umkm.update-status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border-slate-200 py-1 px-2 font-semibold shadow-sm focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer transition
                                        @if($item->status == 'pending') bg-amber-50 text-amber-700 border-amber-200
                                        @elseif($item->status == 'approved') bg-emerald-50 text-emerald-700 border-emerald-200
                                        @else bg-rose-50 text-rose-700 border-rose-200 @endif">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
                        </td>

                        {{-- 7. Tombol Aksi --}}
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                {{-- Tombol Kirim WhatsApp --}}
                                @if($item->no_hp)
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium shadow-sm transition"
                                       title="Kirim Balasan WhatsApp">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                        WA
                                    </a>
                                @endif

                                {{-- Tombol Detail --}}
                                <button type="button"
                                        @click="selectedItem = {{ json_encode($item) }}; openModal = true"
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium transition">
                                    Detail
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.partisipasi-umkm.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-medium transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada pengajuan partisipasi UMKM.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($partisipasi, 'hasPages') &&$partisipasi->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $partisipasi->links() }}
        </div>
    @endif

    {{-- MODAL DETAIL KELENGKAPAN --}}
    <div x-show="openModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center min-h-screen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl relative border border-slate-100 flex flex-col max-h-[85vh] my-auto overflow-y-auto overscroll-contain"
             @click.away="openModal = false">

            {{-- Header Modal --}}
            <div class="flex justify-between items-start border-b border-slate-100 pb-3 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800" x-text="selectedItem?.nama_umkm || selectedItem?.nama_usaha || 'Detail UMKM'"></h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kode Tiket: <span class="font-mono font-bold text-emerald-600" x-text="selectedItem?.kode_tiket || '-'"></span></p>
                </div>
                <button @click="openModal = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold transition">&times;</button>
            </div>

            {{-- Body Modal --}}
            <template x-if="selectedItem">
                <div class="space-y-3.5 text-xs text-slate-600">
                    {{-- Preview Foto Berkas --}}
                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Foto Berkas / Produk Usaha</span>
                        <template x-if="selectedItem.foto">
                            <a :href="'{{ asset('storage') }}/' + selectedItem.foto" target="_blank" rel="noopener noreferrer" class="block">
                                <img :src="'{{ asset('storage') }}/' + selectedItem.foto"
                                     alt="Foto Produk UMKM"
                                     class="w-full max-h-56 object-cover rounded-xl border border-slate-200 shadow-sm hover:opacity-90 transition">
                            </a>
                        </template>
                        <template x-if="!selectedItem.foto">
                            <div class="w-full h-32 rounded-xl bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-400 font-medium">
                                Tidak ada foto terlampir
                            </div>
                        </template>
                    </div>

                    {{-- Data Rincian --}}
                    <div class="grid grid-cols-2 gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold">Nama Pemilik</span>
                            <span class="font-semibold text-slate-800 text-xs" x-text="selectedItem.nama_pemilik || '-'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold">Kategori</span>
                            <span class="font-semibold text-slate-800 text-xs uppercase" x-text="selectedItem.kategori || '-'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold">No. WhatsApp</span>
                            <span class="font-semibold text-slate-800 text-xs" x-text="selectedItem.no_hp || '-'"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold">Status Pendaftaran</span>
                            <span class="font-bold text-xs uppercase"
                                  :class="{
                                      'text-amber-600': selectedItem.status === 'pending',
                                      'text-emerald-600': selectedItem.status === 'approved',
                                      'text-rose-600': selectedItem.status === 'rejected'
                                  }"
                                  x-text="selectedItem.status || 'pending'"></span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Alamat Usaha</span>
                        <p class="bg-slate-50 p-2.5 rounded-lg border border-slate-100 text-slate-700" x-text="selectedItem.alamat || '-'"></p>
                    </div>

                    <div>
                        <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Deskripsi Usaha & Perlengkapan</span>
                        <p class="bg-slate-50 p-2.5 rounded-lg border border-slate-100 text-slate-700 whitespace-pre-line max-h-32 overflow-y-auto" x-text="selectedItem.deskripsi || '-'"></p>
                    </div>
                </div>
            </template>

            {{-- Footer Modal --}}
            <div class="mt-5 text-right">
                <button @click="openModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

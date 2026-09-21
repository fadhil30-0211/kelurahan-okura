@extends('layouts.admin')

@section('page-title', 'Partisipasi Wisata')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
     x-data="{
         openModal: false,
         selectedItem: null,
         openDetail(item) {
             this.selectedItem = item;
             this.openModal = true;
         }
     }">

    {{-- Header --}}
    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <h2 class="text-base font-bold text-slate-800">Daftar Pengajuan Partisipasi Wisata</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi, berkas, dan komunikasi pendaftaran destinasi wisata dari warga.</p>
        </div>
    </div>

    {{-- Tabel Utama --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 min-w-[700px]">
            <thead class="bg-slate-100/70 text-slate-700 uppercase text-[11px] tracking-wider font-bold">
                <tr>
                    <th class="px-5 py-3.5">Foto</th>
                    <th class="px-5 py-3.5">Nama Wisata / Pengaju</th>
                    <th class="px-5 py-3.5">Kode Tiket</th>
                    <th class="px-5 py-3.5">Kontak & Lokasi</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($partisipasi as $item)
                    @php
                        $phone =$item->no_hp ?? '';
                        $phoneFormatted = preg_replace('/[^0-9]/', '',$phone);
                        if (str_starts_with($phoneFormatted, '0')) {
                            $phoneFormatted = '62' . substr($phoneFormatted, 1);
                        }

                        $waMessage = "Halo, Bapak/Ibu *" . ($item->nama_pengaju ?? 'Pengaju Wisata') . "* 👋\n\n"
                                   . "Terima kasih telah mengajukan destinasi *" . ($item->nama_wisata ?? '-') . "* dalam program *Partisipasi Wisata Kelurahan Okura*.\n\n"
                                   . "📍 *Detail Pendaftaran:*\n"
                                   . "• *Nama Wisata:* " . ($item->nama_wisata ?? '-') . "\n"
                                   . "• *Kode Tiket:* `" . ($item->kode_tiket ?? '-') . "`\n"
                                   . "• *Status Saat Ini:* *" . strtoupper($item->status ?? 'PENDING') . "*\n\n"
                                   . "--- \n\n"
                                   . "💬 *Pesan/Catatan Admin:*\n"
                                   . "[Tuliskan balasan/instruksi Anda di sini]\n\n"
                                   . "Salam hangat,\n"
                                   . "*Tim Pelayanan Kelurahan Okura* 🏛️";

                        $waUrl = "https://wa.me/" . $phoneFormatted . "?text=" . urlencode($waMessage);

                        // Enkripsi JSON aman untuk HTML attribute
                        $itemJson = json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                    @endphp

                    <tr class="hover:bg-slate-50/80 transition">
                        {{-- Foto --}}
                        <td class="px-5 py-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                     alt="Foto {{ $item->nama_wisata }}"
                                     class="w-12 h-12 object-cover rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:opacity-80 transition"
                                     @click="openDetail({{ $itemJson }})">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-[10px] text-center p-1">
                                    No Image
                                </div>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-800">{{ $item->nama_wisata ?? '-' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">Pengaju: <span class="font-medium text-slate-700">{{ $item->nama_pengaju ?? '-' }}</span></div>
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-mono text-xs font-bold border border-slate-200">
                                {{ $item->kode_tiket ?? '-' }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <div class="font-semibold text-slate-700 text-xs">{{ $item->no_hp ?? '-' }}</div>
                            <div class="text-xs text-slate-500 max-w-[180px] truncate mt-0.5" title="{{ $item->lokasi }}">{{ $item->lokasi ?? '-' }}</div>
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.partisipasi-wisata.update-status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border-slate-200 py-1 px-2 font-semibold shadow-sm focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer
                                        @if($item->status == 'pending') bg-amber-50 text-amber-700 border-amber-200
                                        @elseif($item->status == 'approved') bg-emerald-50 text-emerald-700 border-emerald-200
                                        @else bg-rose-50 text-rose-700 border-rose-200 @endif">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
                        </td>

                        <td class="px-5 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-2">
                                @if($item->no_hp)
                                    <a href="{{ $waUrl }}" target="_blank"
                                       class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium shadow-sm transition"
                                       title="Kirim Balasan WhatsApp">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.52 3.449A11.867 11.867 0 0 0 12.034 0C5.474 0 .134 5.34.131 11.901c0 2.096.547 4.143 1.587 5.946L.03 24l6.306-1.654a11.9 11.9 0 0 0 5.692 1.448h.005c6.557 0 11.894-5.34 11.897-11.901a11.87 11.87 0 0 0-3.41-8.444zM12.033 21.8h-.004a9.88 9.88 0 0 1-5.034-1.378l-.361-.214-3.742.982 1-3.648-.235-.374a9.86 9.86 0 0 1-1.511-5.267C2.149 6.46 6.58 2.03 12.038 2.03a9.82 9.82 0 0 1 6.988 2.898 9.87 9.87 0 0 1 2.894 6.994c-.003 5.46-4.435 9.878-9.887 9.878zm5.424-7.4c-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347z"/>
                                        </svg>
                                        WA
                                    </a>
                                @endif

                                {{-- Tombol Detail --}}
                                <button type="button"
                                        @click="openDetail({{ $itemJson }})"
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium transition cursor-pointer">
                                    Detail
                                </button>

                                <form action="{{ route('admin.partisipasi-wisata.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pengajuan wisata ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-medium transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada pengajuan partisipasi wisata.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($partisipasi, 'hasPages') &&$partisipasi->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $partisipasi->links() }}
        </div>
    @endif

    {{-- MODAL DETAIL --}}
    <div x-show="openModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center min-h-screen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-xl relative border border-slate-100 flex flex-col max-h-[85vh] my-auto"
             @click.away="openModal = false">

            {{-- Header Modal --}}
            <div class="flex justify-between items-start border-b border-slate-100 pb-3 mb-4 shrink-0">
                <div>
                    <h3 class="text-base font-bold text-slate-800" x-text="selectedItem?.nama_wisata || 'Detail Wisata'"></h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kode Tiket: <span class="font-mono font-bold text-emerald-600" x-text="selectedItem?.kode_tiket || '-'"></span></p>
                </div>
                <button type="button" @click="openModal = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold px-1">&times;</button>
            </div>

            {{-- Body Modal --}}
            <div class="overflow-y-auto pr-1 space-y-3.5 text-xs text-slate-600 custom-scrollbar flex-1">
                <template x-if="selectedItem">
                    <div class="space-y-3.5">
                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Foto Lokasi Wisata</span>
                            <template x-if="selectedItem.foto">
                                <a :href="'/storage/' + selectedItem.foto" target="_blank" class="block">
                                    <img :src="'/storage/' + selectedItem.foto"
                                         alt="Foto Wisata"
                                         class="w-full max-h-48 object-cover rounded-xl border border-slate-200 shadow-sm hover:opacity-90 transition">
                                </a>
                            </template>
                            <template x-if="!selectedItem.foto">
                                <div class="w-full h-28 rounded-xl bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-400">
                                    Tidak ada foto terlampir
                                </div>
                            </template>
                        </div>

                        <div class="grid grid-cols-2 gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div>
                                <span class="block text-[10px] text-slate-400 uppercase font-semibold">Nama Pengaju</span>
                                <span class="font-semibold text-slate-800 text-xs" x-text="selectedItem.nama_pengaju || '-'"></span>
                            </div>
                            <div>
                                <span class="block text-[10px] text-slate-400 uppercase font-semibold">No. WhatsApp</span>
                                <span class="font-semibold text-slate-800 text-xs" x-text="selectedItem.no_hp || '-'"></span>
                            </div>
                            <div class="col-span-2">
                                <span class="block text-[10px] text-slate-400 uppercase font-semibold">Status Pengajuan</span>
                                <span class="font-bold text-xs uppercase"
                                      :class="{
                                          'text-amber-600': selectedItem.status === 'pending',
                                          'text-emerald-600': selectedItem.status === 'approved',
                                          'text-rose-600': selectedItem.status === 'rejected'
                                      }"
                                      x-text="selectedItem.status"></span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Lokasi Wisata</span>
                            <p class="bg-slate-50 p-2.5 rounded-lg border border-slate-100 text-slate-700" x-text="selectedItem.lokasi || '-'"></p>
                        </div>

                        <div>
                            <span class="block text-[10px] text-slate-400 uppercase font-semibold mb-1">Deskripsi & Daya Tarik</span>
                            <p class="bg-slate-50 p-2.5 rounded-lg border border-slate-100 text-slate-700 whitespace-pre-line" x-text="selectedItem.deskripsi || '-'"></p>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Footer Modal --}}
            <div class="mt-4 pt-3 border-t border-slate-100 text-right shrink-0">
                <button type="button" @click="openModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

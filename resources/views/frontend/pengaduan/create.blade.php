{{-- resources/views/frontend/pengaduan/create.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Lapor Pengaduan')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold mb-3">
                Pengaduan Warga
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Sampaikan Keluhan Anda
            </h1>
            <p class="text-sm text-slate-500 mt-2">
                Aduan Anda akan ditindaklanjuti oleh petugas kelurahan. Tidak perlu akun, cukup isi form berikut.
            </p>
        </div>

        @if (session('kode_tiket'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6 text-center">
                <p class="text-sm text-emerald-700 mb-1">Pengaduan berhasil dikirim! Kode tiket Anda:</p>
                <p class="text-2xl font-bold font-mono text-emerald-800 tracking-wider">{{ session('kode_tiket') }}</p>
                <p class="text-xs text-emerald-600 mt-2">Simpan kode ini untuk melacak status pengaduan Anda.</p>
                <a href="{{ route('pengaduan.track.form') }}" class="inline-block mt-3 text-xs font-semibold text-emerald-700 underline hover:text-emerald-800">
                    Lacak status sekarang →
                </a>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data"
              x-data="{ anonim: {{ old('is_anonim') ? 'true' : 'false' }} }"
              class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8 space-y-5">
            @csrf

            {{-- Toggle Anonim --}}
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <p class="text-sm font-medium text-slate-700">Laporkan sebagai Anonim</p>
                        <p class="text-xs text-slate-400">Identitas Anda tidak akan ditampilkan ke petugas.</p>
                    </div>
                    <input type="checkbox" name="is_anonim" value="1" x-model="anonim"
                           class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Field Nama Lengkap (Kondisional) --}}
                <div x-show="!anonim" x-transition>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" :required="!anonim" :disabled="anonim"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('nama_pelapor') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- No. HP / WA (Tetap Ada) --}}
                <div :class="anonim ? 'sm:col-span-2' : ''">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">NIK <span class="text-slate-400">(opsional)</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" placeholder="16 digit NIK"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-slate-400">(opsional)</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Aduan <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2" x-data="{ selected: '{{ old('kategori', 'infrastruktur') }}' }">
                    @foreach (['infrastruktur' => 'Infrastruktur', 'sosial' => 'Sosial', 'keamanan' => 'Keamanan', 'lingkungan' => 'Lingkungan', 'lainnya' => 'Lainnya'] as $val => $label)
                        <label class="relative">
                            <input type="radio" name="kategori" value="{{ $val }}" x-model="selected" class="sr-only peer" {{ old('kategori', 'infrastruktur') == $val ? 'checked' : '' }}>
                            <div class="text-center px-2 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 cursor-pointer peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 transition">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Aduan <span class="text-red-500">*</span></label>
                <input type="text" name="judul_aduan" value="{{ old('judul_aduan') }}" required placeholder="Contoh: Lampu jalan mati di RT 03"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                @error('judul_aduan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jelaskan Detail Aduan <span class="text-red-500">*</span></label>
                <textarea name="isi_aduan" rows="4" required minlength="20" placeholder="Jelaskan lokasi, waktu kejadian, dan detail lainnya..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none resize-none">{{ old('isi_aduan') }}</textarea>
                @error('isi_aduan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Lampiran Foto <span class="text-slate-400">(opsional, maks. 2MB)</span></label>
                <input type="file" name="lampiran" accept="image/*"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-medium hover:file:bg-emerald-100">
                @error('lampiran') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Kirim Pengaduan
            </button>

            <p class="text-xs text-center text-slate-400">
                Sudah pernah lapor? <a href="{{ route('pengaduan.track.form') }}" class="text-emerald-600 font-medium hover:underline">Lacak status di sini</a>
            </p>
        </form>
    </div>
</section>
@endsection

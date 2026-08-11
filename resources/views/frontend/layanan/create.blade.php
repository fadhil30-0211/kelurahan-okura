{{-- resources/views/frontend/layanan/create.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Ajukan Surat')

@section('content')
<section class="pt-28 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Formulir Pengajuan Surat
            </h1>
            <p class="text-sm text-slate-500 mt-2">Lengkapi data diri dan unggah berkas persyaratan.</p>
        </div>

        @if (session('kode_tiket'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6 text-center">
                <p class="text-sm text-emerald-700 mb-1">Pengajuan berhasil dikirim! Kode tiket Anda:</p>
                <p class="text-2xl font-bold font-mono text-emerald-800 tracking-wider">{{ session('kode_tiket') }}</p>
                <p class="text-xs text-emerald-600 mt-2">Simpan kode ini untuk melacak status pengajuan Anda.</p>
            </div>
        @endif

        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Surat <span class="text-red-500">*</span></label>
                <select name="jenis_surat" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach ($jenisSurat as $key => $surat)
                        <option value="{{ $key }}" {{ (old('jenis_surat', $jenis) == $key) ? 'selected' : '' }}>
                            {{ $surat['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_surat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('nama_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" placeholder="16 digit NIK"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Keperluan <span class="text-red-500">*</span></label>
                <textarea name="keperluan" rows="3" required minlength="10" placeholder="Jelaskan untuk keperluan apa surat ini dibutuhkan..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none resize-none">{{ old('keperluan') }}</textarea>
                @error('keperluan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Berkas Persyaratan <span class="text-slate-400">(foto/PDF, bisa lebih dari satu)</span></label>
                <input type="file" name="berkas[]" multiple accept="image/*,.pdf"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-medium hover:file:bg-emerald-100">
                <p class="text-xs text-slate-400 mt-1.5">Unggah KTP, KK, dan berkas lain sesuai jenis surat yang dipilih (maks. 2MB per file).</p>
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Ajukan Surat
            </button>

            <p class="text-xs text-center text-slate-400">
                Sudah pernah mengajukan? <a href="{{ route('layanan.track.form') }}" class="text-emerald-600 font-medium hover:underline">Lacak status di sini</a>
            </p>
        </form>
    </div>

            {{-- Tambahkan setelah dropdown jenis_surat di create.blade.php --}}
        <div x-data="{ jenisSurat: @js($jenisSurat) }">
            <template x-if="$refs.jenisSelect && $refs.jenisSelect.value">
                <a :href="'/' + jenisSurat[$refs.jenisSelect.value]?.template" download
                class="inline-flex items-center gap-1.5 text-xs text-emerald-600 font-medium hover:underline mt-1">
                    📄 Download template formulir jenis surat ini
                </a>
            </template>
        </div>
</section>
@endsection

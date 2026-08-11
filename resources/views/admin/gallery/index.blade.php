{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Kelola Galeri Foto')

@section('content')
<div class="space-y-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-3 mb-1">
            <h2 class="font-semibold text-slate-800">
                Galeri untuk: {{ $item->nama ?? $item->nama_usaha ?? $item->judul }}
            </h2>
        </div>
        <p class="text-xs text-slate-400">Upload hingga 20 foto sekaligus. Foto ini akan tampil sebagai galeri pendukung di halaman detail.</p>
    </div>

    {{-- Upload Form --}}
    <form action="{{ route('admin.gallery.store', [$type, $item->id]) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6"
          x-data="{ previews: [] }">
        @csrf

        <label class="block text-sm font-medium text-slate-700 mb-2">Tambah Foto</label>
        <input type="file" name="foto[]" multiple accept="image/*" required
               @change="previews = Array.from($event.target.files).map(f => URL.createObjectURL(f))"
               class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-medium hover:file:bg-emerald-100 mb-4">

        {{-- Live Preview Sebelum Upload --}}
        <div x-show="previews.length" class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-4">
            <template x-for="(src, i) in previews" :key="i">
                <img :src="src" class="w-full h-20 object-cover rounded-lg border border-slate-200">
            </template>
        </div>
        @error('foto') <p class="text-xs text-red-500 mb-3">{{ $message }}</p> @enderror
        @error('foto.*') <p class="text-xs text-red-500 mb-3">{{ $message }}</p> @enderror

        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            Upload Foto
        </button>
    </form>

    {{-- Grid Foto Tersimpan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-4">Foto Tersimpan ({{ $galleries->count() }})</h3>
        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3">
            @forelse ($galleries as $foto)
                <div class="group relative rounded-xl overflow-hidden border border-slate-200">
                    <img src="{{ asset('storage/'.$foto->path) }}" class="w-full h-24 object-cover" alt="">
                    <form action="{{ route('admin.gallery.destroy', $foto) }}" method="POST"
                          onsubmit="return confirm('Hapus foto ini?')"
                          class="absolute top-1.5 right-1.5 opacity-0 group-hover:opacity-100 transition">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-6 h-6 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">✕</button>
                    </form>
                </div>
            @empty
                <p class="col-span-6 text-center text-slate-400 text-sm py-8">Belum ada foto galeri.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('admin.'.$type.'.index') }}" class="inline-block text-sm text-slate-500 hover:text-emerald-600">
        ← Kembali ke daftar {{ $type }}
    </a>
</div>
@endsection

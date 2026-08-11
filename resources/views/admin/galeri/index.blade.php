{{-- resources/views/admin/galeri/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Galeri Kegiatan')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex gap-2">
            @foreach (['' => 'Semua', 'kegiatan' => 'Kegiatan', 'fasilitas' => 'Fasilitas', 'wisata' => 'Wisata'] as $val => $label)
                <a href="{{ route('admin.galeri.index', ['kategori' => $val]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request('kategori', '') == $val ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Foto
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse ($galeris as $galeri)
            <div class="group relative rounded-2xl overflow-hidden bg-white shadow-sm border border-slate-100">
                <img src="{{ asset('storage/'.$galeri->foto) }}" class="w-full h-40 object-cover" alt="{{ $galeri->judul }}">
                <div class="p-3">
                    <p class="text-xs font-medium text-slate-700 truncate">{{ $galeri->judul }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ $galeri->kategori }}</p>
                </div>
                <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST"
                      onsubmit="return confirm('Hapus foto ini?')"
                      class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-7 h-7 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">✕</button>
                </form>
            </div>
        @empty
            <p class="col-span-4 text-center py-10 text-slate-400 text-sm">Belum ada foto galeri.</p>
        @endforelse
    </div>

    @if ($galeris->hasPages())
        <div class="pt-2">{{ $galeris->links() }}</div>
    @endif
</div>
@endsection

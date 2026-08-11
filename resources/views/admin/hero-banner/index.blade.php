{{-- resources/views/admin/hero-banner/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Hero Banner Slider')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">Seret kartu untuk mengatur urutan tampil banner.</p>
        <a href="{{ route('admin.hero-banner.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Banner
        </a>
    </div>

    <div id="banner-list" class="space-y-3">
        @forelse ($banners as $banner)
            <div data-id="{{ $banner->id }}"
                 class="banner-item flex items-center gap-4 bg-white rounded-2xl shadow-sm border border-slate-100 p-4 cursor-move">
                <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
                <img src="{{ asset('storage/'.$banner->gambar) }}" class="w-24 h-14 rounded-lg object-cover flex-shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-slate-800 truncate">{{ $banner->judul ?? '(Tanpa judul)' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $banner->subjudul }}</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium flex-shrink-0 {{ $banner->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.hero-banner.edit', $banner) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.hero-banner.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center text-slate-400 text-sm">
                Belum ada banner. Tambahkan minimal 1 banner supaya hero section homepage tampil.
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Drag-and-drop sederhana pakai native HTML5 Drag API (tanpa library tambahan)
    const list = document.getElementById('banner-list');
    let dragged;

    list.addEventListener('dragstart', (e) => {
        dragged = e.target.closest('.banner-item');
        e.target.style.opacity = 0.5;
    });

    list.addEventListener('dragend', (e) => {
        e.target.style.opacity = '';
        saveOrder();
    });

    list.addEventListener('dragover', (e) => {
        e.preventDefault();
        const target = e.target.closest('.banner-item');
        if (target && target !== dragged) {
            const rect = target.getBoundingClientRect();
            const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
            list.insertBefore(dragged, next ? target.nextSibling : target);
        }
    });

    document.querySelectorAll('.banner-item').forEach(item => item.setAttribute('draggable', true));

    function saveOrder() {
        const order = [...document.querySelectorAll('.banner-item')].map(el => el.dataset.id);
        fetch('{{ route("admin.hero-banner.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ order }),
        });
    }
</script>
@endpush

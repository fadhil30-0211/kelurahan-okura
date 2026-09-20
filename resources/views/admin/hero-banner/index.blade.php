{{-- resources/views/admin/hero-banner/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Hero Banner Slider')
@section('page-title', 'Hero Banner Slider')

@section('content')
<div class="space-y-6">

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- HEADER BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-800">Daftar Banner</h3>
            <p class="text-xs text-slate-500">Seret/drag kartu untuk mengatur urutan prioritas tampilan banner di homepage.</p>
        </div>

        <a href="{{ route('admin.hero-banner.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider shadow-sm transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Banner
        </a>
    </div>

    {{-- DAFTAR BANNER (DRAGGABLE LIST) --}}
    <div id="banner-list" class="space-y-3">
        @forelse ($banners as $banner)
            <div data-id="{{ $banner->id }}"
                 class="banner-item flex items-center gap-4 bg-white rounded-2xl shadow-sm border border-slate-100 p-4 cursor-grab active:cursor-grabbing hover:border-slate-200 transition-all select-none">

                {{-- Handle Drag Icon --}}
                <div class="text-slate-300 hover:text-slate-500 shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                    </svg>
                </div>

                {{-- Image Preview --}}
                <div class="w-24 h-14 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                    <img src="{{ Storage::url($banner->gambar) }}" class="w-full h-full object-cover" alt="{{ $banner->judul }}">
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-800 text-xs md:text-sm truncate">
                        {{ $banner->judul ?? '(Tanpa Judul)' }}
                    </p>
                    <p class="text-xs text-slate-500 truncate mt-0.5">
                        {{ $banner->subjudul ?? '-' }}
                    </p>
                </div>

                {{-- Status Badge --}}
                <div class="shrink-0">
                    @if ($banner->is_active)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            Nonaktif
                        </span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-1 shrink-0 border-l border-slate-100 pl-3">
                    {{-- Edit --}}
                    <a href="{{ route('admin.hero-banner.edit', $banner) }}"
                       class="p-1.5 rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition"
                       title="Edit Banner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('admin.hero-banner.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                title="Hapus Banner">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-medium text-slate-600">Belum ada banner yang ditambahkan</p>
                    <p class="text-xs text-slate-400 mt-1">Tambahkan minimal 1 banner agar hero slider di halaman utama berfungsi.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    const list = document.getElementById('banner-list');
    let dragged = null;

    list.addEventListener('dragstart', (e) => {
        dragged = e.target.closest('.banner-item');
        if (dragged) {
            dragged.classList.add('opacity-40', 'bg-slate-50');
        }
    });

    list.addEventListener('dragend', (e) => {
        if (dragged) {
            dragged.classList.remove('opacity-40', 'bg-slate-50');
            saveOrder();
        }
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

    document.querySelectorAll('.banner-item').forEach(item => {
        item.setAttribute('draggable', true);
    });

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

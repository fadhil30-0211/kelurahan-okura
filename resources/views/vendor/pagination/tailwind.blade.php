{{-- resources/views/vendor/pagination/tailwind.blade.php --}}
@if ($paginator->hasPages())
    <nav class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-slate-400 border border-slate-200 rounded-xl">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">Sebelumnya</a>
            @endif
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">Selanjutnya</a>
            @else
                <span class="px-4 py-2 text-sm text-slate-400 border border-slate-200 rounded-xl">Selanjutnya</span>
            @endif
        </div>

        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-medium">{{ $paginator->firstItem() }}</span>
                - <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari <span class="font-medium">{{ $paginator->total() }}</span> data
            </p>
            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-1.5 text-sm text-slate-400">{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-1.5 text-sm rounded-lg bg-emerald-600 text-white font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-sm rounded-lg text-slate-600 hover:bg-slate-100">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </nav>
@endif

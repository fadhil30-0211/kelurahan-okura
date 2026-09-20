{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | Kelurahan Okura</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Asset Bundler --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800"
      x-data="{ sidebarOpen: false }"
      @keydown.window.escape="sidebarOpen = false">

    <div class="flex min-h-screen">

        {{-- ============ SIDEBAR ============ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-[#0B1F3A] text-slate-300 transition-transform duration-300 ease-in-out flex flex-col shrink-0">

            {{-- HEADER SIDEBAR --}}
            <div class="flex items-center gap-3 px-5 h-16 border-b border-white/10 shrink-0">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Logo Admin"
                    class="w-8 h-8 object-contain shrink-0">
                <div class="flex flex-col min-w-0">
                    <span class="font-bold text-white text-sm leading-tight truncate">Kelurahan Okura</span>
                    <span class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">Panel Admin</span>
                </div>
            </div>

            {{-- NAVIGATION --}}
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                @php
                    $userRole = auth()->user()->role ?? 'staf';

                    $menus = collect([
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'roles' => ['super_admin', 'lurah', 'staf']],
                        ['label' => 'Kontak Darurat', 'route' => 'admin.emergency-contact.index', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'roles' => ['super_admin', 'staf']],
                        ['label' => 'Berita', 'route' => 'admin.berita.index', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'roles' => ['super_admin', 'staf' => 'lurah']],
                        ['label' => 'Pengumuman', 'route' => 'admin.pengumuman.index', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z', 'roles' => ['super_admin', 'staf']],
                        ['label' => 'Pegawai', 'route' => 'admin.pegawai.index', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z', 'roles' => ['super_admin']],
                        ['label' => 'Wisata', 'route' => 'admin.wisata.index', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'roles' => ['super_admin', 'staf', 'lurah']],
                        ['label' => 'UMKM', 'route' => 'admin.umkm.index', 'icon' => 'M3 3h18v4H3V3zm2 6h14v12H5V9zm4 3h6', 'roles' => ['super_admin', 'staf', 'lurah']],
                        ['label' => 'Hero Banner', 'route' => 'admin.hero-banner.index', 'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z', 'roles' => ['super_admin', 'staf']],
                        ['label' => 'Inbox Pengaduan', 'route' => 'admin.pengaduan.index', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'roles' => ['super_admin', 'staf', 'lurah']],
                        ['label' => 'Layanan Surat', 'route' => 'admin.layanan-surat.index', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'roles' => ['super_admin', 'staf', 'lurah']],
                        ['label' => 'Janji Temu', 'route' => 'admin.janji-temu.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'roles' => ['super_admin', 'staf', 'lurah']],
                        ['label' => 'Galeri', 'route' => 'admin.galeri.index', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'roles' => ['super_admin', 'staf']],
                        ['label' => 'Agenda', 'route' => 'admin.agenda.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'roles' => ['super_admin', 'staf']],
                        ['label' => 'Anggaran', 'route' => 'admin.anggaran.index', 'icon' => 'M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m-2 9h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'roles' => ['super_admin', 'lurah']],
                        ['label' => 'Reset Password', 'route' => 'admin.password-reset.index', 'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z', 'roles' => ['super_admin']],
                        ['label' => 'Manajemen Pengguna', 'route' => 'admin.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'roles' => ['super_admin']],
                        ['label' => 'Pengaturan', 'route' => 'admin.pengaturan.index', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'roles' => ['super_admin']],
                        ['label' => 'Tentang KKN', 'route' => 'admin.tentang-kkn.index', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6L3.16 9m8.84 5L20.84 9', 'roles' => ['super_admin', 'staf', 'lurah']],
                    ])->filter(fn ($menu) => in_array($userRole, $menu['roles']));
                @endphp

                @foreach ($menus as $menu)
                    @php
                        $hasRoute = Route::has($menu['route']);
                        $routeUrl = $hasRoute ? route($menu['route']) : '#';
                        $pattern = str_contains($menu['route'], '.index')
                            ? str_replace('.index', '*', $menu['route'])
                            : $menu['route'];
                        $isActive = request()->routeIs($pattern);
                    @endphp

                    <a href="{{ $routeUrl }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                       {{ $isActive ? 'bg-emerald-600 text-white' : 'hover:bg-white/5 hover:text-white' }}
                       {{ !$hasRoute ? 'opacity-50 cursor-not-allowed' : '' }}"
                       @if(!$hasRoute) title="Route belum dikonfigurasi" @endif>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $menu['icon'] }}"/>
                        </svg>
                        {{ $menu['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- FOOTER SIDEBAR / LOGOUT --}}
            <div class="px-3 py-4 border-t border-white/10 shrink-0">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-red-500/10 hover:text-red-400 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/40 z-20 lg:hidden"></div>

        {{-- ============ MAIN CONTENT ============ --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="font-semibold text-slate-800 text-base">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-xs font-bold select-none">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-slate-600 hidden sm:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </header>

            {{-- Flash Notification --}}
            @if (session('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     class="mx-4 sm:mx-6 mt-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 font-bold ml-3">&times;</button>
                </div>
            @endif

            <main class="flex-1 p-4 sm:p-6 relative z-0">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

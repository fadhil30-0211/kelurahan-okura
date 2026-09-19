{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">

    {{-- ============ WELCOME BANNER & ACTION ============ --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-emerald-900/10">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                {{-- BADGE TANGGAL & JAM REALTIME --}}
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-medium bg-white/20 backdrop-blur-md text-emerald-50 mb-3 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                    <span class="text-emerald-200/60">•</span>
                    <span id="realtime-clock" class="font-mono font-semibold tracking-wider text-white">00:00:00 WIB</span>
                </span>

                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Selamat Datang, Admin 👋</h1>
                <p class="text-emerald-100 text-sm mt-1 max-w-xl">
                    Berikut adalah ringkasan aktivitas pengaduan, permohonan surat, dan data layanan kelurahan hari ini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.pengaduan.index') }}" class="px-4 py-2.5 rounded-xl bg-white text-emerald-800 text-xs font-semibold shadow-sm hover:bg-emerald-50 transition active:scale-95">
                    Kelola Pengaduan
                </a>
                <a href="{{ route('admin.layanan-surat.index') }}" class="px-4 py-2.5 rounded-xl bg-emerald-800/40 text-white border border-white/20 text-xs font-semibold hover:bg-emerald-800/60 transition active:scale-95">
                    Permohonan Surat
                </a>
            </div>
        </div>
        {{-- Hiasan Background --}}
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute right-40 -top-10 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm">
            <span class="text-lg">✅</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ============ STATISTIK CARDS ============ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Card 1: Aduan --}}
        <a href="{{ route('admin.pengaduan.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Aduan Masuk</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    📢
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ number_format($summary['pengaduan_masuk'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center justify-between text-xs mt-2 text-slate-500">
                    <span>Sedang diproses</span>
                    <span class="font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">
                        {{ $summary['pengaduan_proses'] ?? 0 }}
                    </span>
                </div>
            </div>
        </a>

        {{-- Card 2: Surat --}}
        <a href="{{ route('admin.layanan-surat.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Surat Diajukan</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    📄
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ number_format($summary['surat_diajukan'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center justify-between text-xs mt-2 text-slate-500">
                    <span>Sedang diproses</span>
                    <span class="font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md">
                        {{ $summary['surat_proses'] ?? 0 }}
                    </span>
                </div>
            </div>
        </a>

        {{-- Card 3: Berita --}}
        <a href="{{ route('admin.berita.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Berita Kelurahan</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    📰
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ number_format($summary['total_berita'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center justify-between text-xs mt-2 text-slate-500">
                    <span>Telah terbit</span>
                    <span class="font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                        {{ $summary['berita_published'] ?? 0 }}
                    </span>
                </div>
            </div>
        </a>

        {{-- Card 4: Potensi Desa --}}
        <a href="{{ route('admin.wisata.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 block">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Wisata & UMKM</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    🏪
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ number_format(($summary['total_wisata'] ?? 0) + ($summary['total_umkm'] ?? 0), 0, ',', '.') }}
                </p>
                <div class="flex items-center justify-between text-xs mt-2 text-slate-500">
                    <span>Rincian</span>
                    <span class="font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md">
                        {{ $summary['total_wisata'] ?? 0 }} Wisata / {{$summary['total_umkm'] ?? 0 }} UMKM
                    </span>
                </div>
            </div>
        </a>

    </div>

    {{-- ============ GRAFIK & DIAGRAM ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-slate-800">Tren Pengaduan Masuk</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik pergerakan laporan warga 7 hari terakhir</p>
                </div>
                <span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">Mingguan</span>
            </div>
            <div class="relative h-64">
                <canvas id="chartAduan"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Kategori Aduan</h3>
                <p class="text-xs text-slate-400 mt-0.5 mb-4">Persentase berdasarkan topik masalah</p>
            </div>
            <div class="relative h-56 flex items-center justify-center">
                <canvas id="chartKategori"></canvas>
            </div>
        </div>
    </div>

    {{-- ============ AKTIVITAS TERBARU ============ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ tab: 'pengaduan' }">

        {{-- Header & Navigasi Tab --}}
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-slate-800 text-base">Aktivitas & Permohonan Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pantau laporan warga, pengajuan surat, dan janji temu terkini</p>
            </div>

            {{-- Button Tab Group --}}
            <div class="flex items-center p-1 bg-slate-200/60 rounded-xl self-start sm:self-auto text-xs font-semibold">
                <button @click="tab = 'pengaduan'"
                        :class="tab === 'pengaduan' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                    <span>📢</span> Pengaduan
                    <span class="px-1.5 py-0.5 text-[10px] bg-amber-100 text-amber-800 rounded-full font-bold">
                        {{ count($pengaduanTerbaru ?? []) }}
                    </span>
                </button>

                <button @click="tab = 'surat'"
                        :class="tab === 'surat' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                    <span>📄</span> Surat
                    <span class="px-1.5 py-0.5 text-[10px] bg-sky-100 text-sky-800 rounded-full font-bold">
                        {{ count($suratTerbaru ?? []) }}
                    </span>
                </button>

                <button @click="tab = 'janji'"
                        :class="tab === 'janji' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                    <span>🤝</span> Janji Temu
                    <span class="px-1.5 py-0.5 text-[10px] bg-purple-100 text-purple-800 rounded-full font-bold">
                        {{ count($janjiTemuTerbaru ?? []) }}
                    </span>
                </button>
            </div>
        </div>

        {{-- CONTENT TAB 1: PENGADUAN --}}
        <div x-show="tab === 'pengaduan'" class="divide-y divide-slate-100">
            @forelse ($pengaduanTerbaru ?? [] as $pengaduan)
                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="flex items-center justify-between p-4 hover:bg-slate-50/80 transition gap-4">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 font-bold text-sm">
                            📢
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">{{ $pengaduan->judul_aduan }}</p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mt-0.5">
                                <span>👤 {{ $pengaduan->nama_pelapor }}</span>
                                <span>•</span>
                                <span>🕒 {{ $pengaduan->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ method_exists($pengaduan, 'statusBadgeColor') ?$pengaduan->statusBadgeColor() : 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                        <span class="text-slate-300 text-xs">→</span>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center text-slate-400 text-xs">Belum ada pengaduan terbaru.</div>
            @endforelse

            <div class="p-3 bg-slate-50/50 text-center border-t border-slate-100">
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    Lihat Semua Pengaduan Masuk →
                </a>
            </div>
        </div>

        {{-- CONTENT TAB 2: SURAT --}}
        <div x-show="tab === 'surat'" x-cloak class="divide-y divide-slate-100">
            @forelse ($suratTerbaru ?? [] as $surat)
                <a href="{{ route('admin.layanan-surat.show', $surat) }}" class="flex items-center justify-between p-4 hover:bg-slate-50/80 transition gap-4">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 font-bold text-sm">
                            📄
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">{{ $surat->jenis_surat }}</p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mt-0.5">
                                <span>👤 {{ $surat->nama_pemohon }}</span>
                                <span>•</span>
                                <span>🕒 {{ $surat->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ method_exists($surat, 'statusBadgeColor') ?$surat->statusBadgeColor() : 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($surat->status) }}
                        </span>
                        <span class="text-slate-300 text-xs">→</span>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center text-slate-400 text-xs">Belum ada permohonan surat.</div>
            @endforelse

            <div class="p-3 bg-slate-50/50 text-center border-t border-slate-100">
                <a href="{{ route('admin.layanan-surat.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    Lihat Semua Permohonan Surat →
                </a>
            </div>
        </div>

        {{-- CONTENT TAB 3: JANJI TEMU --}}
        <div x-show="tab === 'janji'" x-cloak class="divide-y divide-slate-100">
            @forelse ($janjiTemuTerbaru ?? [] as $janjiTemu)
                <a href="{{ Route::has('admin.janji-temu.show') ? route('admin.janji-temu.show', $janjiTemu) : '#' }}" class="flex items-center justify-between p-4 hover:bg-slate-50/80 transition gap-4">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 font-bold text-sm">
                            🤝
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">
                                {{ $janjiTemu->nama_pemohon ?? $janjiTemu->nama ?? $janjiTemu->nama_tamu ?? 'Warga' }}
                            </p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mt-0.5">
                                <span>💬 {{ $janjiTemu->keperluan ?? 'Pertemuan Kelurahan' }}</span>
                                <span>•</span>
                                <span>📆 {{ isset($janjiTemu->tanggal_diinginkan) ? \Carbon\Carbon::parse($janjiTemu->tanggal_diinginkan)->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ method_exists($janjiTemu, 'statusBadgeColor') ?$janjiTemu->statusBadgeColor() : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                            {{ ucfirst($janjiTemu->status ?? 'Menunggu') }}
                        </span>
                        <span class="text-slate-300 text-xs">→</span>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center text-slate-400 text-xs">Belum ada permohonan janji temu.</div>
            @endforelse

            @if(Route::has('admin.janji-temu.index'))
                <div class="p-3 bg-slate-50/50 text-center border-t border-slate-100">
                    <a href="{{ route('admin.janji-temu.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                        Lihat Semua Janji Temu →
                    </a>
                </div>
            @endif
        </div>

    </div>

    {{-- ============ FORM EDIT PROFIL KELURAHAN ============ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
            <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-lg">🏢</span>
            <div>
                <h2 class="font-bold text-slate-800">Pengaturan Profil & Wilayah Kelurahan</h2>
                <p class="text-xs text-slate-400">Perbarui informasi umum, visi, misi, wilayah administrasi, serta peta lokasi kelurahan</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- INFORMASI ADMINISTRASI WILAYAH --}}
            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-100 space-y-4">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block">📍 Informasi Administrasi & Wilayah</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', $profil->kecamatan ?? '') }}" placeholder="Contoh: Rumbai Timur" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="kota" value="{{ old('kota', $profil->kota ?? '') }}" placeholder="Contoh: Pekanbaru" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Karakter Wilayah</label>
                        <input type="text" name="karakter_wilayah" value="{{ old('karakter_wilayah', $profil->karakter_wilayah ?? '') }}" placeholder="Contoh: Tepian Sungai" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- VISI & MISI KELURAHAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Visi Kelurahan</label>
                    <textarea name="visi" rows="5" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none" placeholder="Tuliskan visi kelurahan...">{{ old('visi', $profil->visi ?? '') }}</textarea>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Misi Kelurahan</label>
                        <span class="text-[11px] text-slate-400">Gunakan Enter untuk tiap poin</span>
                    </div>
                    <textarea name="misi" rows="5" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none" placeholder="Meningkatkan Kualitas SDM&#10;Meningkatkan Taraf Hidup Masyarakat&#10;Meningkatkan Infrastruktur">{{ old('misi', is_array($profil->misi ?? null) ? implode("\n", $profil->misi) : ($profil->misi ?? '')) }}</textarea>
                </div>
            </div>

            {{-- DESKRIPSI SEJARAH & POTENSI WILAYAH --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Sejarah Singkat</label>
                    <textarea name="deskripsi_sejarah" rows="4" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none" placeholder="Tuliskan gambaran umum kelurahan...">{{ old('deskripsi_sejarah', $profil->deskripsi_sejarah ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Potensi Wilayah</label>
                    <textarea name="potensi" rows="4" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none" placeholder="Contoh: Wisata & Budaya...">{{ old('potensi', $profil->potensi ?? '') }}</textarea>
                </div>
            </div>

            {{-- KOORDINAT DAN GEOJSON PETA --}}
            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-100 space-y-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">🗺️ Koordinat & GeoJSON Peta</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $profil->latitude ?? '') }}" placeholder="0.571246" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $profil->longitude ?? '') }}" placeholder="101.538890" class="w-full border border-slate-200 rounded-xl p-2.5 text-sm bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">File GeoJSON (Batas Wilayah)</label>
                    <input type="file" name="geojson_file" accept=".json,.geojson" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">

                    @if(!empty($profil->geojson_file))
                        <div class="mt-3 p-3 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2 text-slate-700 min-w-0">
                                <span>🗺️</span>
                                <span class="truncate">File aktif: <code class="font-mono text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold">{{ $profil->geojson_file }}</code></span>
                            </div>
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 font-medium cursor-pointer transition shrink-0">
                                <input type="checkbox" name="delete_geojson" value="1" class="rounded text-rose-600 focus:ring-rose-500 border-rose-300">
                                <span>Hapus File</span>
                            </label>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-all shadow-md shadow-emerald-600/20 active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // 1. Fungsi Jam Realtime
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const clockElement = document.getElementById('realtime-clock');
        if (clockElement) {
            clockElement.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    // 2. Chart Line (Pengaduan)
    new Chart(document.getElementById('chartAduan'), {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Aduan Masuk',
                data: @json($chartData ?? []),
                borderColor: '#059669',
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                    gradient.addColorStop(0, 'rgba(5, 150, 105, 0.25)');
                    gradient.addColorStop(1, 'rgba(5, 150, 105, 0.0)');
                    return gradient;
                },
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#059669',
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { borderDash: [2, 4] } }
            }
        }
    });

    // 3. Chart Doughnut (Kategori)
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: @json(isset($kategoriAduan) ?$kategoriAduan->keys() : []),
            datasets: [{
                data: @json(isset($kategoriAduan) ?$kategoriAduan->values() : []),
                backgroundColor: ['#059669', '#D97706', '#0284C7', '#DC2626', '#8B5CF6'],
                borderWidth: 3,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 15, font: { size: 11 } }
                }
            },
            cutout: '70%',
        }
    });
</script>
@endpush

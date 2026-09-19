{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

    {{-- ============ BANNER WELCOME ============ --}}
    <div class="relative bg-emerald-600 text-white rounded-2xl p-6 shadow-sm overflow-hidden z-10">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                    Selamat Datang, Admin 👋
                </h2>
                <p class="text-emerald-100 text-xs md:text-sm mt-1">
                    Berikut adalah ringkasan aktivitas pengaduan, permohonan surat, dan data layanan kelurahan hari ini.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">
                {{-- Tanggal Real-Time Otomatis --}}
                <div class="px-3.5 py-2 bg-emerald-700/50 text-white text-xs font-medium rounded-xl border border-emerald-500/30 backdrop-blur-sm flex items-center gap-1.5">
                    <span>📅</span>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <a href="{{ route('admin.pengaduan.index') }}" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl backdrop-blur-sm transition">
                    Kelola Pengaduan
                </a>
                <a href="{{ route('admin.layanan-surat.index') }}" class="px-3.5 py-2 bg-white text-emerald-700 hover:bg-emerald-50 text-xs font-semibold rounded-xl shadow-sm transition">
                    Permohonan Surat
                </a>
            </div>
        </div>

        {{-- Hiasan Lingkaran --}}
        <div class="absolute -right-6 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

    {{-- ============ SUMMARY CARDS ============ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Aduan Baru', 'value' => $summary['pengaduan_masuk'], 'sub' => $summary['pengaduan_proses'].' sedang diproses', 'color' => 'bg-amber-50 text-amber-700', 'route' => 'admin.pengaduan.index'],
                ['label' => 'Surat Diajukan', 'value' => $summary['surat_diajukan'], 'sub' => $summary['surat_proses'].' sedang diproses', 'color' => 'bg-sky-50 text-sky-700', 'route' => 'admin.layanan-surat.index'],
                ['label' => 'Berita', 'value' => $summary['total_berita'], 'sub' => $summary['berita_published'].' sudah publish', 'color' => 'bg-emerald-50 text-emerald-700', 'route' => 'admin.berita.index'],
                ['label' => 'Wisata & UMKM', 'value' => $summary['total_wisata'] + $summary['total_umkm'], 'sub' => $summary['total_wisata'].' wisata, '.$summary['total_umkm'].' UMKM', 'color' => 'bg-rose-50 text-rose-700', 'route' => 'admin.wisata.index'],
            ];
        @endphp

        @foreach ($cards as $card)
            <a href="{{ route($card['route']) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-md p-4 border border-slate-100 transition">
                <div class="w-9 h-9 rounded-xl {{ $card['color'] }} flex items-center justify-center text-sm font-bold mb-2.5">
                    {{ $card['value'] }}
                </div>
                <p class="text-sm font-semibold text-slate-800">{{ $card['label'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $card['sub'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- ============ CHARTS ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-5 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-3 text-sm">Aduan Masuk (7 Hari Terakhir)</h3>
            <canvas id="chartAduan" height="90"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-3 text-sm">Kategori Aduan</h3>
            <canvas id="chartKategori" height="200"></canvas>
        </div>
    </div>

    {{-- ============ TABEL TERBARU (Pengaduan, Surat, Janji Temu) ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Widget 1: Pengaduan Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-800 text-xs tracking-wide uppercase">📢 Pengaduan Terbaru</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="text-[11px] text-emerald-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse ($pengaduanTerbaru as $item)
                    <a href="{{ route('admin.pengaduan.show', $item) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50 transition">
                        <div class="min-w-0 pr-2">
                            <p class="text-xs font-semibold text-slate-700 truncate">{{ $item->judul_aduan }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->nama_pelapor }} · {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada pengaduan masuk.</p>
                @endforelse
            </div>
        </div>

        {{-- Widget 2: Pengajuan Surat Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-800 text-xs tracking-wide uppercase">📄 Pengajuan Surat</h3>
                <a href="{{ route('admin.layanan-surat.index') }}" class="text-[11px] text-emerald-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse ($suratTerbaru as $item)
                    <a href="{{ route('admin.layanan-surat.show', $item) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50 transition">
                        <div class="min-w-0 pr-2">
                            <p class="text-xs font-semibold text-slate-700 truncate">{{ $item->jenis_surat }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->nama_pemohon }} · {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada pengajuan surat.</p>
                @endforelse
            </div>
        </div>

        {{-- Widget 3: Janji Temu Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-800 text-xs tracking-wide uppercase">🤝 Janji Temu</h3>
                <a href="{{ route('admin.janji-temu.index') ?? '#' }}" class="text-[11px] text-emerald-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse ($janjiTemuTerbaru ?? [] as $item)
                    <a href="{{ route('admin.janji-temu.show', $item) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50 transition">
                        <div class="min-w-0 pr-2">
                            <p class="text-xs font-semibold text-slate-700 truncate">{{ $item->keperluan ?? 'Pertemuan Kelurahan' }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->nama_tamu ?? $item->nama }} · {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium flex-shrink-0 bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ ucfirst($item->status ?? 'Menunggu') }}
                        </span>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada janji temu.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ============ FORM PENGATURAN PROFIL & WILAYAH ============ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
            <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 text-base">🏢</span>
            <div>
                <h2 class="font-bold text-slate-800 text-sm">Pengaturan Profil & Wilayah Kelurahan</h2>
                <p class="text-xs text-slate-400">Kelola data administrasi, visi, deskripsi, karakter wilayah, potensi, serta koordinat peta kelurahan</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- SECTION 1: INFORMASI ADMINISTRASI & WILAYAH --}}
            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-100 space-y-3">
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">📍 Informasi Administrasi & Karakter Wilayah</span>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Kecamatan</label>
                        <input type="text" name="kecamatan"
                            value="{{ old('kecamatan', $profil->kecamatan ?? '') }}"
                            placeholder="Contoh: Rumbai Timur"
                            class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="kota"
                            value="{{ old('kota', $profil->kota ?? '') }}"
                            placeholder="Contoh: Kota Pekanbaru"
                            class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Karakter Wilayah</label>
                        <input type="text" name="karakter_wilayah"
                            value="{{ old('karakter_wilayah', $profil->karakter_wilayah ?? '') }}"
                            placeholder="Contoh: Pesisir Sungai, Agrowisata"
                            class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: VISI, SEJARAH, DAN POTENSI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Visi Kelurahan</label>
                    <textarea name="visi" rows="4"
                        class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none"
                        placeholder="Masukkan Visi Kelurahan...">{{ old('visi', $profil->visi ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Sejarah Singkat</label>
                    <textarea name="deskripsi_sejarah" rows="4"
                        class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none"
                        placeholder="Masukkan Sejarah atau Gambaran Umum Kelurahan...">{{ old('deskripsi_sejarah', $profil->deskripsi_sejarah ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Potensi Wilayah</label>
                    <textarea name="potensi" rows="4"
                        class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition focus:outline-none"
                        placeholder="Tuliskan potensi unggulan (Contoh: Agrowisata, Perikanan, Wisata Budaya)...">{{ old('potensi', $profil->potensi ?? '') }}</textarea>
                </div>
            </div>

            {{-- SECTION 3: KOORDINAT & FILE GEOJSON --}}
            <div class="p-4 bg-slate-50/50 rounded-2xl border border-slate-100 space-y-3">
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">🗺️ Koordinat & GeoJSON Peta Wilayah</span>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Latitude</label>
                        <input type="text" name="latitude"
                            value="{{ old('latitude', $profil->latitude ?? '') }}"
                            placeholder="Contoh: 0.571246"
                            class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Longitude</label>
                        <input type="text" name="longitude"
                            value="{{ old('longitude', $profil->longitude ?? '') }}"
                            placeholder="Contoh: 101.538890"
                            class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Upload File GeoJSON (Batas Wilayah)</label>
                    <input type="file" name="geojson_file" accept=".json,.geojson"
                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                    @if(!empty($profil->geojson_file))
                        <p class="text-[11px] text-emerald-600 mt-1">✓ File GeoJSON aktif: <code>{{ $profil->geojson_file }}</code></p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2 rounded-xl text-xs transition-all shadow-md shadow-emerald-600/20 active:scale-95">
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
    new Chart(document.getElementById('chartAduan'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Aduan',
                data: @json($chartData),
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: @json($kategoriAduan->keys()),
            datasets: [{
                data: @json($kategoriAduan->values()),
                backgroundColor: ['#059669', '#D97706', '#0284C7', '#DC2626', '#7C3AED'],
                borderWidth: 0,
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });
</script>
@endpush

@extends('layouts.frontend')
@section('title', 'Profil Kelurahan - ' . ($profil->nama_kelurahan ?? 'Tebing Tinggi Okura'))

@section('content')
<section class="pt-28 pb-16 bg-[#FAFBFB]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- Header Profil --}}
        <div class="text-center mb-12">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#009B3A]/10 text-[#009B3A] text-xs sm:text-sm font-semibold mb-4">
                Profil Kelurahan
            </span>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#151515] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                {{ $profil->nama_kelurahan ?? 'Tebing Tinggi Okura' }}
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Mengenal sejarah, visi, misi, kondisi geografis, dan struktur pemerintahan Kelurahan {{ $profil->nama_kelurahan ?? 'Tebing Tinggi Okura' }}.
            </p>
        </div>

        {{-- Visi & Misi --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-14 items-stretch">

            {{-- Visi --}}
            <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-[#009B3A] p-8 sm:p-10 text-white shadow-lg flex flex-col justify-between">
                <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-16 w-48 h-48 rounded-full bg-[#FFE600]/10 pointer-events-none"></div>

                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-white/80">
                        <span class="w-2 h-2 rounded-full bg-[#FFE600]"></span>
                        Visi Kelurahan
                    </span>

                    {{-- Menampilkan Visi dengan Penanganan Baris Baru (Enter) --}}
                    <div class="mt-6 space-y-4">
                        @php
                            $defaultVisi = "Terwujudnya Kelurahan Tebing Tinggi Okura sebagai Pusat Pariwisata, Pertanian, Perikanan dan Pusat Kebudayaan Melayu di Kota Pekanbaru.\n\nMenuju masyarakat sejahtera berdasarkan iman dan taqwa.";
                            $visiText = !empty($profil->visi) ? $profil->visi : $defaultVisi;
                            $visiParagraphs = array_filter(explode("\n", str_replace("\r", '', $visiText)));
                        @endphp

                        @foreach($visiParagraphs as $paragraph)
                            @if(trim($paragraph) !== '')
                                <h2 class="text-xl sm:text-2xl font-bold leading-snug">
                                    {{ trim($paragraph) }}
                                </h2>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Misi --}}
            <div class="lg:col-span-3 rounded-3xl bg-white border border-slate-200 p-8 sm:p-10 shadow-sm">
                <span class="text-[#E31E24] text-xs font-semibold uppercase tracking-wider">
                    Misi Kelurahan
                </span>

                <h2 class="mt-3 text-2xl sm:text-3xl font-bold text-[#151515]">
                    Langkah Menuju Visi
                </h2>

                <div class="mt-7 space-y-6">
                    @php
                        $misiItems = [];
                        if (!empty($profil->misi)) {
                            if (is_array($profil->misi)) {
                                $misiItems = $profil->misi;
                            } elseif (is_string($profil->misi)) {
                                $misiItems = array_filter(explode("\n", str_replace("\r", '', $profil->misi)));
                            }
                        } else {
                            $misiItems = [
                                [
                                    'title' => 'Meningkatkan Kualitas Sumber Daya Manusia',
                                    'desc'  => 'Meningkatkan kualitas sumber daya manusia melalui pembangunan sektor pendidikan, kesehatan, pariwisata, pertanian, perikanan dan kebudayaan.'
                                ],
                                [
                                    'title' => 'Meningkatkan Taraf Hidup Masyarakat',
                                    'desc'  => 'Meningkatkan taraf hidup masyarakat melalui program pemberdayaan masyarakat dan pengembangan ekonomi kreatif.'
                                ],
                                [
                                    'title' => 'Meningkatkan Infrastruktur',
                                    'desc'  => 'Meningkatkan infrastruktur melalui peningkatan sarana dan prasarana.'
                                ]
                            ];
                        }

                        $badgeStyles = [
                            ['bg' => 'bg-[#009B3A]/10', 'text' => 'text-[#009B3A]'],
                            ['bg' => 'bg-[#FFE600]/20', 'text' => 'text-[#8A7600]'],
                            ['bg' => 'bg-[#E31E24]/10', 'text' => 'text-[#E31E24]'],
                        ];
                    @endphp

                    @php $index = 0; @endphp
                    @foreach($misiItems as $item)
                        @php
                            if (is_array($item)) {
                                $title = $item['title'] ?? ($item['judul'] ?? ($item[0] ?? ''));
                                $desc  = $item['desc'] ?? ($item['keterangan'] ?? ($item[1] ?? ''));
                            } else {
                                if (str_contains($item, ':')) {
                                    $parts = explode(':', $item, 2);
                                    $title = trim($parts[0]);
                                    $desc  = trim($parts[1]);
                                } elseif (str_contains($item, ' - ')) {
                                    $parts = explode(' - ', $item, 2);
                                    $title = trim($parts[0]);
                                    $desc  = trim($parts[1]);
                                } else {
                                    $title = trim($item);
                                    $desc  = '';
                                }
                            }

                            $style = $badgeStyles[$index % count($badgeStyles)];
                            $index++;
                        @endphp

                        <div class="flex gap-4">
                            <span class="shrink-0 flex items-center justify-center w-9 h-9 rounded-full {{ $style['bg'] }} {{ $style['text'] }} font-bold text-sm">
                                {{ sprintf('%02d', $index) }}
                            </span>

                            <div>
                                <h3 class="font-semibold text-slate-800">
                                    {{ $title }}
                                </h3>

                                @if(!empty($desc))
                                    <p class="mt-1 text-sm text-slate-500 leading-relaxed">
                                        {{ $desc }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Sejarah & Geografis --}}
        <div class="mb-14">
            <div class="mb-6">
                <span class="text-[#009B3A] text-xs sm:text-sm font-semibold uppercase tracking-wider">
                    Informasi Wilayah
                </span>

                <h2 class="mt-2 text-3xl font-bold text-[#151515]">
                    Sejarah & Geografis
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

                {{-- Informasi --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-[#151515]">
                            Tentang {{ $profil->nama_kelurahan ?? 'Tebing Tinggi Okura' }}
                        </h3>

                        <p class="mt-4 text-sm sm:text-base text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $profil->deskripsi_sejarah ?? 'Kelurahan Tebing Tinggi Okura merupakan salah satu kelurahan di Kecamatan Rumbai Timur, Kota Pekanbaru, yang terletak di tepian Sungai Siak dengan potensi alam dan budaya yang khas.' }}
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-[#009B3A]/10 p-5">
                            <p class="text-xs text-slate-500">Kecamatan</p>
                            <p class="mt-1 font-semibold text-[#009B3A]">
                                {{ $profil->kecamatan ?? 'Rumbai Timur' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#FFE600]/15 p-5">
                            <p class="text-xs text-slate-500">Kota/kabupaten</p>
                            <p class="mt-1 font-semibold text-[#8A7600]">
                                {{ $profil->kota ?? 'Pekanbaru' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#009B3A]/10 p-5">
                            <p class="text-xs text-slate-500">Karakter Wilayah</p>
                            <p class="mt-1 font-semibold text-slate-800">
                                {{ $profil->karakter_wilayah ?? 'Tepian Sungai' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#E31E24]/10 p-5">
                            <p class="text-xs text-slate-500">Potensi</p>
                            <p class="mt-1 font-semibold text-[#E31E24]">
                                {{ $profil->potensi ?? 'Alam & Budaya' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Peta --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between px-4 pt-3 pb-4">
                        <div>
                            <p class="text-xs text-[#009B3A] font-semibold uppercase tracking-wider">
                                Lokasi
                            </p>

                            <h3 class="mt-1 text-lg font-bold text-[#151515]">
                                Peta Wilayah
                            </h3>
                        </div>
                    </div>

                    <div id="peta-profil" class="w-full h-[360px] rounded-2xl overflow-hidden bg-slate-100 border border-slate-100"></div>
                </div>

            </div>
        </div>

        {{-- Struktur Organisasi --}}
        <div class="mb-10">
            <div class="mb-6 text-center">
                <span class="text-[#009B3A] text-xs sm:text-sm font-semibold uppercase tracking-wider">
                    Pemerintahan Kelurahan
                </span>

                <h2 class="mt-2 text-3xl font-bold text-[#151515]">
                    Struktur Organisasi
                </h2>

                <p class="mt-3 max-w-2xl mx-auto text-sm text-slate-500 leading-relaxed">
                    Struktur perangkat Kelurahan {{ $profil->nama_kelurahan ?? 'Tebing Tinggi Okura' }} dalam mendukung pelayanan dan penyelenggaraan pemerintahan kepada masyarakat.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @forelse ($pegawais as $pegawai)
                    <div class="group bg-white rounded-3xl border border-slate-200 p-5 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            <div class="absolute inset-0 rounded-full bg-[#009B3A]/10 scale-110 group-hover:scale-125 transition-transform duration-300"></div>

                            <img
                                src="{{ $pegawai->foto ? asset('storage/'.$pegawai->foto) : asset('images/avatar-placeholder.jpg') }}"
                                alt="{{ $pegawai->nama }}"
                                class="relative z-10 w-24 h-24 rounded-full object-cover border-4 border-white shadow-md"
                            >
                        </div>

                        <h3 class="text-sm sm:text-base font-semibold text-slate-800">
                            {{ $pegawai->nama }}
                        </h3>

                        <p class="mt-1 text-xs sm:text-sm text-[#009B3A] font-medium">
                            {{ $pegawai->jabatan }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-full bg-slate-50 rounded-3xl border border-dashed border-slate-300 py-12 text-center">
                        <div class="text-4xl mb-3">👤</div>
                        <h3 class="text-sm font-semibold text-slate-700">Data struktur organisasi belum tersedia</h3>
                        <p class="mt-1 text-xs text-slate-500">Data pegawai akan ditampilkan setelah tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapElement = document.getElementById('peta-profil');
        if (!mapElement) return;

        const lat = {{ $profil->latitude ?? 0.5712465050879031 }};
        const lng = {{ $profil->longitude ?? 101.53889059635989 }};
        const kantorLurah = [lat, lng];

        const map = L.map('peta-profil').setView(kantorLurah, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker(kantorLurah)
            .addTo(map)
            .bindPopup('<b>Kantor Lurah {{ $profil->nama_kelurahan ?? "Tebing Tinggi Okura" }}</b>');

        setTimeout(() => { map.invalidateSize(); }, 300);

        @if(!empty($profil->geojson_file))
            fetch('{{ asset("storage/" . $profil->geojson_file) }}')
                .then(response => {
                    if (!response.ok) throw new Error('File GeoJSON tidak ditemukan.');
                    return response.json();
                })
                .then(data => {
                    const batasWilayah = L.geoJSON(data, {
                        style: {
                            color: '#059669',
                            weight: 3,
                            fillColor: '#10B981',
                            fillOpacity: 0.12
                        }
                    }).addTo(map);

                    map.fitBounds(batasWilayah.getBounds(), { padding: [20, 20] });
                })
                .catch(error => console.error('Peta Error:', error));
        @endif
    });
</script>
@endpush

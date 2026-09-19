@extends('layouts.admin')

<style>
    .kkn-card {
        position: relative;
        min-height: 320px; /* Gunakan min-height alih-alih height kaku */
        height: auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
        transition: box-shadow 0.35s ease;
        overflow: visible;
        z-index: 1;
    }

    .kkn-card:hover {
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
        z-index: 50;
    }

    /* Area visual */
    .kkn-visual {
        position: relative;
        height: 155px;
        overflow: visible;
    }

    /* Frame */
    .kkn-frame {
        position: absolute;
        left: 50%;
        bottom: 0;

        width: 120px;
        height: 135px;

        transform: translateX(-50%);

        border: 6px solid #ffffff;
        border-radius: 18px;

        background: linear-gradient(
            145deg,
            #ecfdf5,
            #f8fafc
        );

        box-shadow:
            0 8px 18px rgba(15, 23, 42, 0.10),
            inset 0 0 0 2px #d1fae5;

        z-index: 1;
    }

    .kkn-frame::after {
        content: "";
        position: absolute;
        inset: 7px;

        border-radius: 11px;
        border: 2px solid #d1fae5;

        pointer-events: none;
    }

    /* Foto orang */
    .kkn-person {
        position: absolute;

        left: 50%;
        bottom: 0;

        width: 165px;
        height: 195px;

        transform:
            translateX(-50%)
            translateY(0)
            scale(var(--photo-scale, 1));

        transform-origin: center bottom;

        object-fit: contain;
        object-position: center bottom;

        display: block;

        z-index: 2;
        pointer-events: none;

        filter:
            drop-shadow(0 8px 12px rgba(0, 0, 0, 0.14));

        will-change:
            transform,
            filter;

        transition:
            transform 700ms cubic-bezier(.22, 1, .36, 1),
            filter 700ms ease;
    }

    /* POP OUT */
    .kkn-card:hover .kkn-person {
        transform:
            translateX(-50%)
            translateY(-35px)
            scale(var(--photo-hover-scale, var(--photo-scale, 1)));

        filter:
            drop-shadow(0 24px 30px rgba(0, 0, 0, 0.24));
    }

    /* Informasi */
    .kkn-info {
        position: relative;

        margin-top: 0;

        padding: 0 16px 24px;

        text-align: center;

        z-index: 10;

        background: #ffffff;
    }

    .kkn-info h3 {
        position: relative;
        z-index: 11;
    }

    .kkn-info p,
    .kkn-info span {
        position: relative;
        z-index: 11;
    }

    /* Placeholder */
    .kkn-placeholder {
        position: absolute;

        left: 50%;
        bottom: 35px;

        width: 72px;
        height: 72px;

        transform: translateX(-50%);

        border-radius: 50%;
        background: #ecfdf5;

        border: 4px solid #ffffff;

        box-shadow:
            0 8px 16px rgba(15, 23, 42, 0.08);

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 2;
    }
</style>

@section('page-title', 'Tentang KKN')

@section('content')

<div class="max-w-6xl space-y-8 mx-auto px-4 sm:px-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Tentang KKN
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Dokumentasi dan pertinggalan kegiatan KKN di Kelurahan Tebing Tinggi Okura.
        </p>
    </div>

    {{-- Identitas --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-6 mt-3 mb-3">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6 text-center lg:text-left">

            <div class="flex flex-col sm:flex-row items-center gap-5">
                <img
                    src="{{ asset('storage/logo2.png') }}"
                    alt="Logo Kelurahan"
                    class="w-20 h-20 sm:w-24 sm:h-24 object-contain shrink-0">

                <div>
                    <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold">
                        Lokasi KKN
                    </p>

                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mt-1">
                        Kelurahan Tebing Tinggi Okura
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Kecamatan Rumbai Timur, Kota Pekanbaru
                    </p>
                </div>
            </div>

            <div class="lg:ml-auto">
                <span class="inline-flex px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold">
                    KKN 2026
                </span>
            </div>

        </div>
    </div>

    {{-- Tentang --}}
    <div class="grid lg:grid-cols-2 gap-6 mb-3">

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-slate-800">
                Tentang Kegiatan
            </h2>

            <p class="text-sm leading-relaxed text-slate-500 mt-4">
                Kegiatan Kuliah Kerja Nyata merupakan bentuk kontribusi
                mahasiswa kepada masyarakat melalui program kerja yang
                disesuaikan dengan kebutuhan lingkungan tempat pelaksanaan KKN.
            </p>

            <p class="text-sm leading-relaxed text-slate-500 mt-4">
                Salah satu kontribusi yang diwujudkan adalah pengembangan
                website Kelurahan Tebing Tinggi Okura sebagai media informasi
                dan pendukung pelayanan masyarakat.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Sebuah Pertinggalan
                </h2>

                <p class="text-sm leading-relaxed text-slate-500 mt-4">
                    Website ini menjadi salah satu bentuk pertinggalan dari
                    kegiatan KKN kami. Harapannya, website ini dapat terus
                    digunakan, dikembangkan, dan memberikan manfaat bagi
                    Kelurahan Tebing Tinggi Okura.
                </p>
            </div>

            <div class="mt-5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-100">
                <p class="text-sm text-emerald-800 font-medium">
                    “Sebuah kontribusi kecil yang kami tinggalkan,
                    semoga dapat terus memberikan manfaat.”
                </p>
            </div>
        </div>

    </div>

    {{-- Tim --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-6 mb-3">

        <div class="mb-6">
            <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold">
                Orang-Orang di Balik Kegiatan
            </p>

            <h2 class="text-xl font-bold text-slate-800 mt-1">
                Tim KKN
            </h2>
        </div>

        @php
            $timKkn = [
                [
                    'nama' => 'M. Adam Hidayat',
                    'nim' => '2417052802069',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/adam-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'M. Rafa Fathira Bumi',
                    'nim' => '2417052802047',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/rafa-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'Fahmi Putra Alamsyah',
                    'nim' => '2417052802044',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/fahmi-clear.png',
                    'scale' => 0.90,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'Recika Rizanti',
                    'nim' => '2417052705007',
                    'prodi' => 'Manajemen Bisnis International',
                    'foto' => 'profil/cika-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'Fadhil Ramadhan',
                    'nim' => '2417052802104',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/fadhilr.png',
                    'scale' => 0.90,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'M Daffa Mulia Nazma',
                    'nim' => '2417052802037',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/daffa-clear.png',
                    'scale' => 1.05,
                    'hover_scale' => 1.38,
                ],
                [
                    'nama' => 'Fadil Maulanan Fatah',
                    'nim' => '2417052802071',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/fadilm.png',
                    'scale' => 0.90,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'Bunga Shakila Azhela Gari',
                    'nim' => '2417052802048',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/Bunga-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.20,
                ],
                [
                    'nama' => 'Andika Wahyu Saputra',
                    'nim' => '2417052802051',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/andika-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'Fatahillah Sandy Ramadhan',
                    'nim' => '2417052801008',
                    'prodi' => 'Informatika Medis',
                    'foto' => 'profil/rama-clear.png',
                    'scale' => 0.90,
                    'hover_scale' => 1.28,
                ],
                [
                    'nama' => 'M Wahyu Ramadhan',
                    'nim' => '2417052802063',
                    'prodi' => 'Teknik Informatika',
                    'foto' => 'profil/wahyu-clear.png',
                    'scale' => 1.00,
                    'hover_scale' => 1.30,
                ],
                [
                    'nama' => 'Ayunda Sri Lestari',
                    'nim' => '2417052806022',
                    'prodi' => 'Sistem Informasi',
                    'foto' => 'profil/serik-clear.png',
                    'scale' => 0.90,
                    'hover_scale' => 1.20,
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">

        @foreach ($timKkn as $anggota)

            <div class="kkn-card">

                {{-- FOTO + FRAME --}}
                <div class="kkn-visual">

                    {{-- Frame --}}
                    <div class="kkn-frame"></div>

                    {{-- Foto --}}
                    @if (!empty($anggota['foto']))

                        <img
                            src="{{ asset('storage/' . $anggota['foto']) }}"
                            alt="{{ $anggota['nama'] }}"
                            class="kkn-person
                                absolute
                                left-1/2
                                top-0
                                z-20
                                w-[165px]
                                h-[205px]
                                object-contain
                                object-bottom
                                block"
                            style="
                                --photo-scale: {{ $anggota['scale'] ?? 1 }};
                                --photo-hover-scale: {{ $anggota['hover_scale'] ?? ($anggota['scale'] ?? 1) }};
                            ">

                    @else

                        <div class="kkn-placeholder">

                            <svg
                                class="w-8 h-8 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>

                            </svg>

                        </div>

                    @endif

                </div>

                {{-- INFORMASI --}}
                <div
                    class="kkn-info relative
                        mx-3
                        px-4 py-4
                        text-center
                        bg-white/95
                        backdrop-blur-sm
                        rounded-2xl
                        shadow-sm
                        z-30">

                    <h3 class="font-bold text-base text-slate-800 leading-snug">
                        {{ $anggota['nama'] }}
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        {{ $anggota['nim'] }}
                    </p>

                    <span
                        class="inline-flex mt-3
                            px-4 py-1.5
                            rounded-full
                            bg-slate-50
                            text-slate-500
                            text-xs font-semibold">

                        {{ $anggota['prodi'] }}

                    </span>

                </div>

            </div>

        @endforeach

        </div>

    </div>

   {{-- Pengembang --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">

            <div class="text-center lg:text-left">
                <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold">
                    Pengembangan Sistem
                </p>

                <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mt-1">
                    Pengembang Website
                </h2>

                <p class="text-slate-500 mt-3 sm:mt-4 text-xs sm:text-sm leading-relaxed">
                    Website ini dikembangkan sebagai bagian dari program kerja
                    KKN untuk mendukung digitalisasi informasi dan pelayanan
                    di Kelurahan Tebing Tinggi Okura.
                </p>
            </div>

            <div class="flex flex-wrap justify-center lg:justify-end gap-3 sm:gap-4 items-center">
                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center p-3 sm:p-4 shrink-0">
                    <img
                        src="{{ asset('storage/logo2.png') }}"
                        alt="Logo Kelurahan"
                        class="w-full h-full object-contain">
                </div>

                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center p-3 sm:p-4 shrink-0">
                    <img
                        src="{{ asset('storage/logo/Logo gokura.png') }}"
                        alt="Logo KKN"
                        class="w-full h-full object-contain">
                </div>

                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center p-3 sm:p-4 shrink-0">
                    <img
                        src="{{ asset('storage/logo/logo usti.png') }}"
                        alt="Logo Kampus"
                        class="w-full h-full object-contain">
                </div>
            </div>

        </div>

    </div>

    {{-- Penutup --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-50 to-yellow-50 border border-emerald-100 p-6 sm:p-8">

        <div class="relative text-center max-w-3xl mx-auto">

            <h2 class="text-xl sm:text-3xl font-bold text-[#0B1F3A]">
                Sebuah Pertinggalan Kecil dari Kami
            </h2>

            <p class="text-xs sm:text-base text-slate-500 leading-relaxed mt-3 sm:mt-4">
                Terima kasih atas kerja sama, dukungan, dan kesempatan yang
                diberikan selama kegiatan KKN di Kelurahan Tebing Tinggi Okura.
                Semoga website ini dapat menjadi bagian kecil dari perjalanan
                kami yang tetap memberikan manfaat setelah kegiatan KKN selesai.
            </p>

            <div class="flex items-center justify-center gap-3 sm:gap-5 mt-6">
                <img
                    src="{{ asset('storage/logo2.png') }}"
                    alt="Logo Kelurahan"
                    class="h-10 w-10 sm:h-14 sm:w-14 object-contain">

                <span class="text-slate-300 text-base sm:text-xl">×</span>

                <img
                    src="{{ asset('storage/logo/Logo gokura.png') }}"
                    alt="Logo KKN"
                    class="h-10 w-10 sm:h-14 sm:w-14 object-contain">

                <span class="text-slate-300 text-base sm:text-xl">×</span>

                <img
                    src="{{ asset('storage/logo/logo usti.png') }}"
                    alt="Logo Kampus"
                    class="h-10 w-10 sm:h-14 sm:w-14 object-contain">
            </div>

        </div>

    </div>

@endsection

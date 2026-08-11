{{-- resources/views/frontend/profil.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Profil Kelurahan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- Visi Misi --}}
        <div class="text-center mb-12">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-3">
                Profil Kelurahan
            </span>
            <h1 class="text-3xl font-bold text-[#0B1F3A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Tebing Tinggi Okura
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-14">
            <div class="bg-[#0B1F3A] rounded-2xl p-8 text-white">
                <h2 class="font-semibold text-lg mb-3">🎯 Visi</h2>
                <p class="text-sm text-slate-200 leading-relaxed">
                    Mewujudkan kelurahan yang mandiri, sejahtera, dan berdaya saing berbasis potensi lokal dan pelayanan prima.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-md">
                <h2 class="font-semibold text-lg text-slate-800 mb-3">🚀 Misi</h2>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex gap-2"><span class="text-emerald-600">•</span> Meningkatkan kualitas pelayanan publik yang cepat dan transparan.</li>
                    <li class="flex gap-2"><span class="text-emerald-600">•</span> Mengembangkan potensi wisata dan UMKM lokal.</li>
                    <li class="flex gap-2"><span class="text-emerald-600">•</span> Mendorong partisipasi aktif masyarakat dalam pembangunan.</li>
                </ul>
            </div>
        </div>

        {{-- Sejarah & Geografis --}}
        <div class="mb-14">
            <h2 class="text-2xl font-bold text-[#0B1F3A] mb-5">Sejarah & Geografis</h2>
            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-md">
                <p class="text-sm text-slate-600 leading-relaxed mb-4">
                    Kelurahan Tebing Tinggi Okura merupakan salah satu kelurahan di Kecamatan Rumbai Pesisir, Kota Pekanbaru,
                    yang terletak di tepian Sungai Siak dengan potensi alam dan budaya yang khas.
                </p>
                <div id="peta-profil" class="w-full h-72 rounded-xl"></div>
            </div>
        </div>

        {{-- Struktur Organisasi --}}
        <div>
            <h2 class="text-2xl font-bold text-[#0B1F3A] mb-5">Struktur Organisasi</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                @forelse ($pegawais as $pegawai)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                        <img src="{{ $pegawai->foto ? asset('storage/'.$pegawai->foto) : asset('images/avatar-placeholder.jpg') }}"
                             class="w-16 h-16 rounded-full object-cover mx-auto mb-3" alt="{{ $pegawai->nama }}">
                        <p class="text-sm font-semibold text-slate-800">{{ $pegawai->nama }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $pegawai->jabatan }}</p>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-sm text-slate-400 py-8">Data struktur organisasi belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('peta-profil').setView([0.6183, 101.5854], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([0.6183, 101.5854]).addTo(map).bindPopup('Kantor Lurah Tebing Tinggi Okura');
</script>
@endpush

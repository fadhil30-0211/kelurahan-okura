@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-800">Partisipasi Warga</h1>
        <p class="text-slate-600 mt-2">Sampaikan aspirasi, daftarkan usaha Anda, atau beri masukan untuk kelurahan.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <a href="{{ route('partisipasi.umkm') }}" class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition border border-slate-100 group">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:scale-110 transition">
                🛍️
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Pendaftaran UMKM</h3>
            <p class="text-slate-600 text-sm">Daftarkan usaha lokal Anda untuk tampil di direktori portal warga.</p>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('wisata.usul') }}" class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition border border-slate-100 group">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition">
                🗺️
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Usulan Tempat Wisata</h3>
            <p class="text-slate-600 text-sm">Rekomendasikan potensi destinasi wisata baru di lingkungan sekitar.</p>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('penilaian.index') }}" class="p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition border border-slate-100 group">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 mb-4 group-hover:scale-110 transition">
                ⭐
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Penilaian Website</h3>
            <p class="text-slate-600 text-sm">Beri umpan balik dan rating untuk meningkatkan pelayanan digital kami.</p>
        </a>
    </div>
</div>
@endsection

@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Header Section -->
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-800">Penilaian & Ulasan Website</h1>
        <p class="text-slate-600 mt-2">Bantu kami meningkatkan kualitas layanan digital Kelurahan Okura dengan memberikan rating dan masukan Anda.</p>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl shadow-sm flex items-center space-x-3">
            <span class="text-2xl">🎉</span>
            <div>
                <span class="font-semibold">Berhasil!</span>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-8 items-start">

        <!-- Form Penilaian -->
        <div class="bg-white rounded-2xl shadow-md p-8 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span>✍️</span> Berikan Penilaian Anda
            </h2>

            <form action="{{ route('penilaian.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Seberapa puas Anda dengan website ini?</label>
                    <select name="rating" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition" required>
                        <option value="" disabled selected>Pilih Rating...</option>
                        <option value="5">⭐⭐⭐⭐⭐ - Sangat Puas (Sangat Baik)</option>
                        <option value="4">⭐⭐⭐⭐ - Puas (Baik)</option>
                        <option value="3">⭐⭐⭐ - Cukup</option>
                        <option value="2">⭐⭐ - Kurang</option>
                        <option value="1">⭐ - Sangat Kurang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ulasan / Masukan (Opsional)</label>
                    <textarea name="ulasan" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition" placeholder="Tuliskan kritik, saran, atau pengalaman Anda menggunakan website ini..."></textarea>
                </div>

                <button type="submit" class="w-full py-3 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition duration-200 flex items-center justify-center gap-2">
                    <span>Kirim Penilaian</span>
                    <span>📤</span>
                </button>
            </form>
        </div>

        <!-- Ringkasan Statistik / Testimoni Warga -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl shadow-md p-8 text-white">
                <h3 class="text-lg font-medium opacity-90 mb-1">Rata-rata Kepuasan Warga</h3>
                <div class="flex items-baseline gap-3 my-2">
                    <span class="text-5xl font-ext5bold">{{ isset($rataRating) ? number_format($rataRating, 1) : '0.0' }}</span>
                    <span class="text-emerald-200 text-sm">dari 5.0 skala bintang</span>
                </div>
                <p class="text-sm opacity-80 mt-4">Berdasarkan total <strong>{{ $totalUlasan ?? 0 }}</strong> ulasan yang masuk dari warga Kelurahan Okura.</p>
            </div>

            <!-- Ulasan Terbaru dari Warga -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
                <h3 class="text-base font-bold text-slate-800 mb-4">💬 Ulasan Terbaru Warga</h3>

                @if(isset($penilaians) && count($penilaians) > 0)
                    <div class="space-y-4">
                        @foreach($penilaians as $item)
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-amber-500 text-sm">
                                        {!! str_repeat('⭐', $item->rating) !!}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-600 italic">"{{ $item->ulasan ?? 'Tidak ada ulasan teks.' }}"</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada ulasan yang masuk. Jadilah yang pertama memberikan penilaian!</p>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection

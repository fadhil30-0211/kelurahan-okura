@extends('layouts.admin') {{-- Sesuaikan dengan layout admin Anda --}}

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Penilaian & Ulasan Warga</h3>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Ulasan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUlasan }}</p>
            </div>
            <span class="p-3 bg-blue-50 text-blue-600 rounded-lg text-xl">💬</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Rata-rata Rating</p>
                <p class="text-2xl font-bold text-amber-500">⭐ {{ number_format($rataRating, 1) }} / 5.0</p>
            </div>
            <span class="p-3 bg-amber-50 text-amber-600 rounded-lg text-xl">🌟</span>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Ulasan Positif (>= 4★)</p>
                <p class="text-2xl font-bold text-emerald-600">{{ $ulasanPositif }}</p>
            </div>
            <span class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-xl">👍</span>
        </div>
    </div>

    <!-- Filter & Tabel Data -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between gap-4">
            <h4 class="text-lg font-bold text-gray-800">Daftar Masukan</h4>

            <!-- Filter Bintang -->
            <form method="GET" action="{{ route('admin.penilaian.index') }}" class="flex items-center gap-2">
                <select name="rating" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Ulasan / Masukan</th>
                        <th class="px-6 py-3">IP Address</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($penilaians as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-amber-500">
                                {!! str_repeat('⭐', $item->rating) !!} ({{ $item->rating }})
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->ulasan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $item->ip_address ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.penilaian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                Belum ada data penilaian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $penilaians->links() }}
        </div>
    </div>
</div>
@endsection

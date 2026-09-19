@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin kamu --}}

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Permintaan Reset Password</h1>
        <p class="text-sm text-slate-500">Kelola persetujuan reset password dari pengurus/pengguna.</p>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-600">
            <thead class="text-xs uppercase bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Tanggal Pengajuan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Catatan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $item)
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $item->user->name ?? 'User Hapus' }}</td>
                        <td class="px-4 py-3">{{ $item->email }}</td>
                        <td class="px-4 py-3">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($item->status == 'pending')
                                <span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full">Pending</span>
                            @elseif($item->status == 'approved')
                                <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">Disetujui</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">{{ $item->catatan ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($item->status == 'pending')
                                <div class="flex justify-center gap-2">
                                    {{-- Form Setujui (Sesuai Route::post) --}}
                                    <form action="{{ route('admin.password-reset.approve', $item->id) }}" method="POST" onsubmit="return confirm('Setujui reset password? Password akan di-set ke Kelurahan123')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition">
                                            Setujui
                                        </button>
                                    </form>

                                    {{-- Form Tolak (Sesuai Route::post) --}}
                                    <form action="{{ route('admin.password-reset.reject', $item->id) }}" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex justify-center items-center gap-2">
                                    <span class="text-xs text-slate-400">Selesai</span>

                                    {{-- Form Hapus Riwayat --}}
                                    <form action="{{ route('admin.password-reset.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-600 rounded-lg text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-slate-400">Belum ada pengajuan reset password.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection

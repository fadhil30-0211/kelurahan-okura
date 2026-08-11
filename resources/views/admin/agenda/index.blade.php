{{-- resources/views/admin/agenda/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Kalender Agenda')

@section('content')
<div class="space-y-5">
    <div class="flex justify-end">
        <a href="{{ route('admin.agenda.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
            + Tambah Agenda
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-5 py-3 font-medium">Nama Acara</th>
                        <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                        <th class="text-left px-5 py-3 font-medium">Lokasi</th>
                        <th class="text-right px-5 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($agendas as $agenda)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 text-slate-700">{{ $agenda->nama_acara }}</td>
                            <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $agenda->tanggal->translatedFormat('d F Y') }} {{ $agenda->waktu }}</td>
                            <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $agenda->lokasi ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.agenda.edit', $agenda) }}" class="text-xs font-medium text-sky-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST"
                                          onsubmit="return confirm('Hapus agenda ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-10 text-slate-400 text-sm">Belum ada agenda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($agendas->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $agendas->links() }}</div>
        @endif
    </div>
</div>
@endsection

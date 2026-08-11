{{-- resources/views/admin/emergency-contact/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Kontak Darurat')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3 font-medium">Label</th>
                    <th class="text-left px-5 py-3 font-medium">Nomor</th>
                    <th class="text-left px-5 py-3 font-medium">Status</th>
                    <th class="text-right px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($contacts as $contact)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3.5 text-slate-700">{{ $contact->label }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $contact->nomor_telepon }}</td>
                        <td class="px-5 py-3.5">
                            <form action="{{ route('admin.emergency-contact.toggle', $contact) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-medium {{ $contact->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $contact->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.emergency-contact.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus kontak ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-10 text-slate-400 text-sm">Belum ada kontak darurat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-4">Tambah Kontak</h3>
        <form action="{{ route('admin.emergency-contact.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Label</label>
                <input type="text" name="label" required placeholder="Contoh: Babinsa, Puskesmas"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" required placeholder="0812xxxxxxx"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Tambah
            </button>
        </form>
    </div>
</div>
@endsection

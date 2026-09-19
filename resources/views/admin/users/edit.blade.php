@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Data Pengguna')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role / Hak Akses</label>
            <select name="role" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                <option value="staf" {{ old('role', $user->role) === 'staf' ? 'selected' : '' }}>Staf (Operator Harian)</option>
                <option value="lurah" {{ old('role', $user->role) === 'lurah' ? 'selected' : '' }}>Lurah (Persetujuan / Approval)</option>
                <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin (Akses Penuh)</option>
            </select>
            @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-500 mb-3">*Kosongkan password jika tidak ingin mengganti password lama.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                </div>
            </div>
            @error('password') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-3 pt-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">Simpan Perubahan</button>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Batal</a>
        </div>
    </form>
</div>
@endsection

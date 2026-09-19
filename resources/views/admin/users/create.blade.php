@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 p-6">
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role / Hak Akses</label>
            <select name="role" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
                <option value="staf">Staf (Operator Harian)</option>
                <option value="lurah">Lurah (Persetujuan / Approval)</option>
                <option value="super_admin">Super Admin (Akses Penuh)</option>
            </select>
            @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
            </div>
        </div>
        @error('password') <span class="text-xs text-red-500 block">{{ $message }}</span> @enderror

        <div class="flex gap-3 pt-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">Simpan Pengguna</button>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Batal</a>
        </div>
    </form>
</div>
@endsection

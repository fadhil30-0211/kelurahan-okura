{{-- resources/views/admin/social-post/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Feed Media Sosial')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3 font-medium">Platform</th>
                    <th class="text-left px-5 py-3 font-medium">Caption</th>
                    <th class="text-left px-5 py-3 font-medium">URL</th>
                    <th class="text-right px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($posts as $post)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3.5 text-slate-700 capitalize">{{ $post->platform }}</td>
                        <td class="px-5 py-3.5 text-slate-600 max-w-xs truncate">{{ $post->caption ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-sky-600 max-w-xs truncate"><a href="{{ $post->url }}" target="_blank">{{ $post->url }}</a></td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.social-post.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus post ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-10 text-slate-400 text-sm">Belum ada post ditambahkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-4">Tambah Post</h3>
        <form action="{{ route('admin.social-post.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Platform</label>
                <select name="platform" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="instagram">Instagram</option>
                    <option value="facebook">Facebook</option>
                    <option value="tiktok">TikTok</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">URL Post</label>
                <input type="url" name="url" required placeholder="https://www.instagram.com/p/..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Caption Singkat</label>
                <input type="text" name="caption"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold">
                Tambah
            </button>
        </form>
    </div>
</div>
@endsection

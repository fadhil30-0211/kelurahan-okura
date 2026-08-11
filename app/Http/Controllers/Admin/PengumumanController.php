<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $pengumumans = Pengumuman::with('user')
            ->when($request->search, fn ($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(10);

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'isi'              => 'required|string',
            'kategori'         => 'required|in:umum,penting,darurat',
            'file_lampiran'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('file_lampiran')) {
            $validated['file_lampiran'] = $request->file('file_lampiran')->store('pengumuman', 'public');
        }

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'isi'              => 'required|string',
            'kategori'         => 'required|in:umum,penting,darurat',
            'file_lampiran'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('file_lampiran')) {
            if ($pengumuman->file_lampiran) {
                Storage::disk('public')->delete($pengumuman->file_lampiran);
            }
            $validated['file_lampiran'] = $request->file('file_lampiran')->store('pengumuman', 'public');
        }

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->file_lampiran) {
            Storage::disk('public')->delete($pengumuman->file_lampiran);
        }
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}

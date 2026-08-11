<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $pegawais = Pegawai::when($request->search, fn ($q) => $q->where('nama', 'like', "%{$request->search}%"))
            ->ordered()
            ->paginate(10);

        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nip'                => 'nullable|string|max:30',
            'jabatan'            => 'required|string|max:255',
            'deskripsi_jabatan'  => 'nullable|string',
            'email'              => 'nullable|email|max:255',
            'no_hp'              => 'nullable|string|max:20',
            'urutan'             => 'nullable|integer|min:0',
            'foto'               => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'          => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nip'                => 'nullable|string|max:30',
            'jabatan'            => 'required|string|max:255',
            'deskripsi_jabatan'  => 'nullable|string',
            'email'              => 'nullable|email|max:255',
            'no_hp'              => 'nullable|string|max:20',
            'urutan'             => 'nullable|integer|min:0',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'          => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::orderBy('urutan')->get();
        return view('admin.emergency-contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'          => 'required|string|max:100',
            'nomor_telepon'  => 'required|string|max:20',
            'urutan'         => 'nullable|integer|min:0',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? (EmergencyContact::max('urutan') + 1);
        $validated['is_active'] = true;

        EmergencyContact::create($validated);

        return redirect()->route('admin.emergency-contact.index')->with('success', 'Kontak darurat berhasil ditambahkan.');
    }

    public function toggle(EmergencyContact $emergencyContact)
    {
        $emergencyContact->update(['is_active' => ! $emergencyContact->is_active]);
        return back()->with('success', 'Status kontak berhasil diperbarui.');
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();
        return back()->with('success', 'Kontak darurat berhasil dihapus.');
    }
}

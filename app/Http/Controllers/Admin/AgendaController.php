<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_acara' => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'tanggal'    => 'required|date',
            'waktu'      => 'nullable|string|max:50',
            'lokasi'     => 'nullable|string|max:255',
        ]);
        $validated['user_id'] = Auth::id();

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'nama_acara' => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'tanggal'    => 'required|date',
            'waktu'      => 'nullable|string|max:50',
            'lokasi'     => 'nullable|string|max:255',
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}

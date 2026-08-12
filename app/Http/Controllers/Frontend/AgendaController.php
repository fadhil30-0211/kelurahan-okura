<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agendaMendatang = Agenda::upcoming()->get();
        $agendaLalu = Agenda::where('tanggal', '<', now()->toDateString())
            ->orderByDesc('tanggal')
            ->paginate(10);

        return view('frontend.agenda.index', compact('agendaMendatang', 'agendaLalu'));
    }
}

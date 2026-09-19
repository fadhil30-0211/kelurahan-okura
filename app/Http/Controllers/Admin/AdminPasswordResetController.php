<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPasswordResetController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::with('user')->latest()->paginate(10);
        return view('admin.password_reset.index', compact('requests'));
    }

    public function approve($id)
    {
        $resetReq = PasswordResetRequest::findOrFail($id);

        if ($resetReq->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        // Reset password user ke password default (misal: "Kelurahan123")
        $defaultPassword = 'Kelurahan123';
        $user = $resetReq->user;
        $user->password = Hash::make($defaultPassword);
        $user->save();

        $resetReq->update([
            'status' => 'approved',
            'catatan' => 'Password di-reset ke: ' . $defaultPassword,
        ]);

        return back()->with('success', 'Permintaan disetujui! Password user berhasil di-reset menjadi: ' . $defaultPassword);
    }

    public function reject(Request $request, $id)
    {
        $resetReq = PasswordResetRequest::findOrFail($id);

        $resetReq->update([
            'status' => 'rejected',
            'catatan' => $request->input('catatan', 'Pengajuan ditolak oleh admin.'),
        ]);

        return back()->with('success', 'Permintaan reset password berhasil ditolak.');
    }

    public function destroy($id)
    {
        $request = PasswordResetRequest::findOrFail($id);
        $request->delete();

        return redirect()->back()->with('success', 'Riwayat pengajuan reset password berhasil dihapus.');
    }
}

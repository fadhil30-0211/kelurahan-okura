<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetRequest;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar di sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah sudah ada pengajuan pending
        $existing = PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('info', 'Pengajuan reset password kamu sudah dikirim sebelumnya dan sedang menunggu persetujuan admin.');
        }

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Permintaan reset password telah dikirim ke Admin. Silakan hubungi admin kelurahan untuk konfirmasi.');
    }
}

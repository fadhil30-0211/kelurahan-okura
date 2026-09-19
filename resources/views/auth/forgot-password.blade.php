<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Kelurahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100">

        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl mx-auto flex items-center justify-center text-xl font-bold mb-3">
                🔑
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Lupa Password?</h1>
            <p class="text-xs text-slate-500 mt-1">Masukkan email terdaftar kamu untuk menerima instruksi reset password.</p>
        </div>

        @if (session('status'))
            <div class="p-4 mb-4 text-xs text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl">
                <p class="font-bold">✅ {{ session('status') }}</p>
                @if(session('reset_link'))
                    <div class="mt-2 pt-2 border-t border-emerald-200/60">
                        <p class="text-[11px] text-emerald-700">Gunakan link langsung ini (Mode Dev):</p>
                        <a href="{{ session('reset_link') }}" class="text-xs font-mono font-bold underline break-all text-emerald-900 hover:text-emerald-600">
                            {{ session('reset_link') }}
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none transition @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm transition shadow-lg shadow-emerald-600/20 active:scale-95">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.login') }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-600 transition flex items-center justify-center gap-1">
                <span>←</span> Kembali ke Halaman Login
            </a>
        </div>

    </div>

</body>
</html>

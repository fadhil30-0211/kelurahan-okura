<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - Sistem Kelurahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100">

        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl mx-auto flex items-center justify-center text-xl font-bold mb-3">
                🔒
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Password Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Silakan masukkan password baru untuk akun kamu.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ request('email', old('email')) }}" required readonly
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-50 text-slate-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none transition @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:outline-none transition">
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm transition shadow-lg shadow-emerald-600/20 active:scale-95">
                Simpan Password Baru
            </button>
        </form>

    </div>

</body>
</html>

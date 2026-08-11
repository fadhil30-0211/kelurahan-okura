{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Kelurahan Tebing Tinggi Okura</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#0B1F3A] px-4">

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-emerald-600 flex items-center justify-center text-white font-bold text-xl mx-auto mb-4">
                TO
            </div>
            <h1 class="text-white font-bold text-lg">Kelurahan Tebing Tinggi Okura</h1>
            <p class="text-slate-400 text-sm mt-1">Portal Administrasi</p>
        </div>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Masuk ke Dashboard</h2>
            <p class="text-sm text-slate-500 mb-6">Silakan masuk menggunakan akun admin/staf Anda.</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5">
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required
                               class="w-full px-4 py-2.5 pr-11 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                        <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg x-show="!show" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-slate-500 text-xs mt-6">
            <a href="{{ route('home') }}" class="hover:text-white transition">← Kembali ke halaman utama</a>
        </p>
    </div>

</body>
</html>

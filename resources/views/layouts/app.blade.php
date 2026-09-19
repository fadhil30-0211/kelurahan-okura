<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <span class="font-bold text-slate-800 text-lg">Admin Panel Kelurahan</span>
        <a href="{{ route('profil') }}" target="_blank" class="text-xs text-emerald-600 hover:underline">
            Lihat Website &rarr;
        </a>
    </nav>

    <main class="py-6">
        @yield('content')
    </main>

</body>
</html>

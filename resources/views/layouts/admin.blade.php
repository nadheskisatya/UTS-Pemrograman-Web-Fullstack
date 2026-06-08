<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — POS Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-kopi-black text-kopi-white min-h-screen flex">

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- Main Content --}}
    <main class="flex-1 ml-64 p-8 min-h-screen">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-900/40 border border-green-600 text-green-300 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-900/40 border border-red-600 text-red-300 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

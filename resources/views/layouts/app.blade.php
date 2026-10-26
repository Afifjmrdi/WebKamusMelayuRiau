<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Kamus Balai Bahasa Riau')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- Font & Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('styles')
</head>

<body class="bg-white overflow-x-hidden">

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    @stack('scripts')
</body>

</html>
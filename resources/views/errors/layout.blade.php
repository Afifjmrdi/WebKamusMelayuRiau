<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
</head>

<body>
    <canvas id="particleCanvas"></canvas>

    <div class="container">
        <div class="error" data-code="@yield('code')">@yield('code')</div>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
    </div>

    <script src="{{ asset('js/error.js') }}"></script>
    <script>
        const errorCode = "@yield('code')";
    </script>
</body>

</html>
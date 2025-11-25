<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Fonts & CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    @yield('vendor-style')
    @yield('page-style')
</head>

<body>

    {{-- Sidebar --}}
    @include('admin.layouts.sidebaradmin')

    <div class="layout-page">

        {{-- Navbar --}}
        @include('admin.layouts.navbaradmin')

        <!-- ====================== CONTENT WRAPPER ====================== -->
        <div class="content-wrapper">

            {{-- ======= HALAMAN UTAMA (Dashboard, dll) ======= --}}
            <div class="container-xxl flex-grow-1 container-p-y">
                @yield('content')
            </div>

            {{-- Footer --}}
            @include('admin.layouts.footeradmin')

            <div class="content-backdrop fade"></div>
        </div>
        <!-- ==================== END CONTENT WRAPPER ===================== -->

    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Vendor Script & Page Script untuk Chart.js --}}
    @yield('vendor-script')
    @yield('page-script')

</body>

</html>
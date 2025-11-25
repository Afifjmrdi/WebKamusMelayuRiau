<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
    data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .stat-card {
            border-radius: 16px;
            transition: all 0.2s ease-in-out;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .menu-item.active>.menu-link {
            background-color: #f0edff !important;
            color: #696cff !important;
            font-weight: 600;
            border-radius: 12px;
        }

        .menu-item.active i {
            color: #696cff !important;
        }
    </style>
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.sidebaradmin')

            <div class="layout-page">
                @include('layouts.navbaradmin')

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{-- 👇 Bagian konten tiap halaman --}}
                        @yield('content')
                    </div>

                    @include('layouts.footeradmin')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    {{-- APEXCHARTS penting, jangan dihapus --}}
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- untuk @section --}}
    @yield('scripts')

    {{-- untuk @push --}}
    @stack('scripts')

</body>

</html>

<style>
    .swal2-container {
        z-index: 20000 !important;
        /* pastikan di atas semua elemen dashboard */
    }
</style>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <svg
                            width="25"
                            viewBox="0 0 25 42"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">

                            <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                            <mask id="mask-2" fill="white">
                                                <use xlink:href="#path-1"></use>
                                            </mask>
                                            <use fill="#696cff" xlink:href="#path-1"></use>
                                            <g id="Path-3" mask="url(#mask-2)">
                                                <use fill="#696cff" xlink:href="#path-3"></use>
                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                            </g>
                                            <g id="Path-4" mask="url(#mask-2)">
                                                <use fill="#696cff" xlink:href="#path-4"></use>
                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                            </g>
                                        </g>
                                        <g
                                            id="Triangle"
                                            transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                            <use fill="#696cff" xlink:href="#path-5"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2">
                        <img src="{{ asset('assets/BBP.png') }}" alt="Logo"
                            style="height: 100px; width: auto; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.5));">
                    </span>

                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <!-- SideBar Menu -->

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Halaman Utama</span>
            </li>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Beranda</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.kamus') ? 'active' : '' }}">
                    <a href="{{ route('admin.kamus') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-box"></i>
                        <div data-i18n="Analytics">Data Kamus</div>
                    </a>
                </li>

                <!-- Pelayanan -->
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Pelayanan</span></li>

                <li class="menu-item {{ request()->routeIs('admin.pelayanan.pengajuan') ? 'active' : '' }}">
                    <a href="{{ route('admin.pelayanan.pengajuan') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-collection"></i>
                        <div data-i18n="Basic">Kosakata Baru</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.pelayanan.koreksikata') ? 'active' : '' }}">
                    <a href="{{ route('admin.pelayanan.koreksikata') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-copy"></i>
                        <div data-i18n="Extended UI">Koreksi Kosakata</div>
                    </a>
                </li>
            </ul>

        </aside>
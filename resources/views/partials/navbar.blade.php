{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    nav * {
        font-family: "JetBrains Mono", monospace !important;
        letter-spacing: 0.4px;
    }

    .menu-item {
        position: relative;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        padding: 4px 0;
    }

    .menu-item::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 1px;
        bottom: -3px;
        left: 0;
        background-color: #000;
        transition: width 0.25s ease;
    }

    .menu-item:hover::after,
    .menu-item.active::after {
        width: 100%;
    }

    #searchDropdown {
        max-height: 15rem;
        overflow-y: auto;
    }

    /* Stars */
    @keyframes spin-slow {
        from {
            transform: rotate(0);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes twinkle {

        0%,
        100% {
            opacity: .8;
        }

        50% {
            opacity: .25;
        }
    }

    .star {
        opacity: .9;
        animation: spin-slow 6s linear infinite, twinkle 3s ease-in-out infinite;
    }

    .star:nth-child(3n) {
        animation-duration: 8s, 2.4s;
    }

    .star:nth-child(4n) {
        animation-duration: 13s, 4s;
        animation-direction: reverse, alternate;
    }

    .star:nth-child(5n) {
        animation-duration: 16s, 3.6s;
        opacity: .7;
    }
</style>

<style>
    /* ANIMASI CARD MENU DESKTOP */
    @keyframes fadeSlideDown {
        0% {
            opacity: 0;
            transform: translateY(-12px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .menu-anim {
        animation: fadeSlideDown 0.6s ease forwards;
    }
</style>


{{-- NAVBAR --}}
<nav x-data="{ open: false }"
    class="px-4 md:px-16 py-1 absolute top-0 left-0 w-full z-50 bg-transparent">

    <!-- WRAPPER -->
    <div class="flex items-center justify-between w-full px-4">
        <!-- LOGO (always left) -->
        <div class="flex-shrink-0">
            <img src="{{ asset('assets/BBP.png') }}"
                alt="Logo BBP"
                class="block"
                style="width: 140px; height: auto; object-fit: contain;">
        </div>

        <!-- DESKTOP MENU (center) -->
        <div class="hidden md:flex flex-grow justify-center menu-anim">
            <ul class="flex items-center gap-10 
                bg-[#e5e5e5]/80 backdrop-blur-sm 
                px-8 py-3 rounded-lg shadow-sm border border-black/5">

                <li><a href="{{ url('/') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">BERANDA</a></li>
                <li><a href="{{ url('/koreksi') }}" class="menu-item {{ request()->is('koreksi') ? 'active' : '' }}">KOREKSI</a></li>
                <li><a href="{{ url('/ajukan') }}" class="menu-item {{ request()->is('ajukan') ? 'active' : '' }}">AJUKAN</a></li>
                <li><a href="{{ url('/tentang') }}" class="menu-item {{ request()->is('tentang') ? 'active' : '' }}">TENTANG</a></li>

            </ul>
        </div>

        <!-- HAMBURGER (right on mobile) -->
        <div class="md:hidden flex-shrink-0">
            <button @click="open = !open"
                class="relative w-10 h-10 rounded-full bg-white shadow border border-gray-300
                flex items-center justify-center transition-all duration-300"
                :class="open ? 'ring-2 ring-blue-400 rotate-180' : ''">

                <span class="absolute w-6 h-0.5 bg-black transition-all duration-300"
                    :class="open ? 'rotate-45 translate-y-0' : '-translate-y-2'"></span>

                <span class="absolute w-6 h-0.5 bg-black transition-all duration-300"
                    :class="open ? 'opacity-0' : 'opacity-100'"></span>

                <span class="absolute w-6 h-0.5 bg-black transition-all duration-300"
                    :class="open ? '-rotate-45 translate-y-0' : 'translate-y-2'"></span>
            </button>
        </div>

        <!-- SPACER UNTUK DESKTOP -->
        <div class="hidden md:block flex-shrink-0" style="width: 140px;"></div>

    </div>
    <!-- MOBILE MENU DROPDOWN -->
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-3 scale-95"
        class="md:hidden mx-4 mt-4 p-5 rounded-2xl shadow-xl backdrop-blur-xl
    bg-white/60 border border-white/20 space-y-3 text-center">

        @php
        $menus = [
        ['url' => '/', 'label' => 'Beranda', 'icon' => ''],
        ['url' => '/koreksi', 'label' => 'Koreksi Kata', 'icon' => ''],
        ['url' => '/ajukan', 'label' => 'Ajukan Kata', 'icon' => ''],
        ['url' => '/tentang', 'label' => 'Tentang Kami', 'icon' => ''],
        ];
        @endphp

        @foreach ($menus as $m)
        <a href="{{ url($m['url']) }}"
            class="flex items-center justify-center gap-3 font-semibold text-base py-3 rounded-xl transition-all
               {{ request()->is(trim($m['url'], '/')) ? 'text-blue-600 bg-blue-50' : 'text-gray-900 hover:bg-white/70' }}">

            <i class="fa-solid fa-{{ $m['icon'] }}"></i>
            <span>{{ $m['label'] }}</span>
        </a>
        @endforeach

    </div>

</nav>
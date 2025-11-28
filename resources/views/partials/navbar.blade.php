<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif, 'jetbrains';
    }

    nav * {
        font-family: "JetBrains Mono", monospace !important;
        letter-spacing: 0.5px;
    }

    .menu-item {
        position: relative;
    }

    .menu-item::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: #000;
        transition: width 0.3s ease;
    }

    .menu-item:hover::after,
    .menu-item.active::after {
        width: 100%;
    }

    #searchDropdown {
        max-height: 15rem;
        overflow-y: auto;
    }

    #resultsList li {
        min-height: 3rem;
    }

    #resultsList li span {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @keyframes twinkle {

        0%,
        100% {
            opacity: 0.2;
            transform: scale(0.9);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }
    }


    .search-active #subtitle {
        margin-top: -30px;
    }

    .search-active #title {
        font-size: 2rem;
        margin-top: -20px;
        margin-bottom: 10px;
    }

    .search-active #searchContainer {
        margin-top: -10px;
    }

    /* semua bintang */
    .star {
        opacity: 0.9;
        transform-origin: center;
        /* mutar dari tengah */
        animation: spin-slow 2s linear infinite, twinkle 3s ease-in-out infinite;
    }

    /* bikin rotasi */
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* bikin kedip */
    @keyframes twinkle {

        0%,
        100% {
            opacity: 0.9;
        }

        50% {
            opacity: 0.3;
        }
    }

    /* variasi random supaya nggak seragam */
    .star:nth-child(3n) {
        animation-duration: 8s, 2.5s;
        /* spin lebih cepat, kedip lebih singkat */
    }

    .star:nth-child(4n) {
        animation-duration: 12s, 4s;
        /* spin lebih lambat, kedip lebih panjang */
        animation-direction: reverse, alternate;
        /* arah rotasi kebalikan */
    }

    .star:nth-child(5n) {
        animation-duration: 15s, 3.5s;
        opacity: 0.7;
        /* agak redup */
    }
</style>

{{-- Navbar --}}
<nav x-data="{ open: false }" class="px-6 md:px-20 py-4 absolute top-0 left-0 w-full z-50">

    <div class="flex items-center justify-between h-16">

        {{-- Left: Logo + Desktop Menu --}}
        <div class="flex items-center gap-10">
            <img src="{{ asset('assets/BBP.png') }}" alt="Logo"
                class="mt-2 h-20 w-auto object-contain">

            <ul class="hidden md:flex gap-10 text-gray font-semibold">
                <li><a href="{{ url('/') }}"
                        class="menu-item pb-1 {{ request()->is('/') ? 'active' : '' }}">BERANDA</a></li>

                <li><a href="{{ url('/koreksi') }}"
                        class="menu-item pb-1 {{ request()->is('koreksi') ? 'active' : '' }}">KOREKSI KOSAKATA</a></li>

                <li><a href="{{ url('/ajukan') }}"
                        class="menu-item pb-1 {{ request()->is('ajukan') ? 'active' : '' }}">AJUKAN KOSAKATA</a></li>

                <li><a href="{{ url('/tentang') }}"
                        class="menu-item pb-1 {{ request()->is('tentang') ? 'active' : '' }}">TENTANG KAMI</a></li>
                <li><a href="{{ url('/tentang') }}"
                        class="menu-item pb-1 {{ request()->is('tentang') ? 'active' : '' }}">BOOKMARK</a></li>
            </ul>
        </div>

        {{-- Hamburger Button --}}
        <button @click="open = !open"
            class="md:hidden relative w-10 h-10 rounded-full bg-white shadow-sm border border-gray-300 
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

    {{-- Dropdown Mobile --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
        class="md:hidden mx-4 mt-4 p-5 rounded-2xl shadow-xl border border-white/10
           backdrop-blur-2xl bg-white/25 space-y-2 text-center">

        {{-- Beranda --}}
        <a href="{{ url('/') }}"
            class="flex items-center justify-center gap-2 font-semibold text-base py-2.5 rounded-xl 
            transition-all
            {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : 'text-gray-900 hover:bg-white/60' }}">
            <i class="fa-solid fa-house
              {{ request()->is('/') ? 'text-blue-600' : 'text-gray-700 group-hover:text-blue-600' }}">
            </i>
            <span>{{ request()->is('/') ? '• Beranda •' : 'Beranda' }}</span>
        </a>

        {{-- Koreksi --}}
        <a href="{{ url('/koreksi') }}"
            class="flex items-center justify-center gap-2 font-semibold text-base py-2.5 rounded-xl 
            transition-all
            {{ request()->is('koreksi') ? 'text-blue-600 bg-blue-50' : 'text-gray-900 hover:bg-white/60' }}">
            <i class="fa-solid fa-pen-to-square
              {{ request()->is('koreksi') ? 'text-blue-600' : 'text-gray-700' }}">
            </i>
            <span>{{ request()->is('koreksi') ? '• Koreksi Kata •' : 'Koreksi Kata' }}</span>
        </a>

        {{-- Ajukan --}}
        <a href="{{ url('/ajukan') }}"
            class="flex items-center justify-center gap-2 font-semibold text-base py-2.5 rounded-xl 
            transition-all
            {{ request()->is('ajukan') ? 'text-blue-600 bg-blue-50' : 'text-gray-900 hover:bg-white/60' }}">
            <i class="fa-solid fa-plus
              {{ request()->is('ajukan') ? 'text-blue-600' : 'text-gray-700' }}">
            </i>
            <span>{{ request()->is('ajukan') ? '• Ajukan Kata •' : 'Ajukan Kata' }}</span>
        </a>

        {{-- Tentang --}}
        <a href="{{ url('/tentang') }}"
            class="flex items-center justify-center gap-2 font-semibold text-base py-2.5 rounded-xl 
            transition-all
            {{ request()->is('tentang') ? 'text-blue-600 bg-blue-50' : 'text-gray-900 hover:bg-white/60' }}">
            <i class="fa-solid fa-circle-info
              {{ request()->is('tentang') ? 'text-blue-600' : 'text-gray-700' }}">
            </i>
            <span>{{ request()->is('tentang') ? '• Tentang Kami •' : 'Tentang Kami' }}</span>
        </a>
    </div>
</nav>
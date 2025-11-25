<style>
    body {
        font-family: 'Poppins', sans-serif;
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
<nav x-data="{ open: false }"
    class="px-6 md:px-20 py-4 absolute top-0 left-0 w-full z-50">

    <div class="flex items-center justify-between h-16">
        {{-- Kiri: Logo + Menu --}}
        <div class="flex items-center gap-10">
            <img src="{{ asset('assets/BBP.png') }}" alt="Logo"
                style="margin-top: 10px; height: 100px; width: auto; object-fit: contain;">
            <ul class="hidden md:flex gap-10 text-gray font-semibold">
                <li>
                    <a href="{{ url('/') }}"
                        class="menu-item pb-1 {{ request()->is('/') ? 'border-b-2' : '' }}"
                        style="{{ request()->is('/') ? 'border-color:#000000ff;' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ url('/koreksi') }}"
                        class="menu-item pb-1 {{ request()->is('koreksi') ? 'border-b-2' : '' }}"
                        style="{{ request()->is('koreksi') ? 'border-color:#000000ff;' : '' }}">
                        Koreksi Kosakata
                    </a>
                </li>
                <li>
                    <a href="{{ url('/ajukan') }}"
                        class="menu-item pb-1 {{ request()->is('ajukan') ? 'border-b-2' : '' }}"
                        style="{{ request()->is('ajukan') ? 'border-color:#000000ff;' : '' }}">
                        Ajukan Kosakata
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tentang') }}"
                        class="menu-item pb-1 {{ request()->is('tentang') ? 'border-b-2' : '' }}"
                        style="{{ request()->is('tentang') ? 'border-color:#000000ff;' : '' }}">
                        Tentang Kami
                    </a>
                </li>
            </ul>
        </div>

        {{-- Hamburger --}}
        <button @click="open = !open"
            class="md:hidden flex flex-col gap-1.5 focus:outline-none">
            <span :class="open ? 'rotate-45 translate-y-1' : ''"
                class="w-6 h-0.5 bg-black transition-all"></span>
            <span :class="open ? 'opacity-0' : ''"
                class="w-6 h-0.5 bg-black transition-all"></span>
            <span :class="open ? '-rotate-45 -translate-y-1' : ''"
                class="w-6 h-0.5 bg-black transition-all"></span>
        </button>
    </div>

    {{-- Dropdown Mobile --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden backdrop-blur-xl bg-white/10 border border-white/20 rounded-b-3xl mx-4 mt-3 p-6 shadow-2xl text-white text-center space-y-5">

        <a href="{{ url('/') }}"
            class="block font-poppins font-semibold text-lg text-black tracking-wide hover:text-blue-400 relative 
        after:absolute after:left-1/2 after:bottom-0 after:w-0 after:h-[2px] after:bg-blue-400 
        after:transition-all after:duration-300 hover:after:w-1/2 hover:after:-translate-x-1/2">
            Beranda
        </a>

        <a href="{{ url('/koreksi') }}"
            class="block font-poppins font-semibold text-lg text-black tracking-wide hover:text-blue-400 relative 
        after:absolute after:left-1/2 after:bottom-0 after:w-0 after:h-[2px] after:bg-blue-400 
        after:transition-all after:duration-300 hover:after:w-1/2 hover:after:-translate-x-1/2">
            Koreksi Kata
        </a>

        <a href="{{ url('/ajukan') }}"
            class="block font-poppins font-semibold text-lg text-black tracking-wide hover:text-blue-400 relative 
        after:absolute after:left-1/2 after:bottom-0 after:w-0 after:h-[2px] after:bg-blue-400 
        after:transition-all after:duration-300 hover:after:w-1/2 hover:after:-translate-x-1/2">
            Ajukan Kata
        </a>

        <a href="{{ url('/tentang') }}"
            class="block font-poppins font-semibold text-black text-lg tracking-wide hover:text-blue-400 relative 
        after:absolute after:left-1/2 after:bottom-0 after:w-0 after:h-[2px] after:bg-blue-400 
        after:transition-all after:duration-300 hover:after:w-1/2 hover:after:-translate-x-1/2">
            Tentang Kami
        </a>
    </div>

</nav>
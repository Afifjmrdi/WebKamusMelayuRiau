    {{-- resources/views/home.blade.php --}}
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Favicon --}}
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

        <title>Kamus Balai Bahasa Riau</title>
        @vite(['resources/css/app.css'])
        <!-- di head -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- AOS Animation -->
        <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            /* body {
                font-family: 'Poppins', sans-serif;
            } */

            body {
                font-family: 'Montserrat', sans-serif;
            }

            .font-jetbrains {
                font-family: "JetBrains Mono", monospace !important;
            }

            .font-montserrat {
                font-family: 'Montserrat', sans-serif;
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
                width: 100%;
                max-width: 100%;
                border-radius: 12px;
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

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
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

            /* Bookmark floating button */
            #openBookmarkModal {
                transition: transform .12s, box-shadow .12s;
                border-radius: 0.3rem;
            }

            #openBookmarkModal.animate-pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.15);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
                }
            }

            /* Bookmark modal backdrop */
            #bookmarkModal {
                backdrop-filter: blur(4px);
            }

            /* small notif */
            #bookmarkNotif {
                transition: opacity .25s, transform .25s;
            }

            /* search result mark */
            #resultsList li mark {
                background: #ffe58a;
                color: #000;
                padding: 0 3px;
                border-radius: 2px;
            }

            /* card rounded control (easy to change) */
            .card-rounded {
                border-radius: 0.75rem;
            }

            /* change to rounded-lg if wanted */

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(15px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeIn {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes blueBlink {

                0%,
                100% {
                    box-shadow: 0 0 0px rgba(37, 99, 235, 0);
                    opacity: 0.9;
                }

                50% {
                    box-shadow: 0 0 14px rgba(37, 99, 235, 0.7);
                    opacity: 1;
                }
            }

            /* Card Default (Desktop) */
            .welcome-card {
                animation: blueBlink 1.1s infinite ease-in-out;
                transition: opacity .3s;
            }

            /* Mobile Responsiveness */
            @media (max-width: 640px) {
                .welcome-card {
                    width: 75%;
                    bottom: 1rem;
                    right: 1rem;
                    padding: .65rem .8rem;
                    font-size: .85rem;
                }
            }

            #resultsList li mark {
                background: #ffdd62ff;
                color: #000;
                padding: 0 3px;
                border-radius: 2px;
            }

            :root {
                --search-height: 60px;
                /* sebelumnya ±48–52px */
            }
        </style>
    </head>

    <body class="bg-white scroll-smooth font-montserrat">

        {{-- NAVBAR --}}
        @include('partials.navbar')

        {{-- FLOATING BOOKMARK BUTTON (POJOK KANAN ATAS) --}}
        <button id="openBookmarkModal"
            class="fixed top-4 right-4 z-50 bg-white shadow-lg border border-blue-1000 text-blue-600 
                px-4 py-2 rounded font-semibold flex items-center gap-2 animate-pulse hover:animate-none">
            <i class="fa-solid fa-bookmark"></i>
        </button>

        {{-- BOOKMARK MODAL --}}
        <div id="bookmarkModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-40">
            <div class="bg-white p-6 w-96 shadow-2xl rounded-xl relative z-50">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Markah</h2>
                    <button id="closeBookmarkModal" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
                </div>

                <div id="bookmarkList" class="space-y-3 max-h-72 overflow-y-auto pr-1"></div>

                <p id="bookmarkEmpty" class="hidden text-center text-gray-500 py-4">
                    Belum ada Markah tersimpan
                </p>
            </div>
        </div>

        {{-- BOOKMARK SUCCESS NOTIFICATION --}}
        <div id="bookmarkNotif" class="hidden fixed top-4 right-20 z-[999] bg-blue-500 text-white px-4 py-2 rounded shadow-lg">
            Berhasil ditandai
        </div>

        {{-- HALAMAN BERANDA --}}
        <section id="beranda"
            class="relative min-h-screen flex flex-col items-center justify-start text-white overflow-hidden bg-cover bg-center
            pt-28 sm:pt-32 md:pt-40 pb-10 px-4 sm:px-6"
            style="background-image: url('{{ asset('assets/background4.png') }}');"
            data-aos="fade-in"
            data-aos-duration="1500">

            <div class="absolute inset-0 overflow-hidden">
                @for ($i = 0; $i < 40; $i++)
                    @php $top=rand(0,95); $left=rand(0,95); $size=rand(8,16); @endphp
                    <img src="{{ asset('assets/sparkle.png') }}" class="star absolute opacity-0 animate-[twinkle_3s_infinite_ease-in-out]" style="top: {{ $top }}%; left: {{ $left }}%; width: {{ $size }}px; height: {{ $size }}px;" alt="Star">
                    @endfor
            </div>

            <div id="mainContainer" class="relative z-10 flex flex-col items-center mt-2 text-center transition-all duration-500">
                <p id="subtitle" class="text-sm md:text-base tracking-widest text-gray-600 font-semibold mb-1 font-montserrat" data-aos="fade-down" data-aos-delay="200">BALAI BAHASA PROVINSI RIAU</p>

                <h1 id="title" class="text-3xl md:text-5xl font-semibold font-montserrat leading-tight mb-5 text-gray-600" data-aos="zoom-in" data-aos-delay="400">
                    Kamus Elektronik Bahasa <br> Melayu Riau
                </h1>

                {{-- Search Container --}}
                <div id="searchContainer" class="w-full max-w-[1200px] mx-auto mt-[5px]" data-aos="fade-up" data-aos-delay="600">
                    <div id="searchBox"
                        class="relative w-full grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-2">

                        {{-- INPUT SEARCH --}}
                        <div class="flex items-center bg-white rounded-lg shadow-lg
                            border border-gray-200 w-full"
                            style="height: var(--search-height);">

                            <div class="px-2 text-gray-500 flex items-center">
                                <i class="fa-solid fa-magnifying-glass text-blue-600"></i>
                            </div>

                            <input id="searchInput" type="text"
                                placeholder="Cari kata atau arti dalam bahasa Indonesia..."
                                class="w-full px-2 outline-none
                   text-gray-700 font-medium
                text-sm sm:text-base" />
                        </div>

                        {{-- ACTION BUTTONS (FILTER + SWAP) --}}
                        <div class="flex gap-2 w-full">
                            {{-- SWAP BUTTON (KANAN FILTER) --}}
                            <button id="swapBtn" type="button"
                                title="Tukar arah pencarian"
                                class="bg-white border border-gray-200 shadow-md
                                rounded-lg px-4
                                text-gray-600 text-sm
                                flex items-center justify-center
                                whitespace-nowrap font-semibold"
                                style="height: var(--search-height); min-width:120px;">
                                <span id="modeLabel">IND → DAERAH</span>
                            </button>

                            {{-- FILTER --}}
                            <div class="relative flex-1">

                                {{-- BUTTON --}}
                                <button id="filterButton"
                                    type="button"
                                    class="w-full bg-white border border-gray-200 shadow-md
               rounded-lg px-4
               text-blue-600 font-semibold text-sm
               flex items-center justify-between
               hover:bg-gray-50 transition"
                                    style="height: var(--search-height);">

                                    <span id="filterText"
                                        class="whitespace-nowrap overflow-hidden text-ellipsis min-w-[100px] max-w-[160px]">
                                        Filter...
                                    </span>

                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </button>

                                {{-- DROPDOWN --}}
                                <ul id="filterDropdown"
                                    class="absolute right-0 mt-2
               min-w-[260px] max-w-[330px]
               bg-white border border-gray-200
               rounded-xl shadow-xl
               hidden z-50">

                                    {{-- SEMUA KAMUS (TENGAH) --}}
                                    <li class="filter-item text-center
                   px-4 py-2.5
                   hover:bg-blue-100
                   cursor-pointer
                   text-gray-700 text-sm font-medium"
                                        data-value="">
                                        Semua Kamus
                                    </li>

                                    {{-- GARIS PEMISAH --}}
                                    <li class="border-t my-1"></li>

                                    {{-- ITEM KAMUS --}}
                                    @foreach ($daftarAsalKamus as $kamus)
                                    <li class="filter-item flex items-center justify-between
                                        px-4 py-2.5
                                        hover:bg-blue-100
                                        cursor-pointer
                                        text-gray-700 text-sm"
                                        data-value="{{ $kamus }}">
                                        <span>{{ str_replace('Kamus Indonesia - ', '', $kamus) }}</span>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>

                    </div>

                    {{-- Dropdown hasil pencarian --}}
                    <div id="searchDropdown"
                        class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg hidden transition-all duration-500 transform origin-top scale-y-0">
                        <ul id="resultsList" class="divide-y divide-gray-200"></ul>
                    </div>

                    {{-- Detail hasil --}}
                    <div id="resultDetail"
                        class="mt-4 hidden opacity-0 transform scale-95 transition-all duration-500 w-full max-w-[1200px] mx-auto"></div>

                    {{-- Card Informasi --}}
                    <div id="cardContainer"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4"
                        data-aos="fade-up" data-aos-delay="800">
                        <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                            <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                            <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia-<br>Melayu Siak</p>
                        </div>
                        <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                            <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                            <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia-<br>Rokan Hilir</p>
                        </div>
                        <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                            <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                            <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia-<br>Kuantan Singingi</p>
                        </div>
                        <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                            <h3 class="text-blue-600 font-bold text-sm md:text-base">Ada 20.000+ Kosakata</h3>
                            <p class="text-gray-600 text-xs md:text-sm leading-snug">Di Keseluruhan<br>Kamus</p>
                        </div>
                    </div>
                </div>

                {{-- Welcome Card --}}
                <div id="welcomeCard" class="welcome-card fixed bottom-5 right-5 w-64 bg-white shadow-lg rounded-xl p-4 flex items-center gap-3 border border-dark-100 z-50">
                    <img src="{{ asset('assets/bb2.png') }}" class="w-14 h-14 object-contain drop-shadow-md">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-700 leading-tight">Selamat Datang di Kamus Digital Riau!</p>
                    </div>
                    <button onclick="closeWelcomeCard()" class="text-gray-400 hover:text-red-500 transition text-sm font-bold ml-1">✕</button>
                </div>
            </div>
        </section>

        {{-- partials --}}
        @include('partials.informasi')
        @include('partials.kosakatamenarik', ['kosakataHariIni' => $kosakataHariIni])
        @include('partials.footer')

        <!-- SCRIPTS: keep function names intact, only enhance bookmark logic -->
        <script>
            // WELCOME CARD
            function closeWelcomeCard() {
                const card = document.getElementById('welcomeCard');
                if (!card) return;
                card.style.opacity = '0';
                card.style.transform = 'translateY(10px)';
                setTimeout(() => card.remove(), 300);
                sessionStorage.setItem('hideWelcomeCard', 'true');
            }
            window.addEventListener('load', () => {
                if (sessionStorage.getItem('hideWelcomeCard') === 'true') {
                    const card = document.getElementById('welcomeCard');
                    if (card) card.remove();
                }
            });
        </script>

        <script>
            // ==========================
            // SEARCH / UI EXISTING CODE
            // (Do not rename functions)
            // ==========================
            const searchInput = document.getElementById("searchInput");
            const dropdown = document.getElementById("searchDropdown");
            const resultsList = document.getElementById("resultsList");
            const resultDetail = document.getElementById("resultDetail");

            const filterButton = document.getElementById("filterButton");
            const filterDropdown = document.getElementById("filterDropdown");
            const filterText = document.getElementById("filterText");
            let selectedFilter = "";

            filterButton.addEventListener("click", () => {
                filterDropdown.classList.toggle("hidden");
            });

            filterDropdown.querySelectorAll("li").forEach(li => {
                li.addEventListener("click", () => {
                    selectedFilter = li.getAttribute("data-value") ?? "";
                    filterText.textContent = li.textContent;
                    filterDropdown.classList.add("hidden");
                    performSearch();
                });
            });

            function truncateText(text, max = 30) {
                if (!text) return "";
                return text.length > max ? text.slice(0, max) + "..." : text;
            }

            function createDetailCard(item) {
                let artiHTML = Array.isArray(item.arti) ?
                    item.arti.map((a, i) => `<p>${i + 1}. ${a}</p>`).join("") :
                    `<p>${item.arti}</p>`;

                const card = document.createElement("div");
                card.className = "bg-white shadow-md card-rounded p-5 text-left max-w-full overflow-x-auto mt-3";

                card.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold text-blue-600">${item.kata}/${item.suku_kata}</h2>
                            <p class="italic text-gray-500 mb-1">(${item.kelas_kata})</p>
                            <p class="text-gray-500 mb-2"><strong>Sumber Kamus:</strong> ${item.asal_kamus}</p>
                        </div>

                        <!-- BOOKMARK BUTTON (detail) -->
                        <button class="bookmark-btn text-gray-400 hover:text-yellow-400 transition"
                            data-kata="${item.kata}"
                            data-arti="${Array.isArray(item.arti) ? item.arti.join(', ') : item.arti}"
                            data-asal="${item.asal_kamus}"
                            aria-label="Markah kata">
                            <i class="fa-regular fa-bookmark"></i>
                        </button>
                    </div>

                    <div class="text-gray-700 mb-2 max-h-48 overflow-y-auto">
                        <strong>Arti:</strong> ${artiHTML}
                    </div>

                    ${item.contoh ? `<p class="text-sm text-gray-600 italic">Contoh: ${item.contoh}</p>` : ""}
                `;

                // after creating card, ensure icon state is correct
                setTimeout(() => {
                    const btn = card.querySelector(".bookmark-btn");
                    if (btn) setBookmarkIcon(btn, btn.dataset.kata);
                }, 0);

                return card;
            }

            function debounce(func, delay = 200) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func(...args), delay);
                };
            }

            async function performSearch() {
                const keyword = searchInput.value.trim();
                resultsList.innerHTML = "";

                if (!keyword) {
                    dropdown.classList.add("hidden");
                    return;
                }

                try {
                    const res = await fetch(
                        `/search?q=${encodeURIComponent(keyword)}&asal_kamus=${encodeURIComponent(selectedFilter)}&mode=${encodeURIComponent(searchMode)}`
                    );

                    if (!res.ok) throw new Error("Fetch error");
                    const data = await res.json();

                    if (!Array.isArray(data) || data.length === 0) {
                        resultsList.innerHTML = `<li class="p-3 text-gray-500">Tidak ada hasil</li>`;
                        dropdown.classList.remove("hidden");
                        dropdown.classList.add("scale-y-100");
                        return;
                    }

                    resultsList.innerHTML = "";
                    data.slice(0, 50).forEach(item => {
                        const li = document.createElement("li");
                        li.className = "p-3 hover:bg-gray-50 cursor-pointer text-left flex flex-col";
                        li.style.lineHeight = "1.2";

                        li.innerHTML = `
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-semibold text-blue-600">
                                        ${item.kata_highlight}${item.suku_kata ? '/' + item.suku_kata : ''}
                                    </span>
                                    <div class="text-gray-500 text-xs">
                                        (${item.kelas_kata}) • <span class="text-gray-400">${item.asal_kamus}</span>
                                    </div>
                                    <div class="text-gray-700 text-xs mt-1">Arti: ${item.arti_highlight}</div>
                                    ${item.contoh ? `<div class="text-gray-600 text-xs italic">Contoh: ${item.contoh_highlight}</div>` : ''}
                                </div>

                                <!-- BOOKMARK BUTTON DI SETIAP HASIL PENCARIAN -->
                            <button class="bookmark-btn ml-3 text-gray-400 hover:text-yellow-400 transition"
                                    onclick="event.stopPropagation()"
                                    data-kata="${item.kata}"
                                    data-arti="${Array.isArray(item.arti) ? item.arti.join(', ') : item.arti}"
                                    data-asal="${item.asal_kamus}"
                                </button>
                            </div>
                        `;

                        // append then set icon state
                        resultsList.appendChild(li);
                        const btn = li.querySelector(".bookmark-btn");
                        if (btn) setBookmarkIcon(btn, btn.dataset.kata);

                        li.addEventListener("click", (e) => {
                            // If clicked on bookmark button, we already handled it elsewhere
                            if (e.target.closest(".bookmark-btn")) return;

                            const card = createDetailCard(item);
                            resultDetail.innerHTML = "";
                            resultDetail.appendChild(card);
                            resultDetail.classList.remove("hidden");
                            setTimeout(() => {
                                resultDetail.classList.add("opacity-100", "scale-100");
                            }, 50);
                            dropdown.classList.add("hidden");

                            // track search (fire-and-forget)
                            fetch("/track-search", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    id: item.id
                                })
                            }).catch(() => {});
                        });
                    });

                    dropdown.classList.remove("hidden");
                    dropdown.classList.add("scale-y-100");

                } catch (error) {
                    console.error("Error fetching:", error);
                    resultsList.innerHTML = `<li class="p-3 text-red-500">Terjadi kesalahan saat mencari</li>`;
                    dropdown.classList.remove("hidden");
                    dropdown.classList.add("scale-y-100");
                }

            }

            // --- tambahan untuk swap mode ---
            let searchMode = "indo-ke-daerah"; // default
            const swapBtn = document.getElementById("swapBtn");
            const modeLabel = document.getElementById("modeLabel");

            function updateModeUI() {
                if (searchMode === "indo-ke-daerah") {
                    modeLabel.textContent = "IND → DAERAH";
                    searchInput.placeholder = "Cari kata atau arti dalam bahasa Indonesia...";
                } else {
                    modeLabel.textContent = "DAERAH → IND";
                    searchInput.placeholder = "Cari kata atau istilah dalam bahasa daerah...";
                }
            }

            // toggler
            swapBtn.addEventListener("click", () => {
                searchMode = (searchMode === "indo-ke-daerah") ? "daerah-ke-indo" : "indo-ke-daerah";
                updateModeUI();
                // re-run search on mode change (if input punya value)
                if (searchInput.value.trim()) {
                    performSearch();
                }
            });

            // pastikan UI sesuai default saat load
            updateModeUI();

            searchInput.addEventListener("input", debounce(performSearch, 200));

            document.addEventListener("click", (e) => {
                if (!e.target.closest("#searchBox") && !e.target.closest("#filterButton")) {
                    dropdown.classList.add("hidden");
                    dropdown.classList.remove("scale-y-100");
                    filterDropdown.classList.add("hidden");
                }
            });

            // AOS init
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });
        </script>

        <script>
            // ==========================
            // BOOKMARK SYSTEM (clean & synced)
            // ==========================
            function getBookmarks() {
                try {
                    return JSON.parse(localStorage.getItem("bookmarks") || "[]");
                } catch (e) {
                    return [];
                }
            }

            function setBookmarks(list) {
                localStorage.setItem("bookmarks", JSON.stringify(list));
            }

            function isBookmarked(kata) {
                return getBookmarks().some(b => b.kata === kata);
            }

            // toggle bookmark: if exists remove, else add
            function toggleBookmark(data) {
                let bookmarks = getBookmarks();
                const exists = bookmarks.some(b => b.kata === data.kata);
                if (exists) {
                    bookmarks = bookmarks.filter(b => b.kata !== data.kata);
                    setBookmarks(bookmarks);
                    showNotif('deleted');
                } else {
                    bookmarks.push(data);
                    setBookmarks(bookmarks);
                    showNotif('saved');
                }
                // after change, refresh UI
                renderBookmarks();
                updateAllBookmarkIcons();
            }

            function showNotif(type = 'saved') {
                const notif = document.getElementById("bookmarkNotif");
                notif.innerText = type === 'saved' ? "Berhasil ditandai" : "Markah dihapus";
                notif.classList.remove("hidden");
                notif.style.opacity = "1";
                setTimeout(() => {
                    notif.style.opacity = "0";
                    setTimeout(() => notif.classList.add("hidden"), 300);
                }, 1200);
            }

            function renderBookmarks() {
                const bookmarks = getBookmarks();
                const list = document.getElementById("bookmarkList");
                const empty = document.getElementById("bookmarkEmpty");
                list.innerHTML = "";

                if (!bookmarks.length) {
                    empty.classList.remove("hidden");
                    return;
                }
                empty.classList.add("hidden");

                bookmarks.forEach(item => {
                    const div = document.createElement("div");
                    div.className = "p-4 border rounded-xl bg-gray-50 hover:bg-gray-100 transition shadow-sm";

                    div.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="w-[70%]">
                                <div class="font-bold text-blue-700">${item.kata}</div>
                                <div class="text-sm text-gray-700">${item.arti}</div>
                                <div class="text-xs text-gray-400 mt-1">${item.asal}</div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <button class="delete-btn text-red-500 font-semibold hover:text-red-700">Hapus</button>
                            </div>
                        </div>
                    `;

                    // delete handler
                    div.querySelector(".delete-btn").onclick = () => {
                        let updated = getBookmarks().filter(b => b.kata !== item.kata);
                        setBookmarks(updated);
                        renderBookmarks();
                        updateAllBookmarkIcons(); // sync UI
                    };

                    list.appendChild(div);
                });
            }

            // set icon state for a given bookmark button element
            function setBookmarkIcon(btn, kata) {
                if (!btn) return;
                const icon = btn.querySelector("i");
                if (!icon) return;

                if (isBookmarked(kata)) {
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                    btn.classList.add("text-yellow-400");
                } else {
                    icon.classList.remove("fa-solid");
                    icon.classList.add("fa-regular");
                    btn.classList.remove("text-yellow-400");
                }
            }

            // scan all .bookmark-btn and update icons
            function updateAllBookmarkIcons() {
                document.querySelectorAll(".bookmark-btn").forEach(btn => {
                    const kata = btn.dataset.kata;
                    setBookmarkIcon(btn, kata);
                });
            }

            // open/close modal
            document.getElementById("openBookmarkModal").addEventListener("click", () => {
                document.getElementById("bookmarkModal").classList.remove("hidden");
                renderBookmarks();
            });
            document.getElementById("closeBookmarkModal").addEventListener("click", () => {
                document.getElementById("bookmarkModal").classList.add("hidden");
            });

            // central handler: bookmark button toggling (works for list & detail)
            document.addEventListener("click", function(e) {
                const btn = e.target.closest(".bookmark-btn");
                if (!btn) return;

                // Prevent card/LI click handlers
                e.stopPropagation();

                const data = {
                    kata: btn.dataset.kata,
                    arti: btn.dataset.arti,
                    asal: btn.dataset.asal
                };

                // toggle bookmark
                toggleBookmark(data);

                // ensure button shows correct icon immediately
                setBookmarkIcon(btn, data.kata);
            });

            // run once on load to sync any existing bookmarks with UI (if search results present)
            document.addEventListener("DOMContentLoaded", () => {
                updateAllBookmarkIcons();
            });

            // If search results are created after load, caller code already calls setBookmarkIcon per element.
        </script>

    </body>

    </html>
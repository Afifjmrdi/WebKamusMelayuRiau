<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />
    <title>Kamus Balai Bahasa Riau</title>

    @vite(['resources/css/app.css'])

    {{-- Libraries --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        /* Scrollbar */
        #searchDropdown::-webkit-scrollbar {
            width: 5px;
        }

        #searchDropdown::-webkit-scrollbar-track {
            background: transparent;
        }

        #searchDropdown::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Highlight */
        mark {
            background: #ffdd62ff;
            color: #000;
            padding: 0 3px;
            border-radius: 2px;
            font-weight: 700;
        }

        /* Animations */
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

        .star {
            opacity: 0.9;
            transform-origin: center;
            animation: spin-slow 2s linear infinite, twinkle 3s ease-in-out infinite;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
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

        /* Welcome Card Animation */
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

        .welcome-card {
            animation: blueBlink 1.1s infinite ease-in-out;
            transition: opacity .3s;
        }

        @media (max-width: 640px) {
            .welcome-card {
                width: 75%;
                bottom: 1rem;
                right: 1rem;
                padding: .65rem .8rem;
                font-size: .85rem;
            }
        }

        .loading-spinner {
            text-align: center;
            padding: 15px;
            color: #2563eb;
            font-size: 0.8rem;
            font-weight: 600;
        }

        :root {
            --search-height: 60px;
        }

        .card-rounded {
            border-radius: 0.75rem;
        }

        /* Icon Gradients */
        .grad-icon-blue {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .grad-icon-green {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .grad-icon-purple {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .grad-icon-orange {
            background: linear-gradient(135deg, #f97316, #c2410c);
        }
    </style>
</head>

<body class="bg-white scroll-smooth font-montserrat">

    @include('partials.navbar')

    {{-- FIXED BACKGROUND --}}
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none">
        <!-- BACKGROUND IMAGE -->
        <img src="{{ asset('assets/background9.png') }}"
            class="w-full h-full object-cover"
            alt="Background">

        <!-- GRADIENT OVERLAY (gelap bawah → terang atas) -->
        <div class="absolute inset-0 bg-gradient-to-t
                from-black/40
                via-black/10
                to-transparent">
        </div>

        <!-- SPARKLE -->
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 0; $i < 40; $i++)
                @php
                $top=rand(0,95);
                $left=rand(0,95);
                $size=rand(8,16);
                @endphp
                <img src="{{ asset('assets/sparkle.png') }}"
                class="star absolute opacity-0 animate-[twinkle_3s_infinite_ease-in-out]"
                style="
                    top: {{ $top }}%;
                    left: {{ $left }}%;
                    width: {{ $size }}px;
                    height: {{ $size }}px;
                 "
                alt="Star">
                @endfor
        </div>
    </div>


    {{-- NOTIFIKASI TOAST --}}
    <div id="bookmarkNotif" class="hidden fixed top-4 right-20 z-[999] bg-blue-600 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300 font-semibold text-sm">
        Berhasil ditandai
    </div>

    {{-- HALAMAN BERANDA --}}
    <section id="beranda" class="relative min-h-screen flex flex-col items-center justify-start text-white overflow-hidden pt-28 sm:pt-32 md:pt-40 pb-10 px-4 sm:px-6 z-10" data-aos="fade-in" data-aos-duration="1500">

        <div id="mainContainer" class="relative z-10 flex flex-col items-center mt-2 text-center transition-all duration-500 w-full">
            <p id="subtitle" class="text-sm md:text-base tracking-widest text-gray-600 font-semibold mb-1 font-montserrat bg-white/60 px-3 py-1 rounded-full backdrop-blur-sm shadow-sm" data-aos="fade-down" data-aos-delay="200">BALAI BAHASA PROVINSI RIAU</p>

            <h1 id="title" class="text-3xl md:text-5xl font-semibold font-montserrat leading-tight mb-5 text-gray-700 drop-shadow-sm" data-aos="zoom-in" data-aos-delay="400">
                Kamus Elektronik Bahasa <br> Melayu Riau
            </h1>

            {{-- Search Container --}}
            <div id="searchContainer" class="w-full max-w-[850px] mx-auto mt-[5px]" data-aos="fade-up" data-aos-delay="600">
                <div id="searchBox" class="relative w-full grid grid-cols-1 md:grid-cols-[1fr_auto_auto] gap-2">

                    {{-- INPUT SEARCH --}}
                    <div class="flex items-center bg-white rounded-lg shadow-lg border border-gray-200 w-full relative" style="height: var(--search-height);">
                        <div class="px-2 text-gray-500 flex items-center">
                            <i class="fa-solid fa-magnifying-glass text-blue-600 ml-2"></i>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari kata atau arti dalam bahasa Indonesia..." class="w-full px-2 outline-none text-gray-700 font-medium text-sm sm:text-base h-full bg-transparent" autocomplete="off" />

                        {{-- Loading Spinner Input --}}
                        <div id="inputLoader" class="absolute right-4 text-blue-500 hidden">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex gap-2 w-full md:w-auto h-[var(--search-height)]">
                        <button id="swapBtn" type="button" class="bg-white border border-gray-200 shadow-md rounded-lg px-4 text-gray-600 text-sm flex items-center justify-center whitespace-nowrap font-semibold h-full min-w-[120px] hover:bg-gray-50 transition">
                            <span id="modeLabel">IND → DAERAH</span>
                        </button>

                        <div class="relative flex-1 md:flex-none h-full md:w-[180px]">
                            <button id="filterButton" type="button" class="w-full h-full bg-white border border-gray-200 shadow-md rounded-lg px-4 text-blue-600 font-semibold text-sm flex items-center justify-between hover:bg-gray-50 transition group">
                                <span id="filterText" class="whitespace-nowrap overflow-hidden text-ellipsis min-w-[100px] max-w-[160px]">Semua Kamus</span>
                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs ml-2 group-hover:text-blue-600 transition-colors"></i>
                            </button>

                            {{-- Dropdown Modern --}}
                            <ul id="filterDropdown" class="absolute right-0 mt-2 min-w-[260px] max-w-[330px] bg-white border border-gray-200 rounded-xl shadow-xl hidden z-50 overflow-hidden ring-1 ring-black/5">
                                <li class="filter-item px-4 py-3 hover:bg-blue-50 cursor-pointer text-gray-700 text-sm font-bold flex items-center gap-2 transition-colors border-l-4 border-transparent hover:border-blue-500" data-value="">
                                    <i class="fa-solid fa-layer-group text-blue-400"></i> Semua Kamus
                                </li>
                                <div class="h-px bg-gray-100 my-0"></div>
                                @foreach ($daftarAsalKamus as $kamus)
                                <li class="filter-item px-4 py-2.5 hover:bg-blue-50 cursor-pointer text-gray-600 text-sm flex items-center justify-between transition-colors border-l-4 border-transparent hover:border-blue-400" data-value="{{ $kamus }}">
                                    <span>{{ str_replace('Kamus Indonesia - ', '', $kamus) }}</span>
                                    <i class="fa-solid fa-check text-blue-600 text-xs opacity-0 check-icon"></i>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Dropdown Hasil --}}
                <div id="searchDropdown" class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg hidden transition-all duration-500 transform origin-top scale-y-0 max-h-[400px] overflow-y-auto relative z-40">
                    <ul id="resultsList" class="divide-y divide-gray-200"></ul>
                    <div id="loadingIndicator" class="loading-spinner hidden border-t border-gray-100 bg-gray-50">
                        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Memuat data...
                    </div>
                </div>

                {{-- Detail Hasil --}}
                <div id="resultDetail" class="mt-4 hidden opacity-0 transform scale-95 transition-all duration-500 w-full max-w-[850px] mx-auto relative z-40"></div>

                {{-- Info Cards --}}
                <div id="cardContainer" class="w-full max-w-[850px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6" data-aos="fade-up" data-aos-delay="800">
                    {{-- Card Siak --}}
                    <div class="bg-white/90 backdrop-blur-sm shadow-md hover:shadow-xl p-4 rounded-xl text-center cursor-pointer border border-white/50 transition duration-300 hover:-translate-y-1 group relative overflow-hidden">
                        <div class="mx-auto mb-2 w-9 h-9 rounded-lg grad-icon-blue flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-book-atlas text-sm"></i>
                        </div>
                        <h3 class="text-blue-700 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                        <p class="text-gray-500 text-xs leading-snug mt-1">Kamus Indonesia-<br><span class="font-semibold text-gray-700">Melayu Siak</span></p>
                    </div>

                    {{-- Card Rohil --}}
                    <div class="bg-white/90 backdrop-blur-sm shadow-md hover:shadow-xl p-4 rounded-xl text-center cursor-pointer border border-white/50 transition duration-300 hover:-translate-y-1 group relative overflow-hidden">
                        <div class="mx-auto mb-2 w-9 h-9 rounded-lg grad-icon-green flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-scroll text-sm"></i>
                        </div>
                        <h3 class="text-green-600 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                        <p class="text-gray-500 text-xs leading-snug mt-1">Kamus Indonesia-<br><span class="font-semibold text-gray-700">Melayu Rokan Hilir</span></p>
                    </div>

                    {{-- Card Kuansing --}}
                    <div class="bg-white/90 backdrop-blur-sm shadow-md hover:shadow-xl p-4 rounded-xl text-center cursor-pointer border border-white/50 transition duration-300 hover:-translate-y-1 group relative overflow-hidden">
                        <div class="mx-auto mb-2 w-9 h-9 rounded-lg grad-icon-purple flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-feather-pointed text-sm"></i>
                        </div>
                        <h3 class="text-purple-600 font-bold text-sm md:text-base">7.000+ Kosakata</h3>
                        <p class="text-gray-500 text-xs leading-snug mt-1">Kamus Indonesia-<br><span class="font-semibold text-gray-700">Melayu Kuantan Singingi</span></p>
                    </div>

                    {{-- Card Total --}}
                    <div class="bg-white/90 backdrop-blur-sm shadow-md hover:shadow-xl p-4 rounded-xl text-center cursor-pointer border border-white/50 transition duration-300 hover:-translate-y-1 group relative overflow-hidden">
                        <div class="mx-auto mb-2 w-9 h-9 rounded-lg grad-icon-orange flex items-center justify-center text-white shadow-md group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-layer-group text-sm"></i>
                        </div>
                        <h3 class="text-orange-600 font-bold text-sm md:text-base">20.000+ Kosakata</h3>
                        <p class="text-gray-500 text-xs leading-snug mt-1">Total Keseluruhan<br><span class="font-semibold text-gray-700">Kamus Bahasa Daerah</span></p>
                    </div>
                </div>
            </div>

            {{-- Welcome Card --}}
            <div id="welcomeCard" class="welcome-card fixed bottom-5 right-5 w-64 bg-white/95 backdrop-blur shadow-lg rounded-xl p-4 flex items-center gap-3 border border-slate-200 z-50">
                <img src="{{ asset('assets/bb2.png') }}" class="w-10 h-10 object-contain drop-shadow-sm">
                <div class="flex-1 text-left">
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-0.5">Selamat Datang</p>
                    <p class="text-xs font-bold text-blue-700 leading-tight">Kamus Elektronik Bahasa Melayu Riau</p>
                </div>
                <button onclick="closeWelcomeCard()" class="text-gray-400 hover:text-red-500 transition text-sm font-bold ml-1">✕</button>
            </div>
        </div>
    </section>

    @include('partials.informasi')
    @include('partials.kosakatamenarik', ['kosakataHariIni' => $kosakataHariIni])
    @include('partials.footer')

    <script>
        function closeWelcomeCard() {
            const card = document.getElementById('welcomeCard');
            if (!card) return;
            card.style.opacity = '0';
            setTimeout(() => card.remove(), 300);
            sessionStorage.setItem('hideWelcomeCard', 'true');
        }
        window.addEventListener('load', () => {
            if (sessionStorage.getItem('hideWelcomeCard') === 'true') {
                const card = document.getElementById('welcomeCard');
                if (card) card.remove();
            }
        });

        // ==========================
        // SYSTEM PENCARIAN & BOOKMARK
        // ==========================
        const searchInput = document.getElementById("searchInput");
        const dropdown = document.getElementById("searchDropdown");
        const resultsList = document.getElementById("resultsList");
        const resultDetail = document.getElementById("resultDetail");
        const loadingIndicator = document.getElementById("loadingIndicator");
        const inputLoader = document.getElementById("inputLoader");

        const filterButton = document.getElementById("filterButton");
        const filterDropdown = document.getElementById("filterDropdown");
        const filterText = document.getElementById("filterText");

        let selectedFilter = "";
        let searchMode = "indo-ke-daerah";
        let currentPage = 1;
        let isLoading = false;
        let hasMoreData = true;
        let currentKeyword = "";

        // UI Event Listeners
        filterButton.addEventListener("click", () => {
            filterDropdown.classList.toggle("hidden");
        });

        filterDropdown.querySelectorAll(".filter-item").forEach(li => {
            li.addEventListener("click", () => {
                filterDropdown.querySelectorAll(".check-icon").forEach(el => el.classList.add("opacity-0"));
                const check = li.querySelector(".check-icon");
                if (check) check.classList.remove("opacity-0");

                selectedFilter = li.getAttribute("data-value") ?? "";

                const spanText = li.querySelector("span") ? li.querySelector("span").innerText : li.innerText;
                filterText.innerText = spanText.trim();

                filterDropdown.classList.add("hidden");
                if (searchInput.value.trim()) triggerSearch(true);
            });
        });

        document.addEventListener("click", (e) => {
            if (!e.target.closest("#searchBox") && !e.target.closest("#filterButton")) {
                dropdown.classList.add("hidden");
                dropdown.classList.remove("scale-y-100");
                filterDropdown.classList.add("hidden");
            }
        });

        function escapeHtmlAttr(str) {
            if (typeof str !== 'string') return str;
            return str.replace(/"/g, '&quot;');
        }

        // --- DETAIL CARD GENERATOR ---
        function createDetailCard(item) {
            let artiHTML = Array.isArray(item.arti) ?
                item.arti.map((a, i) => `<p class="mb-1">${i + 1}. ${a}</p>`).join("") :
                `<p>${item.arti}</p>`;

            const card = document.createElement("div");
            card.className = "bg-white shadow-lg card-rounded p-6 text-left max-w-full overflow-x-auto mt-3 border border-gray-200 relative animate-fadeIn";

            const safeKata = escapeHtmlAttr(item.kata);
            const safeArti = escapeHtmlAttr(Array.isArray(item.arti) ? item.arti.join(', ') : item.arti);
            const safeAsal = escapeHtmlAttr(item.asal_kamus);

            card.innerHTML = `
                <button onclick="this.parentElement.remove(); document.getElementById('searchDropdown').classList.remove('hidden');" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <div class="flex justify-between items-start pr-8">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-700">${item.kata}${item.suku_kata ? ' / ' + item.suku_kata : ''}</h2>
                        <div class="flex items-center gap-2 mt-1 mb-3">
                            <span class="bg-blue-100 text-blue-600 text-xs font-bold px-2 py-0.5 rounded uppercase">${item.kelas_kata}</span>
                            <span class="text-gray-400 text-xs">|</span>
                            <span class="text-gray-500 text-xs italic">${item.asal_kamus}</span>
                        </div>
                    </div>
                    
                    {{-- TOMBOL BOOKMARK DETAIL --}}
                    <button class="bookmark-btn w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition shadow-sm border border-slate-100"
                        type="button"
                        data-kata="${safeKata}"
                        data-arti="${safeArti}"
                        data-asal="${safeAsal}">
                        <i class="fa-regular fa-bookmark text-lg"></i>
                    </button>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-3 border border-gray-100">
                    <strong class="text-gray-500 text-xs uppercase tracking-wider block mb-1">Makna / Arti</strong>
                    <div class="text-gray-800 text-sm leading-relaxed">${artiHTML}</div>
                </div>

                ${item.contoh ? `
                <div class="pl-3 border-l-4 border-blue-200 mt-2">
                    <strong class="text-gray-500 text-xs uppercase tracking-wider block mb-1">Contoh Penggunaan</strong>
                    <p class="text-sm text-gray-600 italic">"${item.contoh}"</p>
                </div>` : ""}
            `;

            setTimeout(() => {
                const btn = card.querySelector(".bookmark-btn");
                if (btn) setBookmarkIcon(btn, btn.dataset.kata);
            }, 0);

            return card;
        }

        // --- FETCH RESULTS ---
        async function fetchResults(isNewSearch = false) {
            if (isLoading) return;
            if (!hasMoreData && !isNewSearch) return;

            isLoading = true;
            if (isNewSearch) {
                currentPage = 1;
                hasMoreData = true;
                resultsList.innerHTML = "";
                dropdown.scrollTop = 0;
                inputLoader.classList.remove("hidden");
            } else {
                loadingIndicator.classList.remove("hidden");
            }

            try {
                const url = `/search?q=${encodeURIComponent(currentKeyword)}&asal_kamus=${encodeURIComponent(selectedFilter)}&mode=${encodeURIComponent(searchMode)}&page=${currentPage}`;
                const res = await fetch(url);
                if (!res.ok) throw new Error("Fetch error");

                const responseData = await res.json();
                const items = responseData.data ? responseData.data : responseData;

                if (!Array.isArray(items) || items.length === 0) {
                    if (isNewSearch) resultsList.innerHTML = `<li class="p-4 text-center text-gray-500 text-sm italic">Tidak ada hasil ditemukan</li>`;
                    hasMoreData = false;
                } else {
                    hasMoreData = !!responseData.next_page_url;
                    currentPage++;

                    items.forEach(item => {
                        const li = document.createElement("li");
                        li.className = "p-3 hover:bg-gray-50 cursor-pointer text-left flex flex-col border-b border-gray-100 last:border-0 transition group relative";

                        const displayKata = item.kata_highlight || item.kata;
                        const displayArti = item.arti_highlight || item.arti;
                        const displayContoh = item.contoh_highlight || item.contoh;

                        const safeKata = escapeHtmlAttr(item.kata);
                        const safeArti = escapeHtmlAttr(Array.isArray(item.arti) ? item.arti.join(', ') : item.arti);
                        const safeAsal = escapeHtmlAttr(item.asal_kamus);

                        li.innerHTML = `
                            <div class="flex justify-between items-start">
                                <div class="flex-1 pr-12">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="font-bold text-blue-700 text-sm">${displayKata}</span>
                                        ${item.suku_kata ? `<span class="text-xs text-gray-400 font-mono bg-gray-100 px-1 rounded border border-gray-200">${item.suku_kata}</span>` : ''}
                                    </div>
                                    <div class="text-xs text-gray-600 line-clamp-2 mb-1 leading-relaxed">
                                        <span class="font-bold text-gray-400 text-[10px] uppercase mr-1">Makna:</span>${displayArti}
                                    </div>
                                    ${displayContoh ? `
                                        <div class="text-[11px] text-gray-500 italic pl-2 border-l-2 border-blue-100 mb-1">
                                            <span class="font-bold text-gray-400 text-[9px] uppercase mr-1 not-italic">Contoh:</span>"${displayContoh}"
                                        </div>` : ''}
                                    <div class="flex items-center gap-1.5 text-[10px] uppercase font-bold tracking-wide text-gray-400 mt-1">
                                        <span class="bg-gray-100 px-1 rounded border border-gray-200">${item.kelas_kata}</span>
                                        <span>•</span>
                                        <span class="truncate max-w-[150px]">${item.asal_kamus}</span>
                                    </div>
                                </div>
                                
                                {{-- TOMBOL BOOKMARK LIST --}}
                                <button class="bookmark-btn"
                                        type="button"
                                        onclick="event.stopPropagation()" 
                                        data-kata="${safeKata}"
                                        data-arti="${safeArti}"
                                        data-asal="${safeAsal}">
                                </button>
                            </div>
                        `;

                        resultsList.appendChild(li);

                        const btn = li.querySelector(".bookmark-btn");
                        if (btn) setBookmarkIcon(btn, btn.dataset.kata);

                        li.addEventListener("click", (e) => {
                            if (e.target.closest(".bookmark-btn")) return;
                            const card = createDetailCard(item);
                            resultDetail.innerHTML = "";
                            resultDetail.appendChild(card);
                            resultDetail.classList.remove("hidden");
                            setTimeout(() => {
                                resultDetail.classList.add("opacity-100", "scale-100");
                            }, 50);
                            dropdown.classList.add("hidden");
                        });
                    });
                }

                if (isNewSearch) {
                    dropdown.classList.remove("hidden");
                    dropdown.classList.add("scale-y-100");
                    resultDetail.classList.add("hidden");
                }
            } catch (error) {
                console.error("Error:", error);
                if (isNewSearch) resultsList.innerHTML = `<li class="p-3 text-red-500 text-center text-sm">Gagal memuat data.</li>`;
            } finally {
                isLoading = false;
                loadingIndicator.classList.add("hidden");
                inputLoader.classList.add("hidden");
            }
        }

        function triggerSearch(isNew = true) {
            currentKeyword = searchInput.value.trim();
            if (!currentKeyword) {
                dropdown.classList.add("hidden");
                resultDetail.innerHTML = "";
                return;
            }
            fetchResults(isNew);
        }

        function debounce(func, delay = 300) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), delay);
            };
        }

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

        swapBtn.addEventListener("click", () => {
            searchMode = (searchMode === "indo-ke-daerah") ? "daerah-ke-indo" : "indo-ke-daerah";
            updateModeUI();
            if (searchInput.value.trim()) triggerSearch(true);
        });
        updateModeUI();

        searchInput.addEventListener("input", debounce(() => {
            triggerSearch(true);
        }, 300));
        dropdown.addEventListener("scroll", () => {
            if (dropdown.scrollTop + dropdown.clientHeight >= dropdown.scrollHeight - 50) fetchResults(false);
        });

        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // --- BOOKMARK LOGIC ---
        function getBookmarks() {
            try {
                return JSON.parse(localStorage.getItem("bookmarks") || "[]");
            } catch (e) {
                return [];
            }
        }

        function setBookmarks(list) {
            localStorage.setItem("bookmarks", JSON.stringify(list));
            window.dispatchEvent(new Event('storage'));
        }

        function isBookmarked(kata) {
            return getBookmarks().some(b => b.kata === kata);
        }

        function toggleBookmark(data) {
            let bookmarks = getBookmarks();
            if (bookmarks.some(b => b.kata === data.kata)) {
                bookmarks = bookmarks.filter(b => b.kata !== data.kata);
                setBookmarks(bookmarks);
                showNotif('deleted');
            } else {
                bookmarks.push(data);
                setBookmarks(bookmarks);
                showNotif('saved');
            }
            updateAllBookmarkIcons();
        }

        function showNotif(type = 'saved') {
            const notif = document.getElementById("bookmarkNotif");
            if (notif) {
                notif.innerText = type === 'saved' ? "Berhasil ditandai" : "Markah dihapus";
                notif.classList.remove("hidden");
                notif.style.opacity = "1";
                setTimeout(() => {
                    notif.style.opacity = "0";
                    setTimeout(() => notif.classList.add("hidden"), 300);
                }, 1200);
            }
        }

        function setBookmarkIcon(btn, kata) {
            if (!btn) return;
            const icon = btn.querySelector("i");
            if (!icon) return;
            if (isBookmarked(kata)) {
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid");
                // Style Active: Blue + Bold
                btn.classList.add("text-blue-600", "bg-blue-50", "border-blue-100");
                btn.classList.remove("text-slate-300", "bg-slate-50", "border-slate-100", "text-slate-400");
            } else {
                icon.classList.remove("fa-solid");
                icon.classList.add("fa-regular");
                // Style Inactive: Default Slate
                btn.classList.remove("text-blue-600", "bg-blue-50", "border-blue-100");
                btn.classList.add("text-slate-300", "bg-slate-50", "border-slate-100");
                // Khusus untuk tombol detail yang awalnya slate-400
                if (btn.classList.contains("text-slate-400")) btn.classList.add("text-slate-400");
            }
        }

        function updateAllBookmarkIcons() {
            document.querySelectorAll(".bookmark-btn").forEach(btn => {
                setBookmarkIcon(btn, btn.dataset.kata);
            });
        }

        // GLOBAL HANDLER
        document.addEventListener("click", function(e) {
            const btn = e.target.closest(".bookmark-btn");
            if (!btn) return;
            e.stopPropagation();
            e.preventDefault();
            toggleBookmark({
                kata: btn.dataset.kata,
                arti: btn.dataset.arti,
                asal: btn.dataset.asal
            });
        });

        window.addEventListener('storage', () => {
            updateAllBookmarkIcons();
        });
        document.addEventListener("DOMContentLoaded", () => {
            updateAllBookmarkIcons();
        });
    </script>
</body>

</html>
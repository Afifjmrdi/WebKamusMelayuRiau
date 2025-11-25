{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <title>Kamus Balai Bahasa Riau</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

</head>

<body class="bg-white scroll-smooth">

    {{-- Navbar--}}
    @include('partials.navbar')

    <section id="beranda"
        class="relative min-h-screen flex flex-col items-center justify-start text-white overflow-hidden bg-cover bg-center"
        style="background-image: url('{{ asset('assets/background4.png') }}'); padding-top: 100px;"
        data-aos="fade-in"
        data-aos-duration="1500">

        <div class="absolute inset-0 overflow-hidden">
            {{-- Bintang --}}
            @for ($i = 0; $i < 40; $i++)
                @php
                $top=rand(0, 95);
                $left=rand(0, 95);
                $size=rand(8, 16);
                @endphp
                <img src="{{ asset('assets/sparkle.png') }}"
                class="star absolute opacity-0 animate-[twinkle_3s_infinite_ease-in-out]"
                style="top: {{ $top }}%; left: {{ $left }}%; width: {{ $size }}px; height: {{ $size }}px;"
                alt="Star">
                @endfor
        </div>
        <div id="mainContainer" class="relative z-10 flex flex-col items-center mt-2 text-center transition-all duration-500">
            <p id="subtitle"
                class="text-sm md:text-base tracking-widest text-gray-600 font-semibold mb-1 mt-10"
                data-aos="fade-down"
                data-aos-delay="200">BALAI BAHASA PROVINSI RIAU</p>

            <h1 id="title"
                class="text-3xl md:text-5xl font-extrabold leading-tight mb-5 bg-gradient-to-r from-white-500 bg-clip-text font-poppins text-gray-600"
                data-aos="zoom-in" data-aos-delay="400">
                Kamus Digital Bahasa <br> Daerah Riau
            </h1>
            <div id="searchContainer" class="w-full max-w-[1200px] mx-auto mt-[5px]" data-aos="fade-up" data-aos-delay="600">
                <div id="searchBox" class="relative w-full transition-all duration-500 flex items-center gap-2">
                    <!-- Input Search -->
                    <div class="flex items-center bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 flex-grow">
                        <div class="px-3 text-gray-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari kata dalam bahasa daerah..." class="w-full py-3 px-2 outline-none text-gray-700 font-medium font-poppins" />
                    </div>

                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <button id="filterButton" class="bg-white border border-gray-200 shadow-md rounded-lg px-5 py-3 text-gray-700 font-medium flex items-center gap-7">
                            <span id="filterText">Filter Kamus..</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="filterDropdown" class="absolute right-0 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                            <li class="px-4 py-2 hover:bg-blue-100 cursor-pointer rounded-lg text-gray-600" data-value="">
                                Semua Kamus
                            </li>

                            @foreach($daftarAsalKamus as $kamus)
                            <li class="px-4 py-2 hover:bg-blue-100 cursor-pointer text-gray-600"
                                data-value="{{ $kamus }}">
                                {{ str_replace('Kamus Indonesia - ', '', $kamus) }}
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                <!-- Dropdown hasil pencarian -->
                <div id="searchDropdown" class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg hidden transition-all duration-500 transform origin-top scale-y-0">
                    <ul id="resultsList" class="divide-y divide-gray-200"></ul>
                </div>

                <!-- Card hasil search -->
                <div id="resultDetail" class="mt-4 hidden opacity-0 transform scale-95 transition-all duration-500 w-full max-w-[1200px] mx-auto"></div>

                <!-- Card Informasi Kamus -->
                <div id="cardContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2"
                    data-aos="fade-up" data-aos-delay="800">
                    <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                        <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ KosaKata</h3>
                        <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia -<br>Melayu Siak</p>
                    </div>
                    <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                        <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ KosaKata</h3>
                        <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia -<br>Rokan Hilir</p>
                    </div>
                    <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                        <h3 class="text-blue-600 font-bold text-sm md:text-base">7.000+ KosaKata</h3>
                        <p class="text-gray-600 text-xs md:text-sm leading-snug">Kamus Indonesia -<br>Kuantan Singingi</p>
                    </div>
                    <div class="bg-white shadow-md hover:shadow-lg p-4 rounded-md text-center cursor-pointer">
                        <h3 class="text-blue-600 font-bold text-sm md:text-base">Ada 45.000+ KosaKata</h3>
                        <p class="text-gray-600 text-xs md:text-sm leading-snug">Di Keseluruhan -<br>Kamus</p>
                    </div>
                </div>
            </div>

            <script>
                const searchInput = document.getElementById("searchInput");
                const dropdown = document.getElementById("searchDropdown");
                const resultsList = document.getElementById("resultsList");
                const resultDetail = document.getElementById("resultDetail");

                const filterButton = document.getElementById("filterButton");
                const filterDropdown = document.getElementById("filterDropdown");
                const filterText = document.getElementById("filterText");
                let selectedFilter = ""; // default Semua Kamus

                // filter dropdown toggle
                filterButton.addEventListener("click", () => {
                    filterDropdown.classList.toggle("hidden");
                });

                filterDropdown.querySelectorAll("li").forEach(li => {
                    li.addEventListener("click", () => {
                        selectedFilter = li.getAttribute("data-value");
                        filterText.textContent = li.textContent;
                        filterDropdown.classList.add("hidden");
                        performSearch(); // search ulang sesuai filter
                    });
                });

                function truncateText(text, max = 30) {
                    if (!text) return "";
                    return text.length > max ? text.slice(0, max) + "..." : text;
                }

                function createDetailCard(item) {
                    let artiHTML = Array.isArray(item.arti) ?
                        item.arti.map((a, i) => `<p>${i+1}. ${a}</p>`).join("") :
                        `<p>${item.arti}</p>`;
                    const card = document.createElement("div");
                    card.className = "bg-white shadow-md rounded-lg p-5 text-left max-w-full overflow-x-auto mt-3";
                    card.innerHTML = `
                        <h2 class="text-xl font-bold text-blue-600">${item.kata}/${item.suku_kata}</h2>
                        <p class="italic text-gray-500 mb-1">(${item.kelas_kata})</p>
                        <p class="text-gray-500 mb-2"><strong>Sumber Kamus:</strong> ${item.asal_kamus}</p>
                        <div class="text-gray-700 mb-2 max-h-48 overflow-y-auto"><strong>Arti:</strong>${artiHTML}</div>
                        ${item.contoh?`<p class="text-sm text-gray-600 italic">Contoh: ${item.contoh}</p>`:""}
                    `;
                    return card;
                }

                function debounce(func, delay) {
                    let timeout;
                    return (...args) => {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func(...args), delay);
                    }
                }

                async function performSearch() {
                    const keyword = searchInput.value.trim();
                    resultsList.innerHTML = "";

                    if (!keyword) {
                        dropdown.classList.add("hidden");
                        return;
                    }

                    try {
                        const res = await fetch(`/search?q=${encodeURIComponent(keyword)}&asal_kamus=${encodeURIComponent(selectedFilter)}`);
                        let data = await res.json();

                        // Kalau 1 Data Kamus aja pakai ini
                        // const seen = new Set();
                        // data = data.filter(item => {
                        //     if (seen.has(item.kata.toLowerCase())) return false;
                        //     seen.add(item.kata.toLowerCase());
                        //     return true;
                        // });

                        const seen = new Set();
                        data = data.filter(item => {
                            const key = item.kata.toLowerCase() + "|" + item.asal_kamus;
                            if (seen.has(key)) return false;
                            seen.add(key);
                            return true;
                        });


                        if (data.length === 0) {
                            resultsList.innerHTML = `<li class="p-3 text-gray-500">Tidak ada hasil</li>`;
                        } else {
                            data.slice(0, 100).forEach(item => {
                                const li = document.createElement("li");
                                li.className = "p-3 hover:bg-gray-50 cursor-pointer text-left flex flex-col";
                                li.style.lineHeight = "1.2";
                                li.innerHTML = `
                                    <span class="font-semibold text-blue-600">${item.kata}/${item.suku_kata}</span>
                                    <span class="text-gray-500 text-sm">(${item.kelas_kata})</span>
                                    <span class="text-gray-700 text-xs">Arti: ${truncateText(item.arti)}</span>
                                    <span class="text-gray-700 text-xs">Contoh: ${truncateText(item.contoh)}</span>
                                    <span class="text-gray-500 text-xs">Sumber: ${truncateText(item.asal_kamus, 40)}</span>
                                `;
                                li.addEventListener("click", () => {
                                    const card = createDetailCard(item);
                                    resultDetail.innerHTML = "";
                                    resultDetail.appendChild(card);
                                    resultDetail.classList.remove("hidden");
                                    setTimeout(() => {
                                        resultDetail.classList.add("opacity-100", "scale-100");
                                    }, 50);
                                    dropdown.classList.add("hidden");
                                    dropdown.classList.remove("scale-y-100");
                                });
                                resultsList.appendChild(li);
                            });
                        }

                        dropdown.classList.remove("hidden");
                        dropdown.classList.add("scale-y-100");

                    } catch (error) {
                        console.error("Error fetching data:", error);
                        resultsList.innerHTML = `<li class="p-3 text-red-500">Terjadi kesalahan saat mencari</li>`;
                    }
                }

                searchInput.addEventListener("input", debounce(performSearch, 300));

                document.addEventListener("click", (e) => {
                    if (!e.target.closest("#searchBox") && !e.target.closest("#filterButton")) {
                        dropdown.classList.add("hidden");
                        dropdown.classList.remove("scale-y-100");
                        filterDropdown.classList.add("hidden");
                    }
                });
            </script>
            <script>
                AOS.init({
                    duration: 1000, // durasi animasi (ms)
                    once: true, // animasi hanya muncul sekali
                    offset: 100 // jarak sebelum animasi mulai
                });
            </script>

        </div>
    </section>

    @include('partials.informasi')
    @include('partials.kosakatamenarik', ['kosakataHariIni' => $kosakataHariIni])
    @include('partials.footer')
</body>

</html>
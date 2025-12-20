{{-- resources/views/kamusistilah.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <title>Kamus Istilah - Balai Bahasa Provinsi Riau</title>

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
        /* font utama */
        body {
            font-family: "JetBrains Mono", monospace;
        }

        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        /* animasi bintang */
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

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.9;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* search container (lebar stabil) */
        #searchContainer {
            width: 100%;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* search box */
        #searchBox {
            height: 50px;
        }

        #searchBox input {
            height: 100%;
            padding: 0 12px;
            font-size: 16px;
        }

        #searchBox i {
            font-size: 18px;
        }

        /* dropdown hasil */
        #searchDropdown {
            width: 100%;
            border-radius: 12px;
            max-height: 360px;
            overflow-y: auto;
        }

        /* scrollbar dropdown */
        #searchDropdown::-webkit-scrollbar {
            width: 6px;
        }

        #searchDropdown::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 6px;
        }

        /* hasil pencarian */
        #resultsList li {
            min-height: 3rem;
        }

        #resultsList li mark {
            background: #ffdd62;
            color: #000;
            padding: 0 3px;
            border-radius: 2px;
        }

        /* card detail */
        .card-rounded {
            border-radius: 0.75rem;
        }

        /* ===== FIX ALIGNMENT HASIL PENCARIAN ===== */
        #searchDropdown,
        #resultsList,
        #resultsList li,
        #resultDetail {
            text-align: left;
        }

        /* pastikan isi detail tidak ikut center */
        #resultDetail>div {
            text-align: left;
        }

        .font-jetbrains {
            font-family: "JetBrains Mono", monospace !important;
        }

        /* ===== ANIMASI WELCOME CARD ===== */

        /* animasi nyala biru lembut */
        @keyframes blueBlink {

            0%,
            100% {
                box-shadow: 0 0 0 rgba(37, 99, 235, 0);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 18px rgba(37, 99, 235, 0.55);
                transform: scale(1.01);
            }
        }

        /* animasi masuk halus saat halaman dibuka */
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-card {
            animation:
                fadeSlideIn 0.6s ease-out forwards,
                blueBlink 1.1s ease-in-out infinite;
            border: none
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
    </style>
</head>

<body class="bg-white scroll-smooth">

    @include('partials.navbar')

    {{-- MODAL INFO ISTILAH --}}
    <div id="infoModal"
        class="fixed inset-0 hidden bg-black/40 z-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">

            <button id="closeInfoModal"
                class="absolute top-3 right-4 text-gray-400 hover:text-red-500 text-xl font-bold">
                ×
            </button>

            <h3 id="infoTitle"
                class="text-lg font-bold text-blue-600 mb-4">
                Informasi Istilah
            </h3>

            <div class="space-y-2 text-sm text-gray-700">
                <p><strong>Kode Entri:</strong> <span id="infoKode">-</span></p>
                <p><strong>Bahasa Daerah:</strong> <span id="infoBahasa">-</span></p>
                <p><strong>Sumber:</strong> <span id="infoSumber">-</span></p>
                <p><strong>Jenis:</strong> <span id="infoJenis">-</span></p>
                <p><strong>Label Bahasa:</strong> <span id="infoLabel">-</span></p>
            </div>
        </div>
    </div>

    <section
        class="relative min-h-screen flex flex-col items-center justify-start overflow-hidden bg-cover bg-center
           pt-28 sm:pt-32 md:pt-36 pb-16 px-4 sm:px-6"
        style="background-image: url('{{ asset('assets/background4.png') }}');"
        data-aos="fade-in">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for ($i = 0; $i < 40; $i++)
                @php $top=rand(0,95); $left=rand(0,95); $size=rand(8,16); @endphp
                <img src="{{ asset('assets/sparkle.png') }}" class="star absolute"
                style="top:{{ $top }}%; left:{{ $left }}%; width:{{ $size }}px;">
                @endfor
        </div>

        <div class="relative z-10 flex flex-col items-center text-center w-full">
            <p id="subtitle"
                class="text-sm md:text-base tracking-widest text-gray-600 font-semibold mb-1"
                data-aos="fade-down">
                BALAI BAHASA PROVINSI RIAU
            </p>

            <h1 id="title"
                class="text-3xl md:text-5xl font-semibold font-montserrat leading-tight mb-5 text-gray-600"
                data-aos="zoom-in">
                Kamus Istilah Bahasa <br> Melayu Riau
            </h1>

            <div id="searchContainer" class="w-full max-w-[1200px] mx-auto mt-2 text-left">
                <div id="searchBox" class="flex items-center bg-white rounded-lg shadow-lg border border-gray-200">
                    <div class="px-2 text-gray-500">
                        <i class="fa-solid fa-magnifying-glass text-blue-600"></i>
                    </div>
                    <input id="searchInput" type="text"
                        placeholder="Cari entri atau makna dalam bahasa melayu..."
                        class="w-full px-2 outline-none text-gray-700 font-medium">
                </div>

                <div id="searchDropdown"
                    class="mt-2 bg-white border border-gray-200 shadow-lg hidden
                        transition-all duration-300 transform origin-top scale-y-0">
                    <ul id="resultsList" class="divide-y divide-gray-200"></ul>
                </div>

                <div id="resultDetail"
                    class="mt-4 hidden opacity-0 transform scale-95 transition-all duration-300"></div>
            </div>
        </div>

        {{-- Welcome Card --}}
        <div id="welcomeCard" class="welcome-card fixed bottom-5 right-5 w-64 bg-white shadow-lg rounded-xl p-4 flex items-center gap-3 border border-dark-100 z-50">
            <img src="{{ asset('assets/bb2.png') }}" class="w-14 h-14 object-contain drop-shadow-md">
            <div class="flex-1">
                <p class="text-sm font-semibold text-blue-700 leading-tight">Selamat Datang di Kamus Istilah Melayu Riau!</p>
            </div>
            <button onclick="closeWelcomeCard()" class="text-gray-400 hover:text-red-500 transition text-sm font-bold ml-1">✕</button>
        </div>

    </section>

    @include('partials.footer')

    <script>
        // WELCOME CARD
        function closeWelcomeCard() {
            const card = document.getElementById('welcomeCard');
            if (!card) return;

            card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateY(12px) scale(0.98)';

            setTimeout(() => card.remove(), 300);
            sessionStorage.setItem('hideWelcomeCard', 'true');
        }
        window.addEventListener('load', () => {
            const card = document.getElementById('welcomeCard');
            if (!card) return;

            if (sessionStorage.getItem('hideWelcomeCard') === 'true') {
                card.remove();
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(14px)';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 300);
            }
        });
    </script>

    <script>
        const searchInput = document.getElementById("searchInput");
        const dropdown = document.getElementById("searchDropdown");
        const resultsList = document.getElementById("resultsList");
        const resultDetail = document.getElementById("resultDetail");

        function debounce(fn, delay = 250) {
            let t;
            return (...args) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...args), delay);
            }
        }

        function escapeRegex(text) {
            return text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function highlight(text, keyword) {
            if (!keyword) return text;

            const escaped = escapeRegex(keyword);
            const regex = new RegExp(`(${escaped})`, 'gi');

            return text.replace(regex, '<mark>$1</mark>');
        }

        async function performSearch() {
            const q = searchInput.value.trim();
            resultsList.innerHTML = "";

            if (!q) {
                dropdown.classList.add("hidden");
                dropdown.classList.remove("scale-y-100");
                return;
            }

            const res = await fetch(`/search-istilah?q=${encodeURIComponent(q)}`);
            const data = await res.json();

            if (!data.length) {
                resultsList.innerHTML =
                    `<li class="p-2 text-gray-500 text-sm flex items-center justify-center">
        Tidak ada hasil ditemukan
    </li>`;
            } else {
                data.forEach(item => {

                    const keyword = q; // keyword aktif

                    const entriHL = highlight(item.entri ?? '-', keyword);
                    const maknaHL = highlight(item.makna_entri ?? '-', keyword);
                    const lafalHL = highlight(item.lafal ?? '-', keyword);

                    const li = document.createElement("li");
                    li.className = "p-4 hover:bg-gray-50 cursor-pointer";

                    li.innerHTML = `
        <div class="flex justify-between items-start gap-3">
            <div>
                <div class="font-semibold text-blue-600">${entriHL}</div>

                <div class="text-xs italic text-gray-500">
                    Pelafalan: ${lafalHL}
                </div>

                <div class="text-xs text-gray-400">
                    (${item.kelas_kata ?? '-'})
                </div>

                <div class="text-sm text-gray-600">
                    Makna: ${maknaHL}
                </div>
            </div>

            <!-- ICON INFO -->
            <button class="info-btn text-blue-500 hover:text-blue-700"
                title="Informasi istilah">
                <i class="fa-solid fa-circle-info"></i>
            </button>
        </div>
    `;


                    li.onclick = () => {
                        resultDetail.innerHTML = `
    <div class="bg-white shadow-md card-rounded p-6 text-left relative">

        <!-- ICON INFO -->
        <button
            class="absolute top-4 right-4 text-blue-500 hover:text-blue-700 info-btn-detail"
            title="Informasi istilah">
            <i class="fa-solid fa-circle-info text-lg"></i>
        </button>

        <h2 class="text-xl font-bold text-blue-600 mb-1">
            ${item.entri}
        </h2>

        <p class="italic text-gray-500 mb-1">
            Pelafalan: ${item.lafal ?? '-'}
        </p>

        <p class="text-sm text-gray-400 mb-2">
            Kelas Kata: ${item.kelas_kata ?? '-'}
        </p>

        <p class="text-gray-700 leading-relaxed">
            Makna: ${item.makna_entri}
        </p>
    </div>
    `;
                        resultDetail.classList.remove("hidden");
                        setTimeout(() => {
                            resultDetail.classList.add("opacity-100", "scale-100");
                        }, 50);

                        dropdown.classList.add("hidden");

                        /* ===== AKTIFKAN ICON INFO DI DETAIL ===== */
                        const infoBtnDetail = resultDetail.querySelector(".info-btn-detail");
                        infoBtnDetail.addEventListener("click", (e) => {
                            e.stopPropagation(); // ⛔ jangan trigger apa pun
                            openInfoModal(item);
                        });
                    };


                    resultsList.appendChild(li);

                    li.querySelector(".info-btn").addEventListener("click", (e) => {
                        e.stopPropagation(); // ⛔ jangan trigger detail
                        openInfoModal(item);
                    });

                });
            }

            dropdown.classList.remove("hidden");
            dropdown.classList.add("scale-y-100");
        }

        searchInput.addEventListener("input", debounce(performSearch, 200));

        document.addEventListener("click", (e) => {

            // JIKA MODAL INFO SEDANG AKTIF → JANGAN APA-APA
            if (!infoModal.classList.contains("hidden")) return;

            if (!e.target.closest("#searchBox") &&
                !e.target.closest("#searchDropdown")) {

                dropdown.classList.add("hidden");
                dropdown.classList.remove("scale-y-100");
            }
        });


        AOS.init({
            once: true
        });

        const infoModal = document.getElementById("infoModal");

        function closeInfo() {
            infoModal.classList.add("hidden");

            // KEMBALIKAN DROPDOWN JIKA SEBELUMNYA ADA
            if (dropdownWasOpen && searchInput.value.trim()) {
                dropdown.classList.remove("hidden");
                dropdown.classList.add("scale-y-100");
            }
        }


        function openInfoModal(item) {

            // SIMPAN STATUS DROPDOWN
            dropdownWasOpen = !dropdown.classList.contains("hidden");

            document.getElementById("infoKode").textContent = item.kode_entri ?? "-";
            document.getElementById("infoBahasa").textContent = item.bahasa_daerah ?? "-";
            document.getElementById("infoSumber").textContent = item.sumber ?? "-";
            document.getElementById("infoJenis").textContent = item.jenis ?? "-";
            document.getElementById("infoLabel").textContent = item.label_bahasa ?? "-";

            infoModal.classList.remove("hidden");
        }


        function closeInfo() {
            infoModal.classList.add("hidden");

            // KEMBALIKAN DROPDOWN JIKA SEBELUMNYA ADA
            if (dropdownWasOpen && searchInput.value.trim()) {
                dropdown.classList.remove("hidden");
                dropdown.classList.add("scale-y-100");
            }
        }


        closeInfoModal.addEventListener("click", (e) => {
            e.stopPropagation();
            closeInfo();
        });

        infoModal.addEventListener("click", (e) => {
            if (e.target === infoModal) {
                closeInfo();
            }
        });

        // Cegah Informasi Bocor ke browser tertentu
        infoModal.addEventListener("mousedown", e => e.stopPropagation());
        infoModal.addEventListener("mouseup", e => e.stopPropagation());
    </script>

</body>

</html>
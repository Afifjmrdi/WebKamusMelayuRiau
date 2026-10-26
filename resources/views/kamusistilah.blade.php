<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />
    <title>Kamus Istilah - Balai Bahasa Provinsi Riau</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        #searchDropdown::-webkit-scrollbar {
            width: 4px;
        }

        #searchDropdown::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Sizing Form & Cards */
        .wide-card {
            max-width: 750px;
            width: 100%;
        }

        :root {
            --search-height: 58px;
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Gradients for Info Cards */
        .grad-blue {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
        }

        .grad-emerald {
            background: linear-gradient(135deg, #10b981, #065f46);
        }

        .grad-amber {
            background: linear-gradient(135deg, #f59e0b, #b45309);
        }

        .grad-rose {
            background: linear-gradient(135deg, #f43f5e, #9f1239);
        }
    </style>
</head>

<body class="bg-white scroll-smooth">

    @include('partials.navbar')

    {{-- FIXED BACKGROUND --}}
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none">
        <img src="{{ asset('assets/background9.png') }}" class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
    </div>

    <div id="bookmarkNotif" class="hidden fixed top-0 opacity-0 pointer-events-none"></div>

    <section class="relative min-h-screen flex flex-col items-center justify-start pt-24 md:pt-32 pb-20 px-4 z-10">

        {{-- HEADER --}}
        <div id="mainContainer" class="relative z-10 flex flex-col items-center text-center w-full transition-all duration-500">

            <p id="subtitle" class="text-[10px] md:text-xs tracking-[0.2em] text-gray-600 font-bold mb-3 font-montserrat bg-white/60 px-4 py-1.5 rounded-full backdrop-blur-sm shadow-sm inline-block mx-auto uppercase" data-aos="fade-down" data-aos-delay="200">
                BALAI BAHASA PROVINSI RIAU
            </p>

            <h1 id="title" class="text-2xl md:text-5xl font-semibold font-montserrat leading-tight mb-8 text-gray-700 drop-shadow-sm text-center mx-auto block w-full" data-aos="zoom-in" data-aos-delay="400">
                Kamus Istilah Bahasa <br> Melayu Riau
            </h1>

            {{-- SEARCH FORM --}}
            <div class="wide-card mx-auto px-2" data-aos="fade-up" data-aos-delay="600">
                <div class="relative flex items-center bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden" style="height: var(--search-height);">
                    <div class="pl-5 pr-2 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </div>
                    <input id="searchInput" type="text" placeholder="Cari istilah melayu..."
                        class="w-full h-full outline-none text-slate-700 font-semibold text-sm md:text-base" autocomplete="off" />
                    <div id="inputLoader" class="px-5 text-blue-500 hidden">
                        <i class="fa-solid fa-circle-notch fa-spin text-lg"></i>
                    </div>
                </div>

                {{-- DROPDOWN HASIL --}}
                <div id="searchDropdown" class="mt-2 bg-white border border-slate-200 rounded-xl shadow-2xl hidden transition-all duration-300 transform origin-top scale-y-0 max-h-[300px] overflow-y-auto relative z-40 text-left">
                    <ul id="resultsList" class="divide-y divide-slate-50"></ul>
                </div>

                {{-- DETAIL CARD --}}
                <div id="resultDetail" class="mt-6 hidden opacity-0 transform scale-95 transition-all duration-500 w-full relative z-40">
                </div>

                {{-- INFORMASI TAMBAHAN CARDS (LEBIH RAMPING) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-10">

                    {{-- Card Budaya --}}
                    <div class="bg-white/85 backdrop-blur p-5 rounded-xl border border-white/50 shadow-md transition hover:-translate-y-1 text-center" data-aos="fade-up" data-aos-delay="700">
                        <div class="mx-auto w-10 h-10 rounded-lg grad-blue flex items-center justify-center text-white mb-3 shadow-sm">
                            <i class="fa-solid fa-landmark text-sm"></i>
                        </div>
                        <p class="text-[9px] font-bold text-blue-500 tracking-widest mb-1">Budaya</p>
                        <h4 class="text-slate-800 font-bold text-xs mb-2">Adat Istiadat</h4>
                        <p class="text-[10px] text-slate-500 leading-relaxed italic">Istilah seputar tradisi, hukum adat, dan tata krama Melayu.</p>
                    </div>

                    {{-- Card Alam --}}
                    <div class="bg-white/85 backdrop-blur p-5 rounded-xl border border-white/50 shadow-md transition hover:-translate-y-1 text-center" data-aos="fade-up" data-aos-delay="800">
                        <div class="mx-auto w-10 h-10 rounded-lg grad-emerald flex items-center justify-center text-white mb-3 shadow-sm">
                            <i class="fa-solid fa-leaf text-sm"></i>
                        </div>
                        <p class="text-[9px] font-bold text-emerald-500 tracking-widest mb-1">Alam</p>
                        <h4 class="text-slate-800 font-bold text-xs mb-2">Flora & Fauna</h4>
                        <p class="text-[10px] text-slate-500 leading-relaxed italic">Nama lokal tanaman, hewan, dan fenomena alam di Bumi Riau.</p>
                    </div>

                    {{-- Card Kuliner --}}
                    <div class="bg-white/85 backdrop-blur p-5 rounded-xl border border-white/50 shadow-md transition hover:-translate-y-1 text-center" data-aos="fade-up" data-aos-delay="900">
                        <div class="mx-auto w-10 h-10 rounded-lg grad-amber flex items-center justify-center text-white mb-3 shadow-sm">
                            <i class="fa-solid fa-utensils text-sm"></i>
                        </div>
                        <p class="text-[9px] font-bold text-amber-500 tracking-widest mb-1">Kuliner</p>
                        <h4 class="text-slate-800 font-bold text-xs mb-2">Tradisi Rasa</h4>
                        <p class="text-[10px] text-slate-500 leading-relaxed italic">Kosakata masakan khas, bahan bumbu, dan peralatan dapur lama.</p>
                    </div>

                    {{-- Card Seni --}}
                    <div class="bg-white/85 backdrop-blur p-5 rounded-xl border border-white/50 shadow-md transition hover:-translate-y-1 text-center" data-aos="fade-up" data-aos-delay="1000">
                        <div class="mx-auto w-10 h-10 rounded-lg grad-rose flex items-center justify-center text-white mb-3 shadow-sm">
                            <i class="fa-solid fa-masks-theater text-sm"></i>
                        </div>
                        <p class="text-[9px] font-bold text-rose-500 tracking-widest mb-1">Seni</p>
                        <h4 class="text-slate-800 font-bold text-xs mb-2">Warisan Klasik</h4>
                        <p class="text-[10px] text-slate-500 leading-relaxed italic">Istilah dalam seni tari, musik, ukiran, dan sastra lisan Melayu.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- MODAL INFO DATA --}}
    <div id="modalInfo" class="fixed inset-0 z-[1000] hidden items-center justify-center p-4">
        <div class="fixed inset-0 backdrop-filter blur-sm bg-slate-900/30" onclick="closeInfoModal()"></div>
        <div class="bg-white relative w-full max-w-sm rounded-xl shadow-2xl border border-slate-100 p-6 animate-fadeIn">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shadow-sm"><i class="fa-solid fa-circle-info text-lg"></i></div>
                <h4 class="text-base font-bold text-slate-800">Informasi Teknis</h4>
            </div>
            <div id="infoContent" class="space-y-2.5"></div>
            <button onclick="closeInfoModal()" class="mt-6 w-full py-3 bg-slate-900 hover:bg-blue-600 text-white font-bold rounded-lg transition-all text-[10px] uppercase tracking-widest shadow-lg">Tutup</button>
        </div>
    </div>

    @include('partials.footer')

    <script>
        const searchInput = document.getElementById("searchInput");
        const dropdown = document.getElementById("searchDropdown");
        const resultsList = document.getElementById("resultsList");
        const resultDetail = document.getElementById("resultDetail");
        const inputLoader = document.getElementById("inputLoader");
        const modalInfo = document.getElementById("modalInfo");
        const infoContent = document.getElementById("infoContent");

        let currentKeyword = "";
        let isLoading = false;

        function escapeHtmlAttr(str) {
            if (typeof str !== 'string') return str;
            return str.replace(/"/g, '&quot;');
        }

        function createDetailCard(item) {
            const card = document.createElement("div");
            card.className = "bg-white shadow-2xl rounded-xl overflow-hidden border border-slate-100 animate-fadeIn text-left mx-auto max-w-[700px]";

            const safeKata = escapeHtmlAttr(item.entri);
            const safeArti = escapeHtmlAttr(item.makna_entri);
            const safeAsal = escapeHtmlAttr(item.bahasa_daerah || 'Melayu Riau');

            card.innerHTML = `
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <h2 class="text-3xl font-black text-slate-800 lowercase mb-2">${item.entri}</h2>
                            <div class="flex flex-wrap gap-x-4 gap-y-1">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pelafalan: <span class="text-blue-600 lowercase italic font-semibold ml-1">${item.lafal || item.entri}</span></span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kelas: <span class="text-slate-800 font-semibold ml-1">${item.kelas_kata || 'n'}</span></span>
                            </div>
                        </div>
                        <div class="flex gap-1.5">
                            <button onclick='showInfoModal(${JSON.stringify(item)})' class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500 hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-100" title="Detail Data"><i class="fa-solid fa-circle-info text-base"></i></button>
                            <button class="bookmark-btn w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition shadow-sm border border-slate-100" data-kata="${safeKata}" data-arti="${safeArti}" data-asal="${safeAsal}"><i class="fa-regular fa-bookmark text-base"></i></button>
                            <button onclick="document.getElementById('resultDetail').classList.add('hidden')" class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition shadow-sm border border-slate-100"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-5 border border-slate-100 shadow-inner">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">Makna Entri</span>
                        <div class="text-slate-700 text-sm md:text-base leading-relaxed font-semibold italic">"${item.makna_entri}"</div>
                    </div>
                </div>
            `;
            setTimeout(() => {
                const btn = card.querySelector(".bookmark-btn");
                if (btn) setBookmarkIcon(btn, btn.dataset.kata);
            }, 0);
            return card;
        }

        function showInfoModal(item) {
            infoContent.innerHTML = `
                <div class="space-y-2">
                    ${[['Kode Entri', item.kode_entri || 'MELAYU RIAU_58'], ['Bahasa Daerah', item.bahasa_daerah || 'Melayu Riau'], ['Sumber', item.sumber || 'Ensiklopedia Baturijal'], ['Jenis', item.jenis || 'dasar'], ['Label', item.label_bahasa || 'Ri']]
                    .map(([label, val]) => `<div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg border border-slate-50"><span class="text-[8px] font-bold text-slate-400 uppercase tracking-tight">${label}</span><span class="text-xs font-bold text-slate-700">${val}</span></div>`).join('')}
                </div>
            `;
            modalInfo.classList.replace("hidden", "flex");
        }

        function closeInfoModal() {
            modalInfo.classList.replace("flex", "hidden");
        }

        async function fetchResults() {
            if (isLoading) return;
            isLoading = true;
            inputLoader.classList.remove("hidden");
            try {
                const url = `/search-istilah?q=${encodeURIComponent(currentKeyword)}`;
                const res = await fetch(url);
                const items = await res.json();
                resultsList.innerHTML = "";
                if (!Array.isArray(items) || items.length === 0) {
                    resultsList.innerHTML = `<li class="p-4 text-center text-slate-400 italic text-[11px]">Istilah tidak ditemukan</li>`;
                } else {
                    items.forEach(item => {
                        const li = document.createElement("li");
                        li.className = "p-4 hover:bg-blue-50/50 cursor-pointer transition flex items-center justify-between group";
                        li.innerHTML = `<div><div class="font-bold text-slate-800 text-[13px] group-hover:text-blue-600 transition lowercase">${item.entri}</div><div class="text-[10px] text-slate-400 line-clamp-1">${item.makna_entri}</div></div><i class="fa-solid fa-arrow-right text-slate-200 group-hover:text-blue-400 transition-all transform group-hover:translate-x-1 text-xs"></i>`;
                        li.onclick = () => {
                            resultDetail.innerHTML = "";
                            resultDetail.appendChild(createDetailCard(item));
                            resultDetail.classList.remove("hidden");
                            setTimeout(() => resultDetail.classList.add("opacity-100", "scale-100"), 50);
                            dropdown.classList.add("hidden");
                        };
                        resultsList.appendChild(li);
                    });
                }
                dropdown.classList.replace("hidden", "block");
                setTimeout(() => dropdown.classList.add("scale-y-100"), 10);
            } catch (error) {
                console.error(error);
            } finally {
                isLoading = false;
                inputLoader.classList.add("hidden");
            }
        }

        function triggerSearch() {
            currentKeyword = searchInput.value.trim();
            if (!currentKeyword) {
                dropdown.classList.add("hidden");
                resultDetail.classList.add("hidden");
                return;
            }
            fetchResults();
        }

        function debounce(func, delay = 300) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), delay);
            };
        }

        searchInput.addEventListener("input", debounce(triggerSearch, 300));
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".wide-card")) dropdown.classList.add("hidden");
        });

        // Bookmark Sync Navbar
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
            const bridge = document.getElementById("bookmarkNotif");
            if (bridge) {
                bridge.innerText = type === 'saved' ? "Disimpan" : "Dihapus";
                bridge.classList.remove("hidden");
                setTimeout(() => bridge.classList.add("hidden"), 100);
            }
        }

        function setBookmarkIcon(btn, kata) {
            if (!btn) return;
            const icon = btn.querySelector("i");
            if (!icon) return;
            if (isBookmarked(kata)) {
                icon.classList.replace("fa-regular", "fa-solid");
                btn.classList.add("text-blue-600", "bg-blue-100");
                btn.classList.remove("text-slate-400");
            } else {
                icon.classList.replace("fa-solid", "fa-regular");
                btn.classList.remove("text-blue-600", "bg-blue-100");
                btn.classList.add("text-slate-400");
            }
        }

        function updateAllBookmarkIcons() {
            document.querySelectorAll(".bookmark-btn").forEach(btn => setBookmarkIcon(btn, btn.dataset.kata));
        }
        document.addEventListener("click", function(e) {
            const btn = e.target.closest(".bookmark-btn");
            if (btn) {
                e.stopPropagation();
                e.preventDefault();
                toggleBookmark({
                    kata: btn.dataset.kata,
                    arti: btn.dataset.arti,
                    asal: btn.dataset.asal
                });
            }
        });

        AOS.init({
            duration: 800,
            once: true
        });
        window.addEventListener('storage', updateAllBookmarkIcons);
        document.addEventListener("DOMContentLoaded", updateAllBookmarkIcons);
    </script>
</body>

</html>
{{-- Link FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .nav-container {
        font-family: "JetBrains Mono", monospace !important;
        letter-spacing: -0.3px;
    }

    /* Glass Wrapper (Menu Tengah) - TIDAK DIUBAH */
    .nav-glass-wrapper {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
        padding: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.4s ease;
    }

    /* Menu Items - TIDAK DIUBAH */
    .menu-item {
        position: relative;
        font-weight: 700;
        font-size: 0.75rem;
        color: #64748b;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 10px 20px;
        text-decoration: none !important;
        border-bottom: none !important;
        display: inline-block;
        border-radius: 18px;
    }

    .menu-item:hover {
        color: #2563eb;
        background: rgba(37, 99, 235, 0.08);
    }

    .menu-item.active {
        background: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 8px 15px -5px rgba(37, 99, 235, 0.4);
    }

    /* Badge Kemala - TIDAK DIUBAH */
    @keyframes bluePulseGlow {

        0%,
        100% {
            background-color: #1e293b;
            box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
        }

        50% {
            background-color: #2563eb;
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.6);
        }
    }

    .badge-kemala {
        color: white;
        font-size: 9px;
        font-weight: 800;
        padding: 16px 24px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        animation: bluePulseGlow 2s infinite ease-in-out;
    }

    .badge-kemala:hover {
        animation: none;
        background: #2563eb;
        transform: translateY(-2px);
    }

    /* Tombol Icon Nav - DIPERBARUI DIKIT AGAR RELATIVE UNTUK BADGE */
    .btn-icon-nav {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        position: relative;
        /* Penting untuk badge merah */
    }

    .btn-icon-nav:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    /* Badge Merah (Counter Bookmark) */
    .nav-bookmark-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background-color: #ef4444;
        border: 2px solid #fff;
        border-radius: 50%;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .nav-bookmark-badge.show {
        opacity: 1;
        transform: scale(1);
    }

    /* --- ANIMASI MODAL MODERN --- */
    .modal-backdrop {
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .modal-backdrop.open {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-panel {
        transform: scale(0.95) translateY(10px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .modal-panel.open {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    /* --- TOAST MODERN --- */
    #modernToast {
        position: fixed;
        top: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(-150%);
        background: white;
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid #f1f5f9;
        pointer-events: none;
    }

    #modernToast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    #modernToast.saved .icon-box {
        background: #dbeafe;
        color: #2563eb;
    }

    #modernToast.deleted .icon-box {
        background: #fee2e2;
        color: #ef4444;
    }

    /* Navbar Entrance Animation */
    @keyframes navFadeIn {
        from {
            opacity: 0;
            transform: translateY(-15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nav-entrance {
        animation: navFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

{{-- NAVBAR START --}}
<nav x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    class="fixed top-0 left-0 w-full z-[100] transition-all duration-500"
    :class="scrolled ? 'pt-3' : 'pt-6'">

    <div class="max-w-[1440px] mx-auto px-6 md:px-16 flex justify-between items-center md:grid md:grid-cols-3 nav-entrance">

        {{-- 1. Logo (Kiri) --}}
        <div class="flex justify-start">
            <a href="{{ route('home') }}" class="transition-transform hover:scale-105 duration-300 no-underline">
                <img src="{{ asset('assets/bbpr3.png') }}" alt="Logo BBP" class="w-36 md:w-56 h-auto object-contain">
            </a>
        </div>

        {{-- 2. Menu Tengah (Desktop Only) --}}
        <div class="hidden md:flex justify-center">
            <div class="nav-glass-wrapper nav-container">
                <a href="{{ route('home') }}" class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">BERANDA</a>
                <a href="{{ route('koreksi.index') }}" class="menu-item {{ request()->routeIs('koreksi.index') ? 'active' : '' }}">KOREKSI</a>
                <a href="{{ route('ajukan.index') }}" class="menu-item {{ request()->routeIs('ajukan.index') ? 'active' : '' }}">AJUKAN</a>
                <a href="{{ route('kamus.istilah') }}" class="menu-item {{ request()->routeIs('kamus.istilah') ? 'active' : '' }}">ISTILAH</a>
                <a href="{{ route('tentang') }}" class="menu-item {{ request()->routeIs('tentang') ? 'active' : '' }}">TENTANG</a>
            </div>
        </div>

        {{-- 3. Kanan (Bookmark + Burger/Badge) --}}
        <div class="flex justify-end items-center gap-3">

            {{-- Tombol Bookmark (Updated dengan Badge) --}}
            <button id="openBookmarkModal" class="btn-icon-nav" title="Daftar Markah">
                <i class="fa-regular fa-bookmark text-lg"></i> {{-- Icon Outline agar lebih modern --}}
                <div id="badgeCount" class="nav-bookmark-badge"></div> {{-- Badge Merah --}}
            </button>

            {{-- Badge (Desktop Only) --}}
            <div class="hidden md:block nav-container">
                <a href="#" class="badge-kemala uppercase tracking-widest" style="text-decoration: none !important;">KEMALA v2.0</a>
            </div>

            {{-- Burger Menu (Mobile Only) --}}
            <div class="md:hidden">
                <button @click="open = !open"
                    class="w-11 h-11 rounded-xl bg-white shadow-sm border border-slate-100 flex flex-col items-center justify-center gap-1.5 transition-all hover:bg-slate-50">
                    <span class="w-5 h-0.5 bg-slate-800 transition-all" :class="open ? 'rotate-45 translate-y-2' : ''"></span>
                    <span class="w-5 h-0.5 bg-slate-800 transition-all" :class="open ? 'opacity-0' : ''"></span>
                    <span class="w-5 h-0.5 bg-slate-800 transition-all" :class="open ? '-rotate-45 -translate-y-2' : ''"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="md:hidden fixed inset-x-6 top-24 z-50 p-8 rounded-[32px] shadow-2xl bg-white/95 backdrop-blur-2xl border border-slate-100">

        <div class="flex flex-col gap-3 text-center nav-container font-bold">
            @foreach ([['route' => 'home', 'label' => 'BERANDA'], ['route' => 'koreksi.index', 'label' => 'KOREKSI'], ['route' => 'ajukan.index', 'label' => 'AJUKAN'], ['route' => 'kamus.istilah', 'label' => 'ISTILAH'], ['route' => 'tentang', 'label' => 'TENTANG']] as $m)
            <a href="{{ route($m['route']) }}" class="py-4 rounded-full transition-all text-xs tracking-widest no-underline {{ request()->routeIs($m['route']) ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-600 hover:bg-slate-50' }}">
                {{ $m['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- MODAL BOOKMARK MODERN --}}
<div id="bookmarkModalBackdrop" class="fixed inset-0 z-[150] bg-slate-900/30 backdrop-blur-md hidden modal-backdrop flex items-center justify-center p-4">
    <div id="bookmarkModalPanel" class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden modal-panel relative flex flex-col max-h-[85vh] border border-white/50">

        {{-- Modal Header --}}
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                    <i class="fa-solid fa-bookmark text-sm"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 font-sans">Markah Anda</h3>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Daftar kata tersimpan</p>
                </div>
            </div>
            <button id="btnCloseBookmark" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-500 transition flex items-center justify-center border border-slate-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Modal List --}}
        <div id="bookmarkListContainer" class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50/50 scroll-smooth">
            {{-- Javascript will inject items here --}}
        </div>

        {{-- Empty State --}}
        <div id="bookmarkEmptyState" class="hidden flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 shadow-inner">
                <i class="fa-regular fa-bookmark text-3xl"></i>
            </div>
            <h4 class="text-slate-600 font-bold mb-1">Belum ada markah</h4>
            <p class="text-slate-400 text-xs px-10 leading-relaxed">Simpan kata menarik dengan menekan ikon bookmark pada hasil pencarian.</p>
        </div>
    </div>
</div>

{{-- MODERN TOAST NOTIFICATION --}}
<div id="modernToast">
    <div class="icon-box w-9 h-9 rounded-full flex items-center justify-center text-sm shadow-sm">
        <i id="toastIcon" class="fa-solid fa-check"></i>
    </div>
    <div class="flex flex-col pr-2">
        <span id="toastTitle" class="text-[10px] font-bold uppercase tracking-wider opacity-60 text-slate-500 mb-0.5">Sukses</span>
        <span id="toastMessage" class="text-sm font-bold text-slate-800 leading-none">Berhasil disimpan</span>
    </div>
</div>

<script>
    // === 1. TOAST SYSTEM ===
    const toast = document.getElementById('modernToast');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');
    let toastTimeout;

    window.showModernToast = function(type = 'saved') {
        if (!toast) return;

        clearTimeout(toastTimeout);

        toast.className = '';
        void toast.offsetWidth;

        if (type === 'saved') {
            toast.classList.add('saved', 'show');
            toastIcon && (toastIcon.className = 'fa-solid fa-bookmark');
            toastTitle && (toastTitle.innerText = 'DISIMPAN');
            toastMessage && (toastMessage.innerText = 'Kata ditambahkan');
        } else {
            toast.classList.add('deleted', 'show');
            toastIcon && (toastIcon.className = 'fa-solid fa-trash');
            toastTitle && (toastTitle.innerText = 'DIHAPUS');
            toastMessage && (toastMessage.innerText = 'Kata dihapus');
        }

        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    };


    // === 2. DATA LOGIC ===
    function getStoredBookmarks() {
        try {
            return JSON.parse(localStorage.getItem("bookmarks") || "[]");
        } catch {
            return [];
        }
    }

    function saveToStorage(list) {
        localStorage.setItem("bookmarks", JSON.stringify(list));
        updateBadge();
    }

    // === 3. MODAL LOGIC ===
    const modalBackdrop = document.getElementById('bookmarkModalBackdrop');
    const modalPanel = document.getElementById('bookmarkModalPanel');
    const listContainer = document.getElementById('bookmarkListContainer');
    const emptyState = document.getElementById('bookmarkEmptyState');
    const badgeCount = document.getElementById('badgeCount');

    function openModal() {
        renderList();
        modalBackdrop.classList.remove('hidden');
        setTimeout(() => {
            modalBackdrop.classList.add('open');
            modalPanel.classList.add('open');
        }, 10);
    }

    function closeModal() {
        modalBackdrop.classList.remove('open');
        modalPanel.classList.remove('open');
        setTimeout(() => {
            modalBackdrop.classList.add('hidden');
        }, 300);
    }

    function renderList() {
        const bookmarks = getStoredBookmarks();
        listContainer.innerHTML = '';

        if (bookmarks.length === 0) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }

        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');

        bookmarks.forEach(item => {
            const el = document.createElement('div');
            el.className = 'bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group relative animate-fadeIn';
            el.innerHTML = `
                <div class="flex justify-between items-start">
                    <div class="pr-8">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-blue-700 text-lg">${item.kata}</h4>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">${item.arti}</p>
                        <div class="mt-2 inline-flex items-center gap-1.5 text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                            <i class="fa-solid fa-book-open"></i> ${item.asal}
                        </div>
                    </div>
                    <button class="delete-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition" title="Hapus">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                </div>
            `;

            // Delete Action
            el.querySelector('.delete-btn').addEventListener('click', (e) => {
                e.stopPropagation();
                const current = getStoredBookmarks();
                const updated = current.filter(b => b.kata !== item.kata);
                saveToStorage(updated);
                renderList();
                window.showModernToast('deleted');
            });

            listContainer.appendChild(el);
        });
    }

    function updateBadge() {
        if (!badgeCount) return;
        const count = getStoredBookmarks().length;
        badgeCount.classList.toggle('show', count > 0);
    }


    // === 4. EVENTS ===
    document.getElementById('openBookmarkModal')
        ?.addEventListener('click', openModal);

    document.getElementById('btnCloseBookmark')
        ?.addEventListener('click', closeModal);


    modalBackdrop.addEventListener('click', (e) => {
        if (e.target === modalBackdrop) closeModal();
    });

    // Listen to changes from Home page
    window.addEventListener('storage', updateBadge);

    // Sync Notif Logic (Menghubungkan trigger dari Home ke Navbar Toast)
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.target.id === 'bookmarkNotif' && !mutation.target.classList.contains('hidden')) {
                mutation.target.classList.add('hidden'); // Hide original
                const text = mutation.target.innerText.toLowerCase();
                window.showModernToast(text.includes('hapus') ? 'deleted' : 'saved');
            }
        });
    });

    // Observe body for bookmarkNotif from home.blade.php
    const homeNotif = document.getElementById('bookmarkNotif');
    if (homeNotif) {
        observer.observe(homeNotif, {
            attributes: true,
            attributeFilter: ['class']
        });
    } else {
        // Jika element belum ada (karena load order), kita coba observe body
        const bodyObserver = new MutationObserver(() => {
            const n = document.getElementById('bookmarkNotif');
            if (n) {
                observer.observe(n, {
                    attributes: true,
                    attributeFilter: ['class']
                });
                bodyObserver.disconnect();
            }
        });
        bodyObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    document.addEventListener('DOMContentLoaded', updateBadge);
</script>
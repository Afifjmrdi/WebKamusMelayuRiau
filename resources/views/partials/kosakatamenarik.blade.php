<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        scrollbar-width: none;
    }

    /* --- FIX: ANIMASI BACKGROUND GARIS BERJALAN --- */
    .flowing-bg-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        /* Di belakang konten */
        pointer-events: none;
    }

    .moving-path {
        fill: none;
        stroke-width: 6;
        /* Tebalkan lagi agar nampak */
        stroke-linecap: round;
        stroke-dasharray: 200, 1200;
        stroke-dashoffset: 1400;
        animation: flowAnimation linear infinite;
        opacity: 0.6;
        /* Agar tidak terlalu menutupi tapi tetap nampak */
    }

    @keyframes flowAnimation {
        to {
            stroke-dashoffset: 0;
        }
    }

    /* --- CARD & ANIMASI LAINNYA --- */
    @keyframes clickBlink {
        0% {
            background-color: #ffffff;
        }

        50% {
            background-color: #dbeafe;
            transform: scale(0.97);
        }

        100% {
            background-color: #ffffff;
            transform: scale(1);
        }
    }

    .blink-active {
        animation: clickBlink 0.3s ease-out !important;
    }

    .simple-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid #e2e8f0;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, border-color 0.4s ease;
        position: relative;
        border-radius: 1rem;
    }

    .simple-card:hover {
        transform: translateY(-12px);
        z-index: 50;
    }

    @keyframes scrollLeft {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes scrollRight {
        0% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    .row-animate-left {
        display: flex;
        width: max-content;
        animation: scrollLeft 45s linear infinite;
    }

    .row-animate-right {
        display: flex;
        width: max-content;
        animation: scrollRight 45s linear infinite;
    }

    .scroller-row:hover .row-animate-left,
    .scroller-row:hover .row-animate-right {
        animation-play-state: paused;
    }
</style>

<section class="relative px-6 py-24 bg-[#fcfcfd] overflow-hidden font-poppins">

    <svg class="flowing-bg-layer" viewBox="0 0 1440 800" preserveAspectRatio="none">
        <path class="moving-path" d="M-100 200 C 300 400 700 100 1100 300 S 1600 500 1900 200" stroke="#3b82f6" style="animation-duration: 8s;"></path>
        <path class="moving-path" d="M-100 400 C 400 600 800 200 1200 400 S 1500 0 1900 400" stroke="#ec4899" style="animation-duration: 12s; animation-delay: -3s;"></path>
        <path class="moving-path" d="M-100 600 C 200 400 600 800 1000 500 S 1400 300 1900 600" stroke="#10b981" style="animation-duration: 15s; animation-delay: -7s;"></path>
    </svg>

    <div class="relative z-10 text-center mb-20" data-aos="fade-up">
        <span class="inline-block px-4 py-1 mb-4 text-xs font-bold tracking-widest text-blue-700 bg-blue-100/50 rounded-full">Kosakata Menarik</span>
        <h2 class="text-3xl md:text-5xl font-black text-slate-800 mb-6 tracking-tight">
            Kosakata Menarik <span class="text-blue-600">Hari Ini</span>
        </h2>
        <div class="w-12 h-1.5 bg-yellow-400 mx-auto rounded-full mb-8 shadow-sm"></div>
        <p class="text-slate-500 text-base md:text-lg max-w-none mx-auto leading-relaxed whitespace-nowrap overflow-hidden text-ellipsis">
            Temukan kosakata pilihan penuh makna dari berbagai bahasa <span class="font-bold text-blue-600 ml-1">Melayu Riau</span>
        </p>
    </div>

    <div class="relative z-10 space-y-4">
        <div class="scroller-row relative w-full overflow-visible">
            <div class="row-animate-left gap-4 py-4">
                @foreach($kosakataHariIni->take(10)->concat($kosakataHariIni->take(10)) as $kata)
                <div class="simple-card flex-shrink-0 w-64 p-6 cursor-pointer voca-card-item"
                    data-kata="{{ $kata->kata }}" data-kelas="{{ $kata->kelas_kata }}" data-suku="{{ $kata->suku_kata }}"
                    data-arti="{{ $kata->arti }}" data-contoh="{{ $kata->contoh }}" data-asal="{{ $kata->asal_kamus }}"
                    onmouseenter="applyRandomGlow(this)" onmouseleave="removeGlow(this)">
                    <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mb-2 block">{{ $kata->kelas_kata ?? 'Kata' }}</span>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $kata->kata }}</h3>
                    <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed font-light">{{ $kata->arti }}</p>
                </div>
                @endforeach
            </div>
        </div>

        @if($kosakataHariIni->count() > 5)
        <div class="scroller-row relative w-full overflow-visible">
            <div class="row-animate-right gap-4 py-4">
                @foreach($kosakataHariIni->shuffle()->take(10)->concat($kosakataHariIni->shuffle()->take(10)) as $kata)
                <div class="simple-card flex-shrink-0 w-64 p-6 cursor-pointer voca-card-item"
                    data-kata="{{ $kata->kata }}" data-kelas="{{ $kata->kelas_kata }}" data-suku="{{ $kata->suku_kata }}"
                    data-arti="{{ $kata->arti }}" data-contoh="{{ $kata->contoh }}" data-asal="{{ $kata->asal_kamus }}"
                    onmouseenter="applyRandomGlow(this)" onmouseleave="removeGlow(this)">
                    <span class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mb-2 block">{{ $kata->kelas_kata ?? 'Kata' }}</span>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $kata->kata }}</h3>
                    <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed font-light">{{ $kata->arti }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<script>
    function applyRandomGlow(el) {
        const colors = ['#3b82f6', '#ec4899', '#8b5cf6', '#10b981', '#f59e0b', '#06b6d4'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        el.style.boxShadow = `0 15px 30px -5px ${randomColor}55`;
        el.style.borderColor = randomColor;
    }

    function removeGlow(el) {
        el.style.boxShadow = 'none';
        el.style.borderColor = '#e2e8f0';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.voca-card-item');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const self = this;
                self.classList.add('blink-active');

                const data = {
                    kata: self.getAttribute('data-kata'),
                    kelas: self.getAttribute('data-kelas'),
                    suku: self.getAttribute('data-suku'),
                    arti: self.getAttribute('data-arti'),
                    contoh: self.getAttribute('data-contoh'),
                    asal: self.getAttribute('data-asal')
                };

                setTimeout(() => {
                    self.classList.remove('blink-active');
                    Swal.fire({
                        html: `
                        <div style="text-align:left; font-family:'Poppins', sans-serif;">
                            <span style="font-size:10px; font-weight:800; color:#3b82f6; text-transform:uppercase; letter-spacing:2px; background:#eff6ff; padding:4px 12px; border-radius:50px;">Detail Kosakata</span>
                            <h2 style="font-size:2rem; font-weight:800; color:#1f2937; margin: 15px 0 5px 0; letter-spacing:-1px;">${data.kata}</h2>
                            <p style="font-size:12px; color:#94a3b8; font-weight:500; margin-bottom:20px; text-transform:uppercase;">${data.kelas || '-'} • ${data.suku || '-'}</p>
                            <div style="margin-bottom:15px;">
                                <label style="font-size:10px; font-weight:700; color:#b91c1c; text-transform:uppercase; display:block; margin-bottom:5px;">Arti Kata</label>
                                <div style="padding:15px; background:#f8fafc; border-radius:12px; border:1px solid #f1f5f9; color:#475569; font-size:14px;">${data.arti}</div>
                            </div>
                            <div style="margin-bottom:20px;">
                                <label style="font-size:10px; font-weight:700; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:5px;">Contoh Penggunaan</label>
                                <div style="padding:15px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius:12px; color:#ffffff; font-size:14px; line-height:1.6;">
                                    <span style="font-style:italic;">"${data.contoh || 'Belum ada contoh kalimat.'}"</span>
                                </div>
                            </div>
                            <div style="padding-top:15px; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; font-size:10px;">
                                <span style="color:#94a3b8; font-weight:600;">Sumber: ${data.asal}</span>
                                <span style="color:#cbd5e1; font-weight:800;">KEMALA v2.0</span>
                            </div>
                        </div>`,
                        showConfirmButton: false,
                        showCloseButton: true,
                        width: '450px',
                        padding: '2rem',
                        customClass: {
                            popup: 'rounded-[40px] border-none shadow-2xl'
                        }
                    });
                }, 300);
            });
        });
    });

    AOS.init({
        once: true
    });
</script>
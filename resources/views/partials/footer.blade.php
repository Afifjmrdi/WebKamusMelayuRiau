{{-- Link Google Fonts Montserrat --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* Global Footer Font */
    .font-montserrat {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* 1. Efek Glow Belakang KEMALA v2.0 */
    @keyframes modernGlow {

        0%,
        100% {
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.8), 0 0 20px rgba(59, 130, 246, 0.4);
            filter: brightness(1.2);
        }

        50% {
            text-shadow: 0 0 20px rgba(59, 130, 246, 1), 0 0 40px rgba(59, 130, 246, 0.6);
            filter: brightness(1.5);
        }
    }

    .kemala-v2-glow {
        color: #ffffff;
        letter-spacing: 2px;
        animation: modernGlow 3s ease-in-out infinite;
        position: relative;
    }

    /* 2. Navigasi Dot Interaktif */
    .nav-link-modern {
        position: relative;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .nav-link-modern .pulse-dot {
        width: 0;
        height: 0;
        background: #3b82f6;
        border-radius: 50%;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .nav-link-modern:hover .pulse-dot {
        width: 8px;
        height: 8px;
        margin-right: 12px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.8);
        animation: pulseAnimation 1.5s infinite;
    }

    @keyframes pulseAnimation {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.5);
            opacity: 0.5;
        }
    }

    /* 3. Globe Spin Animation */
    @keyframes globeRotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .globe-container:hover .globe-svg {
        animation: globeRotate 4s linear infinite;
    }

    /* 4. Background Dot Pattern */
    .bg-dots {
        background-image: radial-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 25px 25px;
    }

    /* 5. MOTIF BATIK 3D EFFECT (Pillar Style) */
    .batik-container {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 120px;
        z-index: 1;
        pointer-events: none;
        opacity: 0.8;
        transition: all 0.5s ease;
        perspective: 1000px;
    }

    .batik-left {
        left: 0;
        box-shadow: 15px 0 35px rgba(0, 0, 0, 0.8);
        border-right: 1px solid rgba(59, 130, 246, 0.2);
    }

    .batik-right {
        right: 0;
        transform: scaleX(-1);
        box-shadow: 15px 0 35px rgba(0, 0, 0, 0.8);
        border-right: 1px solid rgba(59, 130, 246, 0.2);
    }

    .batik-image {
        position: absolute;
        top: 50%;
        left: 40%;
        width: 950px;
        height: 120px;
        background-image: url("{{ asset('assets/motifbatik.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        transform: translate(-50%, -50%) rotate(90deg) skewX(2deg);
        filter: brightness(1.1) contrast(1.2) drop-shadow(2px 2px 5px rgba(0, 0, 0, 0.5));
    }

    .batik-container::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right,
                transparent 0%,
                rgba(5, 11, 24, 0.2) 50%,
                rgba(5, 11, 24, 0.8) 100%);
    }

    @media (max-width: 1024px) {
        .batik-container {
            width: 60px;
        }
    }

    @media (max-width: 768px) {
        .batik-container {
            display: none;
        }
    }
</style>

<footer class="relative bg-[#050b18] text-slate-300 pt-24 pb-12 overflow-hidden font-montserrat">

    <div class="batik-container batik-left">
        <div class="batik-image"></div>
    </div>
    <div class="batik-container batik-right">
        <div class="batik-image"></div>
    </div>

    <div class="absolute inset-0 bg-dots opacity-40"></div>
    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
    <div class="absolute top-1/2 right-0 w-64 h-64 bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

            <div class="lg:col-span-5 space-y-8">
                <div class="flex items-center gap-5">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        <div class="relative p-3 bg-white rounded-2xl">
                            <img src="{{ asset('assets/logobbpr4.png') }}" alt="Logo" class="h-10 w-auto">
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-white tracking-tight">Balai Bahasa</h2>
                        <p class="text-blue-500 font-bold tracking-[0.2em] text-[10px] uppercase">Provinsi Riau</p>
                    </div>
                </div>

                <p class="text-slate-400 text-sm leading-relaxed max-w-md font-normal">
                    Membangun jembatan literasi melalui digitalisasi bahasa Melayu Riau. Kami berdedikasi untuk melestarikan identitas budaya dalam ekosistem digital yang cerdas.
                </p>

                <div class="flex items-center gap-4">
                    <a href="#" class="w-11 h-11 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center hover:border-blue-500 hover:bg-blue-500/10 transition-all duration-500 group">
                        <i class="fab fa-facebook-f group-hover:text-blue-500"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center hover:border-pink-500 hover:bg-pink-500/10 transition-all duration-500 group">
                        <i class="fab fa-instagram group-hover:text-pink-500"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center hover:border-cyan-400 hover:bg-black transition-all duration-500 group">
                        <i class="fab fa-tiktok group-hover:text-cyan-400"></i>
                    </a>
                    <a href="#" class="w-11 h-11 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center hover:border-red-400 hover:bg-red transition-all duration-500 group">
                        <i class="fab fa-youtube group-hover:text-red-400"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-3">
                <h3 class="font-extrabold text-white mb-10 text-[11px] tracking-[0.3em] flex items-center gap-3">
                    <span class="w-8 h-[1px] bg-blue-500"></span> Navigasi
                </h3>
                <ul class="space-y-5 text-sm font-medium">
                    <li><a href="{{ route('home') }}" class="nav-link-modern hover:text-white group"><span class="pulse-dot"></span> Beranda</a></li>
                    <li><a href="{{ url('/koreksi') }}" class="nav-link-modern hover:text-white group"><span class="pulse-dot"></span> Koreksi Kosakata</a></li>
                    <li><a href="{{ url('/ajukan') }}" class="nav-link-modern hover:text-white group"><span class="pulse-dot"></span> Ajukan Kosakata</a></li>
                    <li><a href="{{ url('/tentang') }}" class="nav-link-modern hover:text-white group"><span class="pulse-dot"></span> Tentang</a></li>
                    <li><a href="{{ url('/kamus-istilah') }}" class="nav-link-modern hover:text-white group"><span class="pulse-dot"></span> Kamus Istilah</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h3 class="font-extrabold text-white mb-10 text-[11px] tracking-[0.3em] flex items-center gap-3">
                    <span class="w-8 h-[1px] bg-blue-500"></span> Alamat & Lokasi
                </h3>
                <div class="space-y-6">
                    <div class="globe-container flex gap-5 items-start group">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/10 flex items-center justify-center flex-shrink-0 border border-blue-500/20 group-hover:bg-blue-600 transition-all duration-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="globe-svg h-6 w-6 text-blue-500 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm leading-relaxed text-slate-400 font-medium group-hover:text-slate-200 transition-colors">
                            Jalan Binawidya, Kompleks Universitas Riau, Panam, Pekanbaru, Riau 28292
                        </p>
                    </div>

                    <div class="rounded-xl overflow-hidden border border-slate-800 group shadow-2xl transition-all duration-700 relative z-20">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.654763321522!2d101.374668!3d0.476483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a907f1a30f71%3A0x673905c879326e33!2sBalai%20Bahasa%20Provinsi%20Riau!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid"
                            width="100%" height="120" style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 pt-10 border-t border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-6 w-full relative z-20">
            <p class="text-[11px] tracking-[0.2em] text-slate-500 font-bold">
                © 2025 Balai Bahasa Provinsi Riau, Kementerian Pendidikan Dasar dan Menengah.
            </p>

            <div class="flex items-center gap-6 md:gap-8">
                <a href="#" class="text-[11px] font-bold text-slate-400 hover:text-blue-500 transition-colors tracking-[0.2em] whitespace-nowrap text-decoration-none">
                    Dev by Afifjmrdi
                </a>

                <div class="h-4 w-[1px] bg-slate-800"></div>

                <div class="kemala-v2-glow text-[11px] font-black whitespace-nowrap tracking-[0.3em]">
                    KEMALA v2.0
                </div>
            </div>
        </div>
    </div>
</footer>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - KEMALA v2.0</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
        }

        /* --- Hero Style --- */
        .hero-mesh {
            background: radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(99, 102, 241, 0.03) 0%, transparent 50%);
        }

        /* --- Bento & Gallery --- */
        .mesh-card-bg {
            background: linear-gradient(-45deg, #ffffff, #f0f7ff, #ffffff, #fdf4ff);
            background-size: 400% 400%;
            animation: meshGradient 15s ease infinite;
        }

        @keyframes meshGradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .parallelogram-gallery {
            position: relative;
            width: 100%;
            height: 320px;
            display: flex;
            gap: 3px;
            overflow: hidden;
            border-radius: 1rem;
            background: #ffffff;
        }

        .gallery-panel {
            position: relative;
            flex: 1;
            height: 100%;
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            filter: grayscale(0.2) brightness(0.9);
        }

        .panel-pcr {
            clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
            z-index: 2;
            margin-right: -10%;
        }

        .panel-balai {
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
            z-index: 1;
        }

        .gallery-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .gallery-panel:hover {
            flex: 10;
            filter: grayscale(0) brightness(1);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            z-index: 10;
        }

        .parallelogram-gallery:hover .gallery-panel:not(:hover) {
            flex: 0.1;
            opacity: 0.2;
        }

        .panel-tag {
            position: absolute;
            bottom: 15px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #0f172a;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 20;
        }

        /* --- Team Section Animations --- */
        .moving-lines-bg {
            position: relative;
            background-color: #ffffff;
            background-image: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px), linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveLines 20s linear infinite;
        }

        @keyframes moveLines {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 50px 50px;
            }
        }

        @keyframes neonBlink {

            0%,
            100% {
                box-shadow: 0 0 10px var(--neon-color);
                border-color: var(--neon-color);
            }

            50% {
                box-shadow: 0 0 30px var(--neon-color), 0 0 40px var(--neon-color);
                border-color: #fff;
            }
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Swiper Padding Fix: Mencegah kartu terpotong */
        .pakar-swiper {
            padding: 60px 20px !important;
            overflow: visible !important;
        }

        .pakar-card {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #f1f5f9;
            border-radius: 2rem;
            padding: 2rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .card-siak:hover {
            --neon-color: #3b82f6;
        }

        .card-kuantan:hover {
            --neon-color: #a855f7;
        }

        .card-rohil:hover {
            --neon-color: #10b981;
        }

        .pakar-card:hover {
            transform: translateY(-20px);
            animation: neonBlink 1.5s ease-in-out infinite;
            z-index: 50;
        }

        .swiper-slide {
            animation: floating 4s ease-in-out infinite;
        }

        .swiper-slide:nth-child(2) {
            animation-delay: 0.5s;
        }

        .swiper-slide:nth-child(3) {
            animation-delay: 1s;
        }

        .swiper-slide:hover {
            animation-play-state: paused;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            color: #64748b;
            margin-bottom: 1rem;
            transition: 0.3s;
        }

        .pakar-card:hover .icon-box {
            background: var(--neon-color);
            color: white;
        }

        .member-item-card {
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            border: 1px solid transparent;
            transition: 0.3s;
        }

        .pakar-card:hover .member-item-card {
            background: white;
            border-color: var(--neon-color);
            color: var(--neon-color);
        }

        .cta-main {
            background: #0f172a;
            color: white;
            padding: 14px 30px;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        /* --- Swiper Padding Fix: Disesuaikan agar lebih dekat ke judul --- */
        .pakar-swiper {
            /* Padding atas dikurangi dari 60px/50px menjadi 30px */
            padding: 30px 20px 40px 20px !important;
            overflow: visible !important;
            margin-top: -10px;
            /* Menarik swiper sedikit lebih dekat ke judul */
        }

        /* Memastikan slide tidak memberikan margin tambahan */
        .pakar-swiper .swiper-slide {
            display: flex;
            height: auto;
            padding-top: 10px;
            /* Ruang kecil untuk animasi naik agar tidak potong */
        }

        /* Animasi floating disesuaikan agar tidak melompat terlalu jauh ke bawah */
        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        /* Tag untuk PCR (Panel Kiri) tetap di kiri */
        .panel-pcr .panel-tag {
            left: 20px;
            right: auto;
        }

        /* Tag untuk Balai Bahasa (Panel Kanan) dipindah ke kanan */
        .panel-balai .panel-tag {
            left: auto;
            right: 20px;
            /* Pindah ke sisi kanan agar tidak ketutup potongan miring */
        }

        /* Memastikan teks tetap di atas gambar saat di-hover */
        .gallery-panel:hover .panel-tag {
            opacity: 0;
            /* Tetap menghilang saat hover agar gambar terlihat jelas */
            transform: translateY(10px);
        }

        /* Desain Tombol Navigasi yang Lebih Bagus */
        .nav-custom-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .nav-custom-btn:hover {
            background: #0f172a;
            color: #ffffff;
        }

        .nav-custom-btn:active {
            transform: scale(0.95);
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <section class="relative pt-45 pb-4 hero-mesh">
        <div class="container mx-auto relative z-10">
            <div class="text-center mb-10 relative" data-aos="fade-up">
                <h1 class="text-7xl md:text-9xl font-black text-slate-900 tracking-tighter italic opacity-5 absolute -top-12 left-1/2 -translate-x-1/2 select-none">Tentang</h1>
                <p class="text-blue-600 font-black text-xs tracking-[0.3em] mb-3">Tentang Kami</p>
                <h2 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-4 tracking-tight">Tentang Kami</h2>
                <div class="max-w-3xl mx-auto">
                    <p class="text-slate-500 text-sm md:text-base leading-relaxed font-medium">
                        <span class="text-slate-900 font-bold underline decoration-blue-500/30">KEMALA</span> merupakan hasil kolaborasi antara <span class="text-slate-900 font-semibold">Balai Bahasa Provinsi Riau</span> dan <span class="text-slate-900 font-semibold">Politeknik Caltex Riau</span>. Kami berkomitmen menghadirkan kamus elektronik yang interaktif dan mudah diakses untuk menjaga kelestarian bahasa Melayu Riau.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 px-6 bg-[#f8fafc]">
        <div class="container mx-auto max-w-6xl" data-aos="fade-up">
            <div class="relative mesh-card-bg border border-slate-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm overflow-hidden">

                <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-100/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-indigo-100/30 rounded-full blur-3xl"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">

                    <div class="lg:col-span-5 order-2 lg:order-1">
                        <div class="parallelogram-gallery shadow-lg border border-slate-100">

                            <div class="gallery-panel panel-pcr">
                                <div class="panel-tag">Kampus PCR</div>
                                <img src="https://riaucerdas.com/uploads/images/2023/03/image_750x_6412d9e2de72a.jpg" alt="PCR">
                            </div>

                            <div class="gallery-panel panel-balai">
                                <div class="panel-tag">Kantor BBPR</div>
                                <img src="https://ppidbbpriau.kemendikdasmen.go.id/images/gedung-balai.jpeg" alt="Balai Bahasa">
                            </div>

                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 space-y-6">
                        <div>
                            <span class="inline-block px-3 py-1 bg-white border border-slate-200 text-[9px] font-black text-blue-600 tracking-[0.3em] rounded-full mb-4 shadow-sm">
                                Kolaborasi
                            </span>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">
                                Kolaborasi Akademik <br>& <span class="text-blue-600">Pelestarian Budaya</span>
                            </h2>
                        </div>

                        <div class="space-y-4 text-slate-500 text-sm md:text-base leading-relaxed">
                            <p>
                                Pengembangan <span class="text-slate-900 font-semibold">KEMALA</span> adalah sinergi untuk menciptakan sistem pencarian presisi dan antarmuka digital yang modern.
                            </p>
                            <p>
                                Proyek ini merupakan wujud nyata integrasi antara <span class="text-slate-900 font-semibold">Politeknik Caltex Riau</span> dan <span class="text-slate-900 font-semibold">Balai Bahasa Provinsi Riau</span> dalam mendigitalisasi kekayaan bahasa daerah.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 py-4 border-t border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs shadow-lg">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="text-sm">
                                <span class="block text-slate-400 text-[9px] font-bold uppercase tracking-wider">Developer</span>
                                <span class="text-slate-900 font-bold">Muhammad Afif Jumardi</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 md:gap-8 pt-4">
                            <img src="{{ asset('assets/pcr.png') }}"
                                class="h-12 md:h-16 w-auto object-contain opacity-90 hover:opacity-100 transition-all duration-300"
                                alt="PCR">

                            <div class="w-px h-8 md:h-12 bg-slate-200"></div>

                            <img src="{{ asset('assets/logobbpr.png') }}"
                                class="h-12 md:h-16 w-auto object-contain opacity-90 hover:opacity-100 transition-all duration-300"
                                alt="Balai Bahasa">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-12 moving-lines-bg overflow-hidden">
        <div class="container mx-auto px-6 max-w-6xl relative z-10">

            <div class="flex flex-col md:flex-row justify-between items-start mb-2 gap-4">
                <div data-aos="fade-right">
                    <span class="text-blue-600 text-[10px] font-black tracking-[0.4em] mb-1 block">Tim Penyusun Kamus</span>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tighter leading-none">
                        Penyusun Kamus
                    </h2>
                </div>

                <div class="flex md:hidden gap-3 mt-4" data-aos="fade-left">
                    <button class="swiper-prev nav-custom-btn">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button class="swiper-next nav-custom-btn">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="swiper pakar-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide h-auto">
                        <div class="pakar-card card-siak h-full">
                            <div class="icon-box"><i class="fas fa-book-open"></i></div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2 tracking-tight">Kamus Melayu Siak</h3>
                            <p class="text-slate-500 text-xs leading-relaxed mb-6 italic">
                                Disusun oleh Tim Kamus Istilah Balai Bahasa Provinsi Riau.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                                <div class="member-item-card">Zainal Abidin</div>
                                <div class="member-item-card">Elvina Syahrir</div>
                                <div class="member-item-card">Irfariati</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide h-auto">
                        <div class="pakar-card card-kuantan h-full">
                            <div class="icon-box"><i class="fas fa-book"></i></div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2 tracking-tight">Kamus Kuantan Singingi</h3>
                            <p class="text-slate-500 text-xs leading-relaxed mb-6 italic">
                                Disusun oleh Tim Kamus Istilah Balai Bahasa Provinsi Riau.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                                <div class="member-item-card">Arpina</div>
                                <div class="member-item-card">Santi Agus</div>
                                <div class="member-item-card">Elvina Syahrir</div>
                                <div class="member-item-card">Azmi Ridwan Fauzi</div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide h-auto">
                        <div class="pakar-card card-rohil h-full">
                            <div class="icon-box"><i class="fas fa-bookmark"></i></div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2 tracking-tight">Kamus Rokan Hilir</h3>
                            <p class="text-slate-500 text-xs leading-relaxed mb-6 italic">
                                Disusun oleh Tim Kamus Istilah Balai Bahasa Provinsi Riau.
                            </p>
                            <div class="mt-auto pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                                <div class="member-item-card">Santi Agus</div>
                                <div class="member-item-card">Arpina</div>
                                <div class="member-item-card">Azmi Ridwan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true
            });
            new Swiper(".pakar-swiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: ".swiper-next",
                    prevEl: ".swiper-prev"
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                }
            });
        });
    </script>
</body>

</html>
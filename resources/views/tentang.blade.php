<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Kamus Balai Bahasa Riau</title>
    @vite(['resources/css/app.css'])
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #2d2d2d;
            overflow-x: hidden;
        }

        .font-jetbrains {
            font-family: 'JetBrains Mono', monospace !important;
        }

        .kampus-logo {
            height: 80px;
            object-fit: contain;
        }

        section {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            background: url('{{ asset(' assets/background.png') }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 100px;
            text-align: center;
        }

        /* Animasi bintang */
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
                opacity: 0.7;
                transform: scale(0.9);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }
        }

        .star {
            opacity: 0.8;
            transform-origin: center;
            animation: spin-slow 15s linear infinite, twinkle 3s ease-in-out infinite;
            filter: drop-shadow(0 0 6px #fff);
        }

        .star:nth-child(3n) {
            animation-duration: 10s, 2s;
        }

        .star:nth-child(4n) {
            animation-duration: 18s, 4s;
            animation-direction: reverse, alternate;
        }

        .star:nth-child(5n) {
            animation-duration: 22s, 3s;
            opacity: 0.6;
        }

        /* Animasi muncul */
        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fade-up 1s ease-out forwards;
        }

        /* Card umum */
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1.8rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Card Kolaborasi */
        .kampus-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .kampus-card {
                flex-direction: row;
                text-align: left;
            }
        }

        .kampus-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .kampus-logo {
            width: 180px;
            height: auto;
            object-fit: contain;
            transition: transform 0.4s ease;
            filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.4));
        }

        .kampus-card:hover .kampus-logo {
            transform: scale(1.05);
        }

        .kampus-content h2 {
            font-weight: 600;
            color: #2d2d2d;
        }

        .kampus-content p {
            color: #4b5563;
            line-height: 1.7;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    @include('partials.navbar')

    <section class="relative min-h-screen flex flex-col items-center justify-start text-white overflow-hidden bg-cover bg-center"
        style="background-image: url('{{ asset('assets/background4.png') }}'); padding-top: 100px;">
        {{-- Latar Bintang --}}
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 0; $i < 40; $i++)
                @php
                $top=rand(0, 95);
                $left=rand(0, 95);
                $size=rand(8, 16);
                @endphp
                <img src="{{ asset('assets/sparkle.png') }}" class="absolute star"
                style="top:{{ $top }}%; left:{{ $left }}%; width:{{ $size }}px; height:{{ $size }}px;">
                @endfor
        </div>

        {{-- Konten Utama --}}
        <div class="relative z-10 fade-up mt-12 px-4 max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-700 mb-6 font-jetbrains">
                Tentang Kami
            </h1>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto mb-12">
                <span class="font-semibold text-blue-400">Kamus Balai Bahasa Riau</span> merupakan hasil kolaborasi antara
                <span class="font-semibold text-blue-400">Balai Bahasa Provinsi Riau</span> dan
                <span class="font-semibold text-blue-400">Politeknik Caltex Riau</span>.
                Kami berkomitmen menghadirkan kamus digital yang interaktif dan mudah diakses untuk menjaga kelestarian bahasa daerah Riau.
            </p>
        </div>
        {{-- Card Kolaborasi PCR & BBPR --}}
        <div class="relative z-10 fade-up mt-5 px-6 max-w-6xl mx-auto">
            <div class="kampus-card shadow-lg flex items-center justify-between bg-white rounded-lg p-6">
                <!-- Logo kiri -->
                <img src="{{ asset('assets/pcr.png') }}"
                    alt="Politeknik Caltex Riau"
                    class="kampus-logo w-24 md:w-32 object-contain">

                <!-- Konten tengah -->
                <div class="kampus-content flex-1 px-6 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl mb-3 font-semibold">
                        Kolaborasi dengan Politeknik Caltex Riau
                    </h2>
                    <p class="mb-3 text-gray-700 leading-relaxed">
                        Pengembangan <span class="font-semibold text-blue-500">Kamus Balai Bahasa Riau</span> merupakan hasil sinergi antara
                        Balai Bahasa Provinsi Riau dan <span class="font-semibold text-blue-500">Politeknik Caltex Riau (PCR)</span>.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Kolaborasi ini terwujud melalui program magang mahasiswa Politeknik Caltex Riau (PCR).
                        Proses pengembangan sistem, perancangan antarmuka, serta implementasi teknologi sepenuhnya
                        dikerjakan oleh mahasiswa magang di bawah arahan dan pendampingan dari Balai Bahasa Provinsi Riau.
                    </p>
                </div>
                <!-- Logo kanan -->
                <img src="{{ asset('assets/BBP.png') }}"
                    alt="Politeknik Caltex Riau"
                    class="kampus-logo w-24 md:w-32 object-contain mb-4 md:mb-0 md:ml-6">
            </div>
        </div>

        {{-- CTA --}}
        <div class="relative z-10 fade-up text-center mt-20 mb-20 px-6">
            <h3 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-4">
                Mari Bersama Melestarikan Bahasa Daerah
            </h3>
            <p class="text-gray-500 mb-8 max-w-2xl mx-auto">
                Setiap kata adalah warisan budaya. Jadilah bagian dari perjalanan menjaga bahasa Riau agar terus hidup dan berkembang.
            </p>
            <a href="{{ url('/') }}"
                class="inline-block px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-full font-semibold transition">
                Kembali ke Beranda
            </a>
        </div>
    </section>

    {{-- Footer --}}
    @include('partials.footer')
</body>

</html>
<style>
    /* Animasi Ikon Bergoyang saat Hover */
    @keyframes wiggle {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-8deg);
        }

        75% {
            transform: rotate(8deg);
        }
    }

    /* Animasi Mengambang (Floating) */
    @keyframes floatFast {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .modern-card {
        animation: floatFast 3s ease-in-out infinite;
        position: relative;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        /* Shadow tipis default agar card terlihat nyata */
        shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .delay-1 {
        animation-delay: 0s;
    }

    .delay-2 {
        animation-delay: 0.8s;
    }

    .delay-3 {
        animation-delay: 1.6s;
    }

    /* EFEK LAMPU MENYALA (Glow Effect) */
    .modern-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 2.5rem;
        padding: 2px;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .modern-card:hover::before {
        opacity: 1;
    }

    /* Shadow & Glow saat Hover (Card 1, 2, 3) */
    .hover-glow-blue:hover {
        box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.3);
        background: rgba(255, 255, 255, 0.95);
    }

    .hover-glow-indigo:hover {
        box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.3);
        background: rgba(255, 255, 255, 0.95);
    }

    .hover-glow-yellow:hover {
        box-shadow: 0 25px 50px -12px rgba(234, 179, 8, 0.3);
        background: rgba(255, 255, 255, 0.95);
    }

    .modern-card:hover {
        animation-play-state: paused;
        transform: scale(1.03) translateY(-10px) !important;
    }

    .modern-card:hover .icon-box {
        animation: wiggle 0.4s ease-in-out infinite;
    }

    .bg-modern-mesh {
        background-color: #ffffff;
        background-image:
            radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.08) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(249, 115, 22, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
            radial-gradient(at 0% 100%, rgba(234, 179, 8, 0.05) 0px, transparent 50%);
        background-attachment: fixed;
    }

    /* Shadow bawaan untuk semua glass-card */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }
</style>

<section class="px-6 md:px-16 py-28 bg-modern-mesh relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
        style="background-image: linear-gradient(#1e40af 1px, transparent 1px), linear-gradient(90deg, #1e40af 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-20" data-aos="fade-up">
            <span class="inline-block px-4 py-1 mb-4 text-xs font-bold tracking-widest text-blue-700 bg-blue-100/50 rounded-full">
                Informasi Kemala
            </span>
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mb-4 tracking-tight">
                Informasi Seputar <span class="text-blue-600">KEMALA</span>
            </h2>
            <div class="w-12 h-1.5 bg-yellow-400 mx-auto rounded-full mb-8 shadow-sm"></div>
            <p class="text-slate-500 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Ayo cari tahu fitur-fitur apa saja yang bisa kamu gunakan di
                <span class="font-bold text-blue-600 inline-block ml-1">KEMALA</span>
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">

            <div class="modern-card delay-1 group glass-card hover-glow-blue p-10 rounded-[2.5rem] text-center">
                <div class="icon-box w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-100 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <h3 class="font-poppins font-bold text-2xl text-slate-800 mb-4">Cari Kata</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Temukan kosakata dari berbagai bahasa Melayu Riau, lengkap dengan arti dan contoh penggunaannya untuk menambah wawasan bahasamu.
                </p>
            </div>

            <div class="modern-card delay-2 group glass-card hover-glow-indigo p-10 rounded-[2.5rem] text-center">
                <div class="icon-box w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-indigo-100 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <h3 class="font-poppins font-bold text-2xl text-slate-800 mb-4 text-balance">Koreksi & Ajukan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Ikut berkontribusi menjaga ketepatan data kamus dan menambahkan kosakata baru dari daerahmu untuk melestarikan bahasa Melayu Riau.
                </p>
            </div>

            <div class="modern-card delay-3 group glass-card hover-glow-yellow p-10 rounded-[2.5rem] text-center">
                <div class="icon-box w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-yellow-100 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="font-poppins font-bold text-2xl text-slate-800 mb-4">Kosakata Baru</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pelajari kosakata baru dari bahasa Melayu Riau setiap hari, kenali ragam bahasa lokal, serta tumbuhkan kecintaan pada bahasa Indonesia.
                </p>
            </div>

        </div>
    </div>
</section>
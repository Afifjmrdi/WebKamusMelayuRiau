<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koreksi Kata - Kemala v2.0</title>

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
            overflow-x: hidden;
        }

        /* --- BACKGROUND BATIK SMOOTH --- */
        .batik-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.08;
        }

        @keyframes batikFlow {
            from {
                stroke-dashoffset: 1000;
            }

            to {
                stroke-dashoffset: 0;
            }
        }

        .batik-line {
            fill: none;
            stroke-width: 1.5;
            stroke-dasharray: 50, 200;
            animation: batikFlow 30s linear infinite;
        }

        /* --- STEP INDICATOR (Z-Index Fix) --- */
        .step-dot {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            color: #cbd5e1;
            position: relative;
            z-index: 10;
            border: 1px solid #f1f5f9;
            transition: all 0.4s ease;
        }

        .step-item.active .step-dot {
            background: #3b82f6;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }

        .step-item.completed .step-dot {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }

        .progress-track {
            position: absolute;
            top: 22px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #f1f5f9;
            z-index: 1;
        }

        .progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: #3b82f6;
            transition: width 0.6s ease;
        }

        /* --- MODAL STRUCTURE (Radius dipertegas) --- */
        #modalKoreksi {
            backdrop-filter: blur(12px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        #modalKoreksi.active {
            display: flex;
        }

        .modal-glass {
            background: #ffffff;
            border-radius: 1.25rem;
            /* Radius dipertegas (tidak terlalu bulat) */
            width: 100%;
            max-width: 850px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.1);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .modal-scroll-area {
            overflow-y: auto;
            padding: 2.5rem 3rem;
            flex: 1;
        }

        /* --- SOFT FOOTER DIVIDER (Abu-abu & Gantung) --- */
        .footer-divider {
            height: 1px;
            width: 85%;
            /* Tidak sampai ujung */
            margin: 0 auto;
            background: #f1f5f9;
            /* Abu-abu halus */
        }

        /* --- FIELD STYLING --- */
        .label-modern {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94a3b8;
            margin-bottom: 8px;
            display: block;
        }

        .modern-field {
            background: #ffffff !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 0.75rem !important;
            padding: 1rem 1.25rem !important;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            width: 100%;
            color: #1e293b;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        }

        .modern-field:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.08) !important;
            outline: none;
        }

        /* --- PREVIEW BOX --- */
        .preview-glass {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .btn-nav {
            padding: 1rem 2.2rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: #1e293b;
            color: white;
        }

        .btn-primary:hover {
            background: #3b82f6;
            transform: translateY(-2px);
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.4s ease forwards;
        }

        /* --- CUSTOM SWEETALERT MODERN STYLE --- */
        .swal2-popup-custom {
            border-radius: 1.5rem !important;
            padding: 2rem !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-title-custom {
            font-weight: 800 !important;
            color: #1e293b !important;
        }

        /* Styling tombol kembali agar transisi warnanya sempurna */
        #prevBtn {
            cursor: pointer;
            background-color: transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
        }

        /* Kondisi Hover: Kotak jadi Hitam, Teks jadi Putih */
        #prevBtn:hover {
            background-color: #1e293b !important;
            /* Warna Slate 900 (Hitam Biru) */
            color: #ffffff !important;
            /* Teks Putih Mutlak */
            border-color: #1e293b !important;
        }

        /* Kondisi Active: Saat diklik sedikit mengecil */
        #prevBtn:active {
            transform: scale(0.95);
            background-color: #000000 !important;
        }

        /* Pastikan tanda panah juga ikut berubah warna */
        #prevBtn:hover span {
            color: #ffffff !important;
        }

        /* Animasi mengapung untuk card */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        /* Efek lampu nyala (Glow) */
        .card-glow-blue:hover {
            box-shadow: 0 0 30px 5px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .card-glow-amber:hover {
            box-shadow: 0 0 30px 5px rgba(245, 158, 11, 0.3);
            border-color: rgba(245, 158, 11, 0.5);
        }

        .card-glow-emerald:hover {
            box-shadow: 0 0 30px 5px rgba(16, 185, 129, 0.3);
            border-color: rgba(16, 185, 129, 0.5);
        }

        /* --- GLOW PULSE ANIMATION --- */
        @keyframes biru-kedip {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                /* Perluas bayangan tanpa mengubah scale di sini agar tidak konflik dengan hover */
                box-shadow: 0 0 0 20px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .btn-kedip-biru {
            animation: biru-kedip 2s infinite;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 10;
        }

        /* Memastikan tombol tetap terlihat solid saat ditekan */
        .btn-nav:active {
            transform: scale(0.95) !important;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <section class="relative min-h-screen pt-48 pb-24 flex flex-col items-center overflow-hidden">
        <svg class="batik-bg" width="100%" height="100%">
            <pattern id="batikPattern" x="0" y="0" width="200" height="200" patternUnits="userSpaceOnUse">
                <path class="batik-line" d="M100 20 L130 80 L190 80 L140 120 L160 180 L100 140 L40 180 L60 120 L10 80 L70 80 Z" stroke="#3b82f6" />
            </pattern>
            <rect width="100%" height="100%" fill="url(#batikPattern)" />
        </svg>

        <div class="relative z-10 container mx-auto px-6" data-aos="fade-up">
            <div class="text-center mb-16 relative">
                <h1 class="text-7xl md:text-9xl font-black text-slate-900 mb-4 tracking-tighter italic opacity-5 absolute -top-16 left-1/2 -translate-x-1/2 select-none">Koreksi</h1>
                <p class="text-blue-600 font-black text-xs tracking-[0.3em] mb-4">Layanan Koreksi</p>
                <h2 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">Koreksi Kata</h2>

                <div class="max-w-3xl mx-auto">
                    <p class="text-slate-500 text-base md:text-lg leading-relaxed">
                        Fitur <span class="text-slate-900 font-bold underline decoration-blue-500/30">Koreksi Kata</span> memudahkan pengguna untuk membantu memperbaiki data dalam <span class="text-slate-900 font-semibold">Kamus Elektronik Bahasa Melayu Riau</span>. Bersama <span class="text-slate-900 font-semibold">Balai Bahasa Provinsi Riau</span> kami menjaga keakuratan bahasa Melayu Riau secara kolaboratif.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto mb-16">
                <div data-aos="fade-up" data-aos-delay="100"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-blue cursor-default">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">01</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-blue-600">Identifikasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Cari kata yang ingin Anda perbaiki dari database Kamus Elektronik Bahasa Melayu Riau.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="200"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-amber cursor-default" style="animation-delay: 0.5s;">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">02</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-amber-600">Perbaikan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Masukkan versi perbaikan yang benar beserta alasan atau referensinya secara detail.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="300"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-emerald cursor-default" style="animation-delay: 1s;">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">03</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-emerald-600">Verifikasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Tim Balai Bahasa akan meninjau dan memvalidasi kontribusi Anda demi keakuratan data.</p>
                </div>
            </div>

            <div class="text-center">
                <button id="openModal" class="btn-nav btn-primary btn-kedip-biru text-sm px-10 py-5 rounded-2xl shadow-2xl tracking-widest font-black transition-all hover:scale-110 active:scale-95">
                    Mulai Koreksi Sekarang
                </button>
            </div>
        </div>
    </section>

    {{-- MODAL --}}
    <div id="modalKoreksi" class="fixed inset-0 z-[200] bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="modal-glass animate__animated animate__fadeInUp animate__faster">

            <div class="px-10 pt-10 pb-6 bg-white">
                <div class="w-full flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">Formulir Koreksi</h2>
                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Lengkapi data secara bertahap</p>
                    </div>
                    <button id="btnCloseTop" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-300 hover:text-red-500 transition-all">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative w-full max-w-sm mx-auto flex items-center justify-between">
                    <div class="progress-track">
                        <div id="progressFill" class="progress-fill"></div>
                    </div>
                    <div class="step-item active" id="step-1-item">
                        <div class="step-dot">01</div>
                    </div>
                    <div class="step-item" id="step-2-item">
                        <div class="step-dot">02</div>
                    </div>
                    <div class="step-item" id="step-3-item">
                        <div class="step-dot">03</div>
                    </div>
                </div>
            </div>

            <div class="modal-scroll-area">
                <form id="koreksiForm">
                    @csrf

                    {{-- STEP 1 --}}
                    <div class="form-step active" id="step-1">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">🔍 <span>Pencarian Kata</span></h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="label-modern">Sumber Kamus *</label>
                                    <select id="asal_kamus" name="asal_kamus" class="modern-field">
                                        <option value="">Pilih Sumber...</option>
                                        @foreach ($kamusList as $asal) <option value="{{ $asal }}">{{ $asal }}</option> @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="label-modern">Cari Kata *</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="kata" name="kata" class="modern-field flex-1" placeholder="Ketik kata...">
                                        <button type="button" id="btnCari" class="px-6 bg-slate-900 text-white rounded-xl font-bold text-[10px] tracking-widest hover:bg-blue-600 transition-all">CARI</button>
                                    </div>
                                </div>
                            </div>
                            <div id="detailKata" class="hidden"></div>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="form-step" id="step-2">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">✍️ <span>Detail Perbaikan</span></h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="label-modern">Bagian yang Salah *</label>
                                    <select id="bagian_dikoreksi" name="bagian_dikoreksi" class="modern-field">
                                        <option value="">Pilih Bagian...</option>
                                        <option value="kata">Ejaan Kata</option>
                                        <option value="suku_kata">Suku Kata</option>
                                        <option value="kelas_kata">Kelas Kata</option>
                                        <option value="arti">Arti / Definisi</option>
                                        <option value="contoh">Contoh</option>
                                    </select>
                                </div>
                                <div id="nilaiBaruWrapper">
                                    <label class="label-modern">Versi Perbaikan *</label>
                                    <input type="text" id="nilai_baru" name="nilai_baru" class="modern-field" placeholder="Ketik versi yang benar...">
                                </div>
                            </div>
                            <div>
                                <label class="label-modern">Alasan Koreksi *</label>
                                <textarea id="alasan" name="alasan" rows="3" class="modern-field" placeholder="Jelaskan alasan perbaikan..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="form-step" id="step-3">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">👤 <span>Identitas Pengaju</span></h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="label-modern">Nama Lengkap *</label>
                                    <input type="text" id="nama_pengoreksi" name="nama_pengoreksi" class="modern-field" placeholder="Nama Anda...">
                                </div>
                                <div>
                                    <label class="label-modern">Email / Pos-el (Opsional)</label>
                                    <input type="email" id="email_pengoreksi" name="email_pengoreksi" class="modern-field" placeholder="alamat@email.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="footer-divider"></div>

            <div class="px-10 py-6 bg-white flex justify-between items-center">
                <button type="button" id="prevBtn" class="group flex items-center gap-3 px-6 py-2.5 rounded-xl border border-slate-200 text-[11px] font-black text-slate-500 tracking-[0.2em] invisible transition-all duration-300 hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-95 shadow-sm">
                    <span class="inline-block transition-transform duration-300 group-hover:-translate-x-1">←</span>
                    KEMBALI
                </button>
                <div class="flex gap-4">
                    <button type="button" id="nextBtn" class="btn-nav btn-primary shadow-lg shadow-slate-100">LANJUTKAN</button>
                    <button type="button" id="submitBtn" class="btn-nav bg-blue-600 text-white hidden shadow-lg shadow-blue-100">KIRIM SEKARANG</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        AOS.init();
        let currentStep = 1;

        const modal = document.getElementById('modalKoreksi');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressFill = document.getElementById('progressFill');
        const koreksiForm = document.getElementById('koreksiForm');

        // --- MODERN SWEETALERT CONFIG ---
        const CustomAlert = Swal.mixin({
            customClass: {
                popup: 'swal2-popup-custom',
                title: 'swal2-title-custom',
                confirmButton: 'btn-nav btn-primary px-8',
                cancelButton: 'btn-nav bg-slate-100 text-slate-600 px-8 ml-2'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        });

        // Controls
        document.getElementById('openModal').onclick = () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        document.getElementById('btnCloseTop').onclick = () => {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        };

        function updateUI() {
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            document.getElementById(`step-${currentStep}`).classList.add('active');
            progressFill.style.width = ((currentStep - 1) / 2) * 100 + '%';

            for (let i = 1; i <= 3; i++) {
                const item = document.getElementById(`step-${i}-item`);
                if (i < currentStep) item.className = 'step-item completed';
                else if (i === currentStep) item.className = 'step-item active';
                else item.className = 'step-item';
                item.querySelector('.step-dot').innerHTML = i < currentStep ? '✓' : `0${i}`;
            }

            prevBtn.style.visibility = currentStep === 1 ? 'hidden' : 'visible';
            if (currentStep === 3) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }
        }

        nextBtn.onclick = () => {
            let error = "";
            if (currentStep === 1) {
                if (!document.getElementById('asal_kamus').value) error = "Pilih sumber kamus!";
                else if (!document.getElementById('kata').value) error = "Isi kata yang ingin dicari!";
            } else if (currentStep === 2) {
                if (!document.getElementById('bagian_dikoreksi').value) error = "Pilih bagian yang salah!";
                else if (!document.getElementById('nilai_baru').value) error = "Isi perbaikan yang benar!";
                else if (!document.getElementById('alasan').value) error = "Berikan alasan koreksi!";
            }

            if (error) {
                return CustomAlert.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: error
                });
            }
            currentStep++;
            updateUI();
        };

        prevBtn.onclick = () => {
            if (currentStep > 1) {
                currentStep--;
                updateUI();
            }
        };

        // Cari Kata & Detail
        document.getElementById('btnCari').onclick = async () => {
            const kamus = document.getElementById('asal_kamus').value;
            const kata = document.getElementById('kata').value;
            const box = document.getElementById('detailKata');

            if (!kamus || !kata) return CustomAlert.fire({
                icon: 'info',
                title: 'Pilih kamus & kata!'
            });

            box.innerHTML = `<div class="p-8 text-center text-blue-500 font-bold animate-pulse">SEDANG MENCARI...</div>`;
            box.classList.remove('hidden');

            try {
                const res = await fetch(`/koreksi/detail/${encodeURIComponent(kamus)}/${encodeURIComponent(kata)}`);
                const data = await res.json();
                if (data.kata) {
                    box.innerHTML = `
                        <div class="preview-glass animate__animated animate__fadeIn">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm text-left">
                                <div><p class="label-modern">Kata</p><p class="font-bold text-slate-800 text-lg">${data.kata}</p></div>
                                <div><p class="label-modern">Suku Kata</p><p class="font-bold text-slate-800">${data.suku_kata || '-'}</p></div>
                                <div><p class="label-modern">Kelas</p><p class="font-bold text-blue-600 uppercase">${data.kelas_kata || '-'}</p></div>
                                <div class="col-span-full border-t border-slate-100 pt-4"><p class="label-modern">Arti</p><p class="text-slate-600 italic">"${data.arti || '-'}"</p></div>
                                <div class="col-span-full pt-2"><p class="label-modern">Contoh</p><p class="text-slate-600 italic">"${data.contoh || '-'}"</p></div>
                            </div>
                        </div>`;
                } else {
                    box.innerHTML = `<div class="p-8 bg-red-50 text-red-500 rounded-xl text-center">⚠️ KATA TIDAK DITEMUKAN</div>`;
                }
            } catch (e) {
                box.innerHTML = `<div class="p-8 text-center">GAGAL TERHUBUNG KE SERVER</div>`;
            }
        };

        // Submit Final
        submitBtn.onclick = async () => {
            if (!document.getElementById('nama_pengoreksi').value) return CustomAlert.fire({
                icon: 'error',
                title: 'Lengkapi Data',
                text: 'Nama pengoreksi wajib diisi!'
            });

            const result = await CustomAlert.fire({
                title: 'Kirim Sekarang?',
                text: "Pastikan data yang Anda masukkan sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                CustomAlert.fire({
                    title: 'Sedang Mengirim...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch("{{ route('koreksi.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: new FormData(koreksiForm)
                    });
                    if (response.ok) {
                        CustomAlert.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Koreksi Anda telah masuk ke sistem kami.'
                            })
                            .then(() => window.location.reload());
                    } else {
                        throw new Error('Gagal menyimpan');
                    }
                } catch (e) {
                    CustomAlert.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan sistem.'
                    });
                }
            }
        };

        // Dropdown Kelas Kata
        document.getElementById('bagian_dikoreksi').onchange = function() {
            const wrapper = document.getElementById('nilaiBaruWrapper');
            if (this.value === 'kelas_kata') {
                wrapper.innerHTML = `<label class="label-modern">Pilih Kelas Kata Baru *</label>
                <select id="nilai_baru" name="nilai_baru" class="modern-field">
                    <option value="">-- Pilih --</option>
                    <option value="n">Nomina (n)</option><option value="v">Verba (v)</option><option value="adj">Adjektiva (adj)</option>
                    <option value="adv">Adverbia (adv)</option><option value="num">Numeralia (num)</option><option value="pron">Pronomina (pron)</option>
                </select>`;
            } else {
                wrapper.innerHTML = `<label class="label-modern">Versi Perbaikan Baru *</label>
                <input type="text" id="nilai_baru" name="nilai_baru" class="modern-field" placeholder="Input perbaikan...">`;
            }
        };
    </script>
</body>

</html>
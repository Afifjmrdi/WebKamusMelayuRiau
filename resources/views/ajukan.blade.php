<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Kosakata - Kemala v2.0</title>

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
            overflow-x: hidden;
        }

        /* --- BACKGROUND BATIK --- */
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

        /* Biarkan animasi kedip yang mengontrol bayangannya */
        @keyframes biru-kedip {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .btn-kedip-biru {
            animation: biru-kedip 2s infinite !important;
            /* Tambahkan !important di sini */
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 10;
        }

        /* Memastikan tombol tetap terlihat solid saat ditekan */
        .btn-nav:active {
            transform: scale(0.95) !important;
        }

        /* --- STEP INDICATOR --- */
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
        }

        .step-item.active .step-dot {
            background: #3b82f6;
            color: white;
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

        /* --- MODAL STRUCTURE --- */
        #modalAjukan {
            backdrop-filter: blur(12px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        #modalAjukan.active {
            display: flex;
        }

        .modal-glass {
            background: #ffffff;
            border-radius: 1.25rem;
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

        /* --- NAV BUTTONS --- */
        .btn-nav {
            padding: 1rem 2.2rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        /* Warna Dasar (Slate 900 / Hitam Kebiruan) */
        .btn-primary {
            background-color: #1e293b !important;
            color: white !important;
            border: none !important;
        }

        .btn-primary:hover {
            background-color: #2563eb !important;
            color: white !important;
            /* JANGAN tambahkan box-shadow !important di sini agar animasi kedip tidak mati */
            transform: translateY(-2px) scale(1.1);
        }

        #prevBtn:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        .footer-divider {
            height: 1px;
            width: 85%;
            margin: 0 auto;
            background: #f1f5f9;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.4s ease forwards;
        }

        /* --- INFO CARDS --- */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .card-glow-blue:hover {
            box-shadow: 0 0 30px 5px rgba(59, 130, 246, 0.25);
            border-color: rgba(59, 130, 246, 0.4);
        }

        .card-glow-amber:hover {
            box-shadow: 0 0 30px 5px rgba(245, 158, 11, 0.25);
            border-color: rgba(245, 158, 11, 0.4);
        }

        .card-glow-emerald:hover {
            box-shadow: 0 0 30px 5px rgba(16, 185, 129, 0.25);
            border-color: rgba(16, 185, 129, 0.4);
        }

        .swal2-popup-custom {
            border-radius: 1.5rem !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
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
                <h1 class="text-7xl md:text-9xl font-black text-slate-900 mb-4 tracking-tighter italic opacity-5 absolute -top-16 left-1/2 -translate-x-1/2 select-none">Ajukan</h1>
                <p class="text-blue-600 font-black text-xs tracking-[0.3em] mb-4">Layanan Ajukan Kosakata Baru</p>
                <h2 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">Ajukan Kosakata</h2>

                <div class="max-w-3xl mx-auto">
                    <p class="text-slate-500 text-base md:text-lg leading-relaxed">
                        Fitur <span class="text-slate-900 font-bold underline decoration-blue-500/30">Ajukan Kosakata</span> memudahkan pengguna untuk turut memperkaya kosakata bahasa Melayu Riau. Bersama <span class="text-slate-900 font-semibold">Balai Bahasa Provinsi Riau</span>, kami menjaga keakuratan bahasa Melayu Riau secara kolaboratif.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto mb-16">
                <div data-aos="fade-up" data-aos-delay="100"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-blue cursor-default">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">01</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-blue-600">Usulkan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Usulkan kosakata baru yang belum tersedia di dalam Kamus Elektronik Bahasa Melayu Riau.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="200"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-amber cursor-default" style="animation-delay: 0.5s;">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">02</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-amber-600">Lengkapi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Berikan definisi, kelas kata, dan contoh kalimat agar kosakata yang diajukan lebih informatif.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="300"
                    class="group animate-float bg-white p-8 rounded-2xl border border-slate-100 shadow-sm transition-all duration-500 card-glow-emerald cursor-default" style="animation-delay: 1s;">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white group-hover:rotate-[360deg] transition-all duration-700 shadow-inner">
                        <span class="font-black text-xl">03</span>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-xl mb-3 tracking-tight transition-colors duration-300 group-hover:text-emerald-600">Validasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Tim Balai Bahasa akan meninjau dan memverifikasi usulan Anda sebelum diterbitkan ke kamus publik.</p>
                </div>
            </div>

            <div class="text-center">
                <button id="btnOpenModal" class="btn-nav btn-primary btn-kedip-biru text-sm px-10 py-5 rounded-2xl shadow-2xl tracking-widest font-black transition-all hover:scale-110 active:scale-95">
                    Ajukan Kosakata Sekarang
                </button>
            </div>
        </div>
    </section>

    {{-- MODAL --}}
    <div id="modalAjukan" class="fixed inset-0 z-[200] bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="modal-glass animate__animated animate__fadeInUp animate__faster">
            <div class="px-10 pt-10 pb-6 bg-white">
                <div class="w-full flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase">Formulir Pengajuan</h2>
                    </div>
                    <button id="btnCloseTop" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-300 hover:text-red-500">
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
                <form id="ajukanForm">
                    <div class="form-step active" id="step-1">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800">📝 Tahap 1: Data Kosakata</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="label-modern">Kamus Tujuan *</label>
                                    <select id="asal_kamus" name="asal_kamus" class="modern-field">
                                        <option value="">Pilih kamus tujuan</option>
                                        @foreach ($daftarAsalKamus as $kamus) <option value="{{ $kamus }}">{{ $kamus }}</option> @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="label-modern">Kata Baru *</label>
                                    <input type="text" id="kata" name="kata" class="modern-field" placeholder="Masukkan kata...">
                                </div>
                                <div>
                                    <label class="label-modern">Suku Kata *</label>
                                    <input type="text" id="suku_kata" name="suku_kata" class="modern-field" placeholder="Pemisah suku kata...">
                                </div>
                                <div>
                                    <label class="label-modern">Kelas Kata *</label>
                                    <select id="kelas_kata" name="kelas_kata" class="modern-field">
                                        <option value="">Pilih kelas kata</option>
                                        <option value="n">Nomina</option>
                                        <option value="v">Verba</option>
                                        <option value="adj">Adjektiva</option>
                                        <option value="adv">Adverbia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-step" id="step-2">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800">📖 Tahap 2: Makna & Penggunaan</h3>
                            <div>
                                <label class="label-modern">Arti / Definisi *</label>
                                <textarea id="arti" name="arti" rows="3" class="modern-field" placeholder="Tuliskan arti kata..."></textarea>
                            </div>
                            <div>
                                <label class="label-modern">Contoh Kalimat</label>
                                <textarea id="contoh" name="contoh" rows="2" class="modern-field" placeholder="Contoh penggunaan..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-step" id="step-3">
                        <div class="space-y-8">
                            <h3 class="text-base font-bold text-slate-800">👤 Tahap 3: Identitas Pengaju</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="label-modern">Nama Pengaju *</label>
                                    <input type="text" id="asal_pengaju" name="asal_pengaju" class="modern-field" placeholder="Nama Anda/Lembaga...">
                                </div>
                                <div>
                                    <label class="label-modern">Email (Opsional)</label>
                                    <input type="email" id="email_pengaju" name="email_pengaju" class="modern-field" placeholder="email@contoh.com">
                                </div>
                            </div>
                            <div>
                                <label class="label-modern">Alasan Pengajuan *</label>
                                <textarea id="alasan_pengajuan" name="alasan_pengajuan" rows="3" class="modern-field" placeholder="Alasan pengajuan..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="footer-divider"></div>
            <div class="px-10 py-6 bg-white flex justify-between items-center">
                <button type="button" id="prevBtn" class="group flex items-center gap-3 px-6 py-2.5 rounded-xl border border-slate-200 text-[11px] font-black text-slate-500 tracking-[0.2em] invisible transition-all duration-300 active:scale-95 shadow-sm">
                    <span class="inline-block transition-transform duration-300 group-hover:-translate-x-1">←</span> KEMBALI
                </button>
                <div class="flex gap-4">
                    <button type="button" id="nextBtn" class="btn-nav btn-primary shadow-lg shadow-slate-100">LANJUTKAN</button>
                    <button type="button" id="submitBtn" class="btn-nav bg-blue-600 text-white hidden shadow-lg shadow-blue-100 uppercase">Kirim Pengajuan</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init();
            let currentStep = 1;

            // Element Selectors
            const modal = document.getElementById('modalAjukan');
            const btnOpenModal = document.getElementById('btnOpenModal');
            const btnCloseTop = document.getElementById('btnCloseTop');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressFill = document.getElementById('progressFill');
            const ajukanForm = document.getElementById('ajukanForm');

            // Input Selectors
            const inputKata = document.getElementById('kata');
            const inputSukuKata = document.getElementById('suku_kata');
            const inputAsalKamus = document.getElementById('asal_kamus');
            const inputKelasKata = document.getElementById('kelas_kata');
            const inputArti = document.getElementById('arti');
            const inputContoh = document.getElementById('contoh');
            const inputAsalPengaju = document.getElementById('asal_pengaju');
            const inputEmailPengaju = document.getElementById('email_pengaju');
            const inputAlasan = document.getElementById('alasan_pengajuan');

            const CustomAlert = Swal.mixin({
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn-nav btn-primary px-8',
                    cancelButton: 'btn-nav bg-slate-100 text-slate-600 px-8 ml-2'
                },
                buttonsStyling: false
            });

            btnOpenModal.onclick = () => {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            };
            btnCloseTop.onclick = () => {
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
                let error = false;
                if (currentStep === 1) {
                    if (!inputAsalKamus.value || !inputKata.value || !inputSukuKata.value || !inputKelasKata.value) error = true;
                } else if (currentStep === 2) {
                    if (!inputArti.value) error = true;
                }

                if (error) return CustomAlert.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Harap isi semua kolom wajib (*) sebelum melanjutkan.'
                });

                currentStep++;
                updateUI();
            };

            prevBtn.onclick = () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateUI();
                }
            };

            submitBtn.onclick = async () => {
                const data = {
                    kata: inputKata.value.trim(),
                    suku_kata: inputSukuKata.value.trim(),
                    asal_kamus: inputAsalKamus.value.trim(),
                    kelas_kata: inputKelasKata.value.trim(),
                    arti: inputArti.value.trim(),
                    contoh: inputContoh.value.trim(),
                    asal_pengaju: inputAsalPengaju.value.trim(),
                    email_pengaju: inputEmailPengaju.value.trim(),
                    alasan_pengajuan: inputAlasan.value.trim(),
                };

                if (!data.asal_pengaju || !data.alasan_pengajuan) {
                    return CustomAlert.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Nama pengaju dan alasan pengajuan wajib diisi.'
                    });
                }

                const confirm = await CustomAlert.fire({
                    title: 'Kirim Pengajuan?',
                    text: "Kosakata Anda akan ditinjau oleh tim Balai Bahasa.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim!'
                });

                if (confirm.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Mengirim...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    try {
                        const res = await fetch("{{ route('ajukan.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });

                        if (res.ok) {
                            CustomAlert.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Pengajuan Kosakata baru berhasil dikirim!'
                                })
                                .then(() => window.location.reload());
                        } else {
                            throw new Error('Gagal mengirim');
                        }
                    } catch (error) {
                        CustomAlert.fire({
                            icon: 'error',
                            title: 'Gagal 😢',
                            text: 'Terjadi kesalahan sistem. Silakan coba lagi.'
                        });
                    }
                }
            };
        });
    </script>
</body>

</html>
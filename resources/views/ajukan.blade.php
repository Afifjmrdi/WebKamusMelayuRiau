<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Ajukan Kosakata - Kamus Balai Bahasa Riau</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 100px;
            text-align: center;
        }

        .font-jetbrains {
            font-family: 'JetBrains Mono', monospace !important;
        }

        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        .guide-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 800px;
            width: 90%;
            animation: fade-up 0.8s ease-out forwards;
        }

        .guide-step {
            text-align: left;
            margin: 1.25rem 0;
        }

        .guide-step span {
            font-weight: 600;
            color: #4338ca;
        }

        .btn {
            padding: 0.75rem 1.75rem;
            border-radius: 0.2rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #6366f1;
            color: white;
            padding: 0.9rem 2.2rem;
            border-radius: 0.2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
        }

        /* === Compact Modal === */
        .modal-bg {
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(6px);
            display: none;
            position: fixed;
            inset: 0;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            width: 85%;
            max-width: 800px;
            animation: fade-in 0.5s ease-out;
        }

        .modal h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.75rem;
        }

        .form-group {
            display: grid;
            gap: 0.75rem;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        label {
            font-weight: 500;
            color: #334155;
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.85rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.45rem 0.6rem;
            font-size: 0.85rem;
            color: #334155;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        textarea {
            min-height: 60px;
            resize: vertical;
        }

        .btn {
            padding: 0.75rem 1.75rem;
            border-radius: 0.2rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        #detailKata {
            background: #f1f5f9;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-top: 0.75rem;
            font-size: 0.8rem;
            color: #334155;
        }

        #detailKata b {
            color: #4338ca;
        }

        hr {
            margin: 0.75rem 0;
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Mobile: modal tetap punya batas tinggi supaya tidak keluar dari card */
        @media (max-width: 768px) {
            #modalAjukan>div {
                max-height: 90vh !important;
                overflow-y: auto !important;
            }
        }

        /* Laptop/desktop: modal bebas tanpa scrollbar */
        @media (min-width: 769px) {
            #modalAjukan>div {
                max-height: none !important;
                overflow: visible !important;
            }
        }
    </style>
</head>

<body class="font-montserrat">
    {{---Navbar---}}
    @include('partials.navbar')

    <section id="panduan"
        class="relative min-h-screen flex flex-col items-center justify-center text-gray-800 overflow-hidden bg-cover bg-center"
        style="background-image: url('{{ asset('assets/background4.png') }}'); padding-top: 100px; padding-bottom: 100px;"
        data-aos="fade-in"
        data-aos-duration="1500">

        {{-- Bintang-bintang berputar dan berkelip --}}
        <div class="absolute inset-0 overflow-hidden">
            {{-- Bintang --}}
            @for ($i = 0; $i < 40; $i++)
                @php
                $top=rand(0, 95);
                $left=rand(0, 95);
                $size=rand(8, 16);
                @endphp
                <img src="{{ asset('assets/sparkle.png') }}"
                class="star absolute opacity-0 animate-[twinkle_3s_infinite_ease-in-out]"
                style="top: {{ $top }}%; left: {{ $left }}%; width: {{ $size }}px; height: {{ $size }}px;"
                alt="Star">
                @endfor
        </div>

        {{-- Kartu panduan Ajukan kata --}}
        <div class="relative z-10 fade-up mt-12 px-4 max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-700 mb-6 flex items-center justify-center gap-3 animate-fade-in">
                <span class="text-indigo-600 animate-bounce-slow"></span>
                Ajukan Kosakata
            </h1>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed animate-fade-in-delay">
                Fitur <span class="font-semibold text-blue-400">Ajukan Kosakata</span> memudahkan pengguna untuk turut memperkaya kosakata bahasa Melayu Riau.
                Bersama <span class="font-semibold text-blue-400">Balai Bahasa Provinsi Riau </span>
                <span class="font-semibold text-blue-400"></span>,kami menjaga keakuratan bahasa Melayu Riau secara kolaboratif.
            </p>
        </div>

        <br>
        <div
            class="guide-card relative z-10 bg-white/90 backdrop-blur-xl border border-white/40 rounded-2xl shadow-2xl p-10 max-w-4xl w-11/12 text-center transition-all duration-300 hover:shadow-indigo-300/40">

            <h2 class="text-3xl font-bold text-indigo-700 mb-10 drop-shadow-sm tracking-wide">
                Panduan Pengajuan Kosakata
            </h2>

            {{-- Step Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                {{-- Step 1 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-20 h-10 rounded-full text-lg shadow-md">
                            📘
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 1</h3>
                            <p class="text-gray-700">Pilih <b>kamus tujuan</b> tempat Kosakata baru akan diajukan.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-20 h-10 rounded-full text-lg shadow-md">
                            🔍
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 2</h3>
                            <p class="text-gray-700">Masukkan <b>kosakata</b> yang akan ditambahkan pada kolom “Kata”.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-20 h-10 rounded-full text-lg shadow-md">
                            🧩
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 3</h3>
                            <p class="text-gray-700">Isi <b>semua kolom</b> Berkaitan dengan kosakata yang diajukan.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-20 h-10 rounded-full text-lg shadow-md">
                            ✍️
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 4</h3>
                            <p class="text-gray-700">Isi <b> identitas pengaju</b> dan alasan pengajuan.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 5 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all md:col-span-2">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-10 h-10 rounded-full text-lg shadow-md">
                            🚀
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 5</h3>
                            <p class="text-gray-700">Klik tombol <b>"Kirim Pengajuan"</b> untuk mengirimkan pengajuan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <button id="openModalAjukan"
                class="btn-primary mt-10 px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg hover:bg-indigo-700 transition-all">
                💬 Ajukan Kosakata Sekarang
            </button>

        </div>


        {{-- Animasi CSS tambahan --}}
        <style>
            @keyframes twinkle {

                0%,
                100% {
                    opacity: 0.3;
                    transform: scale(0.8) rotate(0deg);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.2) rotate(180deg);
                }
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </section>

    {{-- Modal Ajukan --}}
    <div id="modalAjukan"
        class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm
           flex justify-center items-start
           overflow-y-auto px-4 py-10">

        {{-- Card --}}
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-xl p-5 md:p-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    📝 Formulir Pengajuan Kosakata Baru
                </h2>

                {{-- Divider --}}
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2">
                    <div class="h-px bg-gray-300 md:col-span-2 w-full"></div>
                </div>
            </div>

            <form id="ajukanForm" class="space-y-6">
                @csrf

                {{-- ========================= --}}
                {{-- Kamus Tujuan --}}
                {{-- ========================= --}}
                <div>
                    <label class="font-semibold block">
                        Kamus Tujuan <span class="text-red-500">*</span>
                    </label>
                    <select id="asal_kamus" name="asal_kamus" required
                        class="w-full h-[48px] px-4 pr-10 rounded-md
                           border border-gray-200 bg-gray-50
                           appearance-none leading-normal
                           bg-no-repeat bg-[right_0.75rem_center] bg-[length:14px_14px]
                           focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        style="background-image: url('{{ asset('assets/down.png') }}'); background-size: 18px 18px;">
                        <option value="">Pilih kamus tujuan</option>
                        @foreach ($daftarAsalKamus as $kamus)
                        <option value="{{ $kamus }}">{{ $kamus }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- ========================= --}}
                {{-- Kata & Suku Kata --}}
                {{-- ========================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div>
                        <label class="font-semibold block">
                            Kata <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kata" name="kata"
                            class="w-full h-[48px] px-4 rounded-md
                               border border-gray-200 bg-gray-50 leading-none
                               focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Masukkan kata...">
                    </div>

                    <div>
                        <label class="font-semibold block">
                            Suku Kata <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="suku_kata" name="suku_kata"
                            class="w-full h-[48px] px-4 rounded-md
                               border border-gray-200 bg-gray-50 leading-none
                               focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Masukkan suku kata...">
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- Arti & Contoh --}}
                {{-- ========================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold block">
                            Arti <span class="text-red-500">*</span>
                        </label>
                        <textarea id="arti" name="arti" rows="2"
                            class="w-full p-3 rounded-md
                               border border-gray-200 bg-gray-50 resize-none"
                            placeholder="Tuliskan arti kata..."></textarea>
                    </div>

                    <div>
                        <label class="font-semibold block">
                            Contoh Kalimat (Opsional)
                        </label>
                        <textarea id="contoh" name="contoh" rows="2"
                            class="w-full p-3 rounded-md
                               border border-gray-200 bg-gray-50 resize-none"
                            placeholder="Tuliskan contoh penggunaan..."></textarea>
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- Kelas Kata --}}
                {{-- ========================= --}}
                <div>
                    <label class="font-semibold block">
                        Kelas Kata <span class="text-red-500">*</span>
                    </label>
                    <select id="kelas_kata" name="kelas_kata" required
                        class="w-full h-[48px] px-4 pr-10 rounded-md
                           border border-gray-200 bg-gray-50
                           appearance-none leading-normal
                           bg-no-repeat bg-[right_0.75rem_center] bg-[length:14px_14px]
                           focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        style="background-image: url('{{ asset('assets/down.png') }}'); background-size: 18px 18px;">
                        <option value="">Pilih kelas kata</option>
                        <option value="n">Nomina</option>
                        <option value="v">Verba</option>
                        <option value="adj">Adjektiva</option>
                        <option value="adv">Adverbia</option>
                        <option value="pron">Pronomina</option>
                        <option value="num">Numeralia</option>
                        <option value="prep">Preposisi</option>
                        <option value="konj">Konjungsi</option>
                        <option value="interj">Interjeksi</option>
                        <option value="part">Partikel</option>
                    </select>
                </div>

                {{-- ========================= --}}
                {{-- Nama & Email --}}
                {{-- ========================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold block">
                            Nama Pengaju <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="asal_pengaju" name="asal_pengaju" placeholder="Contoh : BBPR"
                            class="w-full h-[48px] px-4 rounded-md
                               border border-gray-200 bg-gray-50">
                    </div>

                    <div>
                        <label class="font-semibold block">
                            Pos-el (Opsional)
                        </label>
                        <input type="email" id="email_pengaju" name="email_pengaju" placeholder="Contoh : balaibahasariau@gmail.com"
                            class="w-full h-[48px] px-4 rounded-md
                               border border-gray-200 bg-gray-50">
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- Alasan --}}
                {{-- ========================= --}}
                <div>
                    <label class="font-semibold block">
                        Alasan Pengajuan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan_pengajuan" name="alasan_pengajuan" rows="3"
                        class="w-full p-3 rounded-md
                           border border-gray-200 bg-gray-50 resize-none"
                        placeholder="Jelaskan alasan pengajuan..."></textarea>
                </div>

                {{-- Divider bawah --}}
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2">
                    <div class="h-px bg-gray-300 md:col-span-2 w-full"></div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3">
                    <button type="button" id="btnBatalAjukan"
                        class="btn-secondary px-5 py-2 rounded-md bg-gray-200 hover:bg-gray-300 font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 h-[50px] rounded-md
                           bg-indigo-600 text-white font-semibold
                           hover:bg-indigo-700 transition">
                        Kirim Pengajuan
                    </button>
                </div>

            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        // ======== MODAL SHOW/HIDE ========

        const openModalBtn = document.getElementById('openModalAjukan');
        const modal = document.getElementById('modalAjukan');
        const cancelBtn = document.getElementById('btnBatalAjukan');
        const modalContent = modal.querySelector('div');

        // Tampilkan modal
        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        });

        // Tutup modal ketika klik tombol batal
        cancelBtn.addEventListener('click', () => {
            modalContent.classList.add('scale-95', 'opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        });

        // Tutup modal kalau klik di luar isi modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modalContent.classList.add('scale-95', 'opacity-0');
                modalContent.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }
        });
    </script>

    <script>
        document.getElementById('ajukanForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = {
                kata: kata.value.trim(),
                suku_kata: suku_kata.value.trim(),
                asal_kamus: asal_kamus.value.trim(),
                kelas_kata: kelas_kata.value.trim(),
                arti: arti.value.trim(),
                contoh: contoh.value.trim(),
                asal_pengaju: asal_pengaju.value.trim(),
                email_pengaju: email_pengaju.value.trim(),
                alasan_pengajuan: alasan_pengajuan.value.trim(),
            };

            if (!data.asal_kamus || !data.kata || !data.suku_kata || !data.kelas_kata || !data.arti || !data.asal_pengaju || !data.alasan_pengajuan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap 💬',
                    text: 'Harap isi semua kolom wajib sebelum mengirim pengajuan.',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }


            // Validasi input
            if (!data.kata || !data.suku_kata || !data.kelas_kata || !data.arti || !data.asal_pengaju || !data.alasan_pengajuan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap 💬',
                    text: 'Harap isi semua kolom wajib sebelum mengirim pengajuan.',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }

            try {
                const res = await fetch("{{ route('ajukan.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify(data)
                });

                if (res.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pengajuan Kosakata baru berhasil dikirim!',
                        confirmButtonColor: '#6366f1'
                    }).then(() => {
                        // Reset form
                        document.getElementById('ajukanForm').reset();

                        // Animasi tutup modal—sama seperti koreksi.blade.php
                        modalContent.classList.add('scale-95', 'opacity-0');
                        modalContent.classList.remove('scale-100', 'opacity-100');

                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 200);
                    });
                } else {
                    const errText = await res.text();
                    console.error('Response Error:', errText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal 😢',
                        text: 'Terjadi kesalahan saat mengirim data ke server.',
                        confirmButtonColor: '#6366f1'
                    });
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Server ⚠️',
                    text: 'Tidak dapat terhubung ke server. Periksa koneksi Anda.',
                    confirmButtonColor: '#6366f1'
                });
            }
        });
    </script>


</body>

</html>
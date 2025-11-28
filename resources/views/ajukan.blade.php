<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Ajukan KosaKata - Kamus Balai Bahasa Riau</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    </style>
</head>

<body>
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
            <h1 class="text-4xl md:text-6xl font-bold text-gray-700 mb-6 flex items-center justify-center gap-3 animate-fade-in font-jetbrains">
                <span class="text-indigo-600 animate-bounce-slow"></span>
                Ajukan KosaKata
            </h1>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed animate-fade-in-delay">
                Fitur <span class="font-semibold text-blue-400">Ajukan KosaKata</span> memudahkan pengguna untuk membantu memperkaya kosakata bahasa melayu dari berbagai daerah,
                Bersama <span class="font-semibold text-blue-400">Balai Bahasa Provinsi Riau</span>
                <span class="font-semibold text-blue-400"></span>kami menjaga keakuratan bahasa daerah secara kolaboratif.
            </p>
        </div>

        <br>
        <div
            class="guide-card relative z-10 bg-white/90 backdrop-blur-xl border border-white/40 rounded-2xl shadow-2xl p-10 max-w-4xl w-11/12 text-center transition-all duration-300 hover:shadow-indigo-300/40">

            <h2 class="text-3xl font-bold text-indigo-700 mb-10 drop-shadow-sm tracking-wide">
                Panduan Pengajuan Ajukan Kosakata
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
                            <p class="text-gray-700">Pilih <b>Kamus Tujuan</b> tempat Kosakata baru akan diajukan.</p>
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
                            <p class="text-gray-700">Cari <b>Kata</b> Masukkan Kosakata apa yang mau ditambahkan.</p>
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
                            <p class="text-gray-700">Isi <b>Semua Kolom</b> Berkaitan dengan kosakata yang diajukan.</p>
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
                            <p class="text-gray-700">Isi <b>identitas pengaju</b> seperti alasan dan identitas pengaju.</p>
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

    <!-- Modal Form Ajukan Kosakata Baru -->
    <div id="modalAjukan"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center transition-all duration-300">
        <div
            class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-8 relative transform scale-90 opacity-100 transition-all duration-300 ease-out">

            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="ri-edit-2-line text-indigo-500 mr-2 text-3xl"></i>
                📝 Formulir Pengajuan Kosakata Baru
            </h2>
            <hr class="mb-6 border-gray-200">

            <!-- Form -->
            <form id="ajukanForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                    <!-- Asal Kamus -->
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Kamus Tujuan <span class="text-red-500">*</span></label>
                        <select id="asal_kamus" name="asal_kamus"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Pilih kamus tujuan</option>
                            @foreach($daftarAsalKamus as $kamus)
                            <option value="{{ $kamus }}">{{ $kamus }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Kata -->
                    <div>
                        <label class="block font-semibold mb-1">Kata <span class="text-red-500">*</span></label>
                        <input type="text" id="kata" name="kata"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Masukkan kata baru...">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Suku Kata <span class="text-red-500">*</span></label>
                        <input type="text" id="suku_kata" name="suku_kata"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Masukkan Suku Kata...">
                    </div>

                    <!-- Contoh Kalimat -->
                    <div>
                        <label class="block font-semibold mb-1">Contoh Kalimat (Opsional)</label>
                        <textarea id="contoh" name="contoh" rows="2"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Tuliskan contoh penggunaan kata..."></textarea>
                    </div>

                    <!-- Arti -->
                    <div>
                        <label class="block font-semibold mb-1">Arti <span class="text-red-500">*</span></label>
                        <textarea id="arti" name="arti" rows="2"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Tuliskan arti kata..."></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Kelas Kata <span class="text-red-500">*</span></label>
                        <select id="kelas_kata" name="kelas_kata"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Pilih kelas kata</option>
                            <option>Nomina (Kata Benda)</option>
                            <option>Verba (Kata Kerja)</option>
                            <option>Adjektiva (Kata Sifat)</option>
                            <option>Adverbia (Kata Keterangan)</option>
                            <option>Pronomina (Kata Ganti)</option>
                            <option>Numeralia (Kata Bilangan)</option>
                            <option>Preposisi (Kata Depan)</option>
                            <option>Konjungsi (Kata Penghubung)</option>
                            <option>Interjeksi (Kata Seru)</option>
                            <option>Partikel</option>
                        </select>
                    </div>

                    <!-- Nama Pengaju -->
                    <div>
                        <label class="block font-semibold mb-1">Nama Pengaju <span class="text-red-500">*</span></label>
                        <input type="text" id="asal_pengaju" name="asal_pengaju"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Nama Anda">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block font-semibold mb-1">Email (Opsional)</label>
                        <input type="email" id="email_pengaju" name="email_pengaju"
                            class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Email Anda">
                    </div>
                </div>

                <!-- Alasan Pengajuan -->
                <div>
                    <label class="block font-semibold mb-1">Alasan Pengajuan <span class="text-red-500">*</span></label>
                    <textarea id="alasan_pengajuan" name="alasan_pengajuan" rows="3"
                        class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        placeholder="Jelaskan mengapa kosakata ini perlu ditambahkan..."></textarea>
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" class="btn btn-secondary" id="btnBatalAjukan">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Koreksi</button>
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
                        text: 'Pengajuan kosakata baru berhasil dikirim!',
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
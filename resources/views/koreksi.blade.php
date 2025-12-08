<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Koreksi Kata - Kamus Balai Bahasa Riau</title>
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
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 90%;
            max-width: 900px;
            animation: fade-in 0.5s ease-out;
        }

        .modal h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        label {
            font-weight: 500;
            color: #334155;
            display: block;
            margin-bottom: 0.3rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
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
            min-height: 100px;
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
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #334155;
        }

        #detailKata b {
            color: #4338ca;
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

        {{-- Kartu panduan koreksi kata --}}
        <div class="relative z-10 fade-up mt-12 px-4 max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-700 mb-6 flex items-center justify-center gap-3 animate-fade-in font-jetbrains">
                <span class="text-indigo-600 animate-bounce-slow"></span>
                Koreksi Kata
            </h1>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed animate-fade-in-delay">
                Fitur <span class="font-semibold text-blue-400">Koreksi Kata</span> memudahkan pengguna untuk membantu memperbaiki
                data dalam <span class="font-semibold text-blue-400">Kamus Balai Bahasa Riau</span>.
                Bersama <span class="font-semibold text-blue-400">Balai Bahasa Provinsi Riau</span>
                <span class="font-semibold text-blue-400"></span>kami menjaga keakuratan bahasa daerah secara kolaboratif.
            </p>
        </div>

        <br>
        <div
            class="guide-card relative z-10 bg-white/90 backdrop-blur-xl border border-white/40 rounded-2xl shadow-2xl p-10 max-w-4xl w-11/12 text-center transition-all duration-300 hover:shadow-indigo-300/40">

            <h2 class="text-3xl font-bold text-indigo-700 mb-10 drop-shadow-sm tracking-wide">
                Panduan Pengajuan Koreksi Kata
            </h2>

            {{-- Step Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                {{-- Step 1 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-16 h-10 rounded-full text-lg shadow-md">
                            📘
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 1</h3>
                            <p class="text-gray-700">Pilih <b>asal kamus</b> tempat kata tersebut berada.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-18 h-10 rounded-full text-lg shadow-md">
                            🔍
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 2</h3>
                            <p class="text-gray-700">Cari <b>kata</b> yang ingin dikoreksi untuk melihat detailnya.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-15 h-10 rounded-full text-lg shadow-md">
                            🧩
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 3</h3>
                            <p class="text-gray-700">Tentukan <b>bagian mana</b> yang ingin dikoreksi.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div
                    class="p-5 rounded-xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white shadow-md hover:shadow-lg transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center bg-indigo-500 text-white w-18 h-10 rounded-full text-lg shadow-md">
                            ✍️
                        </div>
                        <div>
                            <h3 class="font-semibold text-indigo-700 text-lg mb-1">Langkah 4</h3>
                            <p class="text-gray-700">Isi <b>versi yang benar</b>, alasan, dan identitas pengoreksi.</p>
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
                            <p class="text-gray-700">Klik tombol <b>"Kirim Koreksi"</b> untuk mengirimkan pengajuan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <button id="openModal"
                class="btn-primary mt-10 px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg hover:bg-indigo-700 transition-all">
                💬 Ajukan Koreksi Sekarang
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


    {{-- Modal Form --}}
    <div id="modalKoreksi" class="modal-bg">
        <div class="modal">
            <h2>📝 Formulir Koreksi Kata</h2>
            <hr class="mb-6 border-gray-200">
            <form id="koreksiForm">
                @csrf

                <div class="form-group">
                    <div>
                        <label for="asal_kamus">Asal Kamus<span class="text-red-500">*</span></label>
                        <select id="asal_kamus" name="asal_kamus" required>
                            <option value="">Pilih asal kamus</option>
                            @foreach ($kamusList as $asal)
                            <option value="{{ $asal }}">{{ $asal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kata">Kata<span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" id="kata" name="kata" placeholder="Masukkan kata...">
                            <button type="button" id="btnCari" class="btn btn-primary whitespace-nowrap">Cari</button>
                        </div>
                    </div>
                </div>

                <div id="detailKata" class="hidden"></div>

                <div class="form-group mt-6">
                    <div>
                        <label for="bagian_dikoreksi">Bagian Dikoreksi<span class="text-red-500">*</span></label>
                        <select id="bagian_dikoreksi" name="bagian_dikoreksi">
                            <option value="">Pilih bagian</option>
                            <option value="kata">Kata</option>
                            <option value="suku_kata">Suku Kata</option>
                            <option value="arti">Arti</option>
                            <option value="kelas_kata">Kelas Kata</option>
                            <option value="contoh">Contoh</option>
                        </select>
                    </div>

                    <div id="nilaiBaruWrapper">
                        <label for="nilai_baru">Nilai Baru / Versi Benar<span class="text-red-500">*</span></label>
                        <input type="text" id="nilai_baru" name="nilai_baru" placeholder="Tuliskan versi yang benar...">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="alasan">Alasan Koreksi<span class="text-red-500">*</span></label>
                    <textarea id="alasan" name="alasan" placeholder="Jelaskan alasan pengajuan koreksi..."></textarea>
                </div>

                <div class="form-group mt-6">
                    <div>
                        <label for="nama_pengoreksi">Nama Pengoreksi<span class="text-red-500">*</span></label>
                        <input type="text" id="nama_pengoreksi" name="nama_pengoreksi" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label for="email_pengoreksi">Email (opsional)</label>
                        <input type="email" id="email_pengoreksi" name="email_pengoreksi" placeholder="Email Anda (opsional)">
                    </div>
                </div>
                <hr class="my-4 border-gray-200">

                <div class="flex justify-end mt-8 gap-3">
                    <button type="button" class="btn btn-secondary" id="btnClose">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Koreksi</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        const modal = document.getElementById('modalKoreksi');
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('btnClose');
        const bagianSelect = document.getElementById('bagian_dikoreksi');
        const nilaiWrapper = document.getElementById('nilaiBaruWrapper');

        // Modal
        openModal.addEventListener('click', () => modal.style.display = 'flex');
        closeModal.addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });

        // Daftar kelas kata
        const daftarKelasKata = [
            'n', // Nomina (Kata Benda)
            'v', // Verba (Kata Kerja)
            'adj', // Adjektiva (Kata Sifat)
            'adv', // Adverbia (Kata Keterangan)
            'pron', // Pronomina (Kata Ganti)
            'num', // Numeralia (Kata Bilangan)
            'prep', // Preposisi (Kata Depan)
            'konj', // Konjungsi (Kata Penghubung)
            'interj', // Interjeksi (Kata Seru)
            'part', // Partikel

        ];

        // Ubah input nilai_baru jika "kelas_kata" dipilih
        bagianSelect.addEventListener('change', () => {
            const bagian = bagianSelect.value;

            if (bagian === 'kelas_kata') {
                nilaiWrapper.innerHTML = `
                <label for="nilai_baru">Nilai Baru / Versi Benar</label>
                <select id="nilai_baru" name="nilai_baru">
                    <option value="">Pilih kelas kata</option>
                    ${daftarKelasKata.map(k => `<option value="${k}">${k}</option>`).join('')}
                </select>
            `;
            } else {
                nilaiWrapper.innerHTML = `
                <label for="nilai_baru">Nilai Baru / Versi Benar</label>
                <input type="text" id="nilai_baru" name="nilai_baru" placeholder="Tuliskan versi yang benar...">
            `;
            }
        });

        // Tombol cari
        document.getElementById('btnCari').addEventListener('click', async () => {
            const kamus = document.getElementById('asal_kamus').value;
            const kata = document.getElementById('kata').value;
            const detailBox = document.getElementById('detailKata');

            if (!kamus || !kata) {
                Swal.fire('Perhatian', 'Pilih asal kamus dan isi kata terlebih dahulu.', 'warning');
                return;
            }

            const res = await fetch(`/koreksi/detail/${encodeURIComponent(kamus)}/${encodeURIComponent(kata)}`);
            const data = await res.json();

            if (data && data.kata) {
                detailBox.classList.remove('hidden');
                detailBox.innerHTML = `
                <b>Detail Kosakata:</b><br>
                <div><b>Kata:</b> ${data.kata}</div>
                <div><b>Suku Kata:</b> ${data.suku_kata}</div>
                <div><b>Kelas Kata:</b> ${data.kelas_kata ?? '-'}</div>
                <div><b>Arti:</b> ${data.arti ?? '-'}</div>
                <div><b>Contoh:</b> ${data.contoh ?? '-'}</div>`;
            } else {
                detailBox.classList.remove('hidden');
                detailBox.innerHTML = `<p class="text-red-500">Kata tidak ditemukan.</p>`;
            }
        });

        // Validasi dan submit
        document.getElementById('koreksiForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = {
                asal_kamus: document.getElementById('asal_kamus').value.trim(),
                kata: document.getElementById('kata').value.trim(),
                bagian_dikoreksi: document.getElementById('bagian_dikoreksi').value.trim(),
                nilai_baru: document.getElementById('nilai_baru').value.trim(),
                alasan: document.getElementById('alasan').value.trim(),
                nama_pengoreksi: document.getElementById('nama_pengoreksi').value.trim(),
                email_pengoreksi: document.getElementById('email_pengoreksi').value.trim()
            };

            const semuaKosong = Object.values(formData).every(v => v === '');
            if (semuaKosong) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Diisi 😅',
                    text: 'Anda belum mengisi apapun di form koreksi.',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }

            if (!formData.asal_kamus || !formData.kata || !formData.bagian_dikoreksi ||
                !formData.nilai_baru || !formData.alasan || !formData.nama_pengoreksi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap 💬',
                    text: 'Harap isi semua kolom wajib sebelum mengirim koreksi ya!',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }

            const res = await fetch('/koreksi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            if (res.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Pengajuan koreksi berhasil dikirim.',
                    confirmButtonColor: '#6366f1'
                }).then(() => {
                    // Reset formulir
                    document.getElementById('koreksiForm').reset();

                    // Tutup modal setelah klik OK
                    modal.style.display = 'none';
                });
            } else {
                Swal.fire('Gagal 😢', 'Terjadi kesalahan saat mengirim.', 'error');
            }
        });
    </script>

</body>

</html>
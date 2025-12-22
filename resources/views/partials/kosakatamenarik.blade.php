<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AOS (Animate On Scroll) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<style>
    /* Hilang di Chrome, Edge, Safari */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hilang di Firefox */
    .scrollbar-hide {
        scrollbar-width: none;
    }
</style>
<section class="px-6 md:px-16 py-14 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
    <div class="text-center mb-10" data-aos="fade-up" data-aos-delay="150">
        <h2 class="text-3xl md:text-4xl font-poppins font-semibold text-blue-800 mb-2">
            Kosakata Menarik Hari Ini
        </h2>
        <p class="text-gray-600 text-sm md:text-base">
            Temukan kosakata pilihan penuh makna dari <span class="font-semibold text-blue-500">berbagai bahasa Melayu Riau</span>
        </p>
    </div>

    <!-- Baris 1 -->
    <div class="relative w-full overflow-x-auto scrollbar-hide pt-4" data-aos="fade-up">
        <div class="flex gap-4 sm:gap-6 animate-scroll-left snap-x snap-mandatory">

            @forelse($kosakataHariIni->take(8) as $kata)
            <div
                class="flex-shrink-0 w-44 h-40 sm:w-64 sm:h-48 p-4 rounded-2xl
                       bg-gradient-to-br from-blue-100 to-white border border-blue-200
                       shadow-md hover:shadow-2xl transition-all duration-500
                       hover:-translate-y-2 hover:scale-[1.04] cursor-pointer group snap-start"
                onclick="showDetail(
                    '{{ addslashes($kata->kata) }}',
                    '{{ addslashes($kata->kelas_kata) }}',
                    '{{ addslashes($kata->suku_kata) }}',
                    '{{ addslashes($kata->arti) }}',
                    '{{ addslashes($kata->contoh) }}',
                    '{{ addslashes($kata->asal_kamus) }}'
                )">

                <h3 class="font-semibold text-blue-700 mb-1 truncate">
                    {{ $kata->kata }}
                </h3>

                <p class="text-gray-600 text-xs leading-relaxed line-clamp-3">
                    <span class="font-medium text-blue-500">Artinya:</span>
                    {{ $kata->arti }}
                </p>

                <div class="mt-2 text-[10px] text-blue-400 italic">
                    klik untuk detail ➜
                </div>
            </div>

            @empty
            {{-- Jika DATA KOSONG --}}
            <div class="w-full flex justify-center">
                <div class="text-center bg-white border border-dashed border-blue-300
                            rounded-2xl p-8 shadow-sm max-w-md">

                    <h3 class="text-lg font-semibold text-blue-700 mb-2">
                        📭 Belum Ada Kosakata
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Data kosakata belum tersedia.
                        Silakan tambahkan data kamus terlebih dahulu.
                    </p>
                </div>
            </div>
            @endforelse

        </div>
    </div>


    <!-- Baris 2 -->
    @if($kosakataHariIni->count() > 8)
    <div class="relative w-full overflow-x-auto pt-4 mt-8 scrollbar-hide" data-aos="fade-up">
        <div class="flex gap-4 sm:gap-6 animate-scroll-right snap-x snap-mandatory">
            @foreach($kosakataHariIni->slice(8) as $kata)
            {{-- card sama seperti di atas --}}
            @endforeach
        </div>
    </div>
    @endif

</section>

<style>
    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes scroll-right {
        0% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    .animate-scroll-left {
        animation: scroll-left 30s linear infinite;
    }

    .animate-scroll-right {
        animation: scroll-right 30s linear infinite;
    }
</style>

<script>
    function showDetail(kata, kelas, suku, arti, contoh, asal) {
        Swal.fire({
            title: `<span style='font-family:Poppins; font-size:1.6rem; color:#2563eb; font-weight:700;'>${kata}</span>`,
            html: `
      <div style='text-align:left; font-family:Poppins; color:#374151;'>
        <p style='margin-bottom:10px;'><strong>Kelas Kata:</strong> ${kelas || '-'} </p>
        <p><strong>Suku Kata:</strong> ${suku || '-'} </p>
        <p style='margin-top:10px;'><strong>Artinya:</strong><br>${arti || '-'} </p>
        <p style='margin-top:10px;'><strong>Contoh:</strong><br><em>${contoh || '-'}</em></p>
        <hr style='margin:15px 0; border-color:#d1d5db;'>
        <p style='font-size:0.9rem; color:#6b7280;'><strong>Asal Kamus:</strong> ${asal || '-'}</p>
      </div>
    `,
            background: '#f9fafb',
            showCloseButton: true,
            showConfirmButton: false,
            width: 550,
            padding: '2em',
            customClass: {
                popup: 'rounded-3xl shadow-2xl'
            },
        });
    }
</script>

<script>
    AOS.init({
        duration: 900, // durasi animasi
        once: true, // biar muncul sekali aja
    });
</script>
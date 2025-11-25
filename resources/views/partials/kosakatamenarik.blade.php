<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AOS (Animate On Scroll) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


<section class="px-6 md:px-16 py-14 bg-gradient-to-b from-blue-50 to-white overflow-hidden">
    <div class="text-center mb-10" data-aos="fade-up" data-aos-delay="150">
        <h2 class="text-3xl md:text-4xl font-poppins font-semibold text-blue-800 mb-2">
            Kosa Kata Menarik Hari Ini
        </h2>
        <p class="text-gray-600 text-sm md:text-base">
            Temukan kata-kata pilihan penuh makna dari <span class="font-semibold text-blue-500">Berbagai Macam Kamus Daerah</span>
        </p>
    </div>

    <!-- Baris 1 -->
    <div class="relative w-full overflow-visible" data-aos="fade-up" data-aos-delay="150">
        <div class="flex gap-6 animate-scroll-left">
            @foreach($kosakataHariIni->take(8) as $kata)
            <div
                class="flex-shrink-0 w-64 h-48 p-5 rounded-3xl bg-gradient-to-br from-blue-100 to-white border border-blue-200 shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:scale-[1.04] cursor-pointer group"
                onclick="showDetail(
            '{{ addslashes($kata->kata) }}',
            '{{ addslashes($kata->kelas_kata) }}',
            '{{ addslashes($kata->suku_kata) }}',
            '{{ addslashes($kata->arti) }}',
            '{{ addslashes($kata->contoh) }}',
            '{{ addslashes($kata->asal_kamus) }}'
          )">
                <h3 class="font-poppins font-semibold text-lg text-blue-700 mb-2 truncate group-hover:text-blue-900">
                    {{ $kata->kata }}
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                    <span class="font-medium text-blue-500">Artinya:</span> {{ $kata->arti }}
                </p>
                <div class="mt-3 text-xs text-blue-400 italic group-hover:text-blue-600">
                    klik untuk detail ➜
                </div>
            </div>
            @endforeach
            @foreach($kosakataHariIni->take(8) as $kata)
            <div
                class="flex-shrink-0 w-64 h-48 p-5 rounded-3xl bg-gradient-to-br from-blue-100 to-white border border-blue-200 shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:scale-[1.04] cursor-pointer group"
                onclick="showDetail(
            '{{ addslashes($kata->kata) }}',
            '{{ addslashes($kata->kelas_kata) }}',
            '{{ addslashes($kata->suku_kata) }}',
            '{{ addslashes($kata->arti) }}',
            '{{ addslashes($kata->contoh) }}',
            '{{ addslashes($kata->asal_kamus) }}'
          )">
                <h3 class="font-poppins font-semibold text-lg text-blue-700 mb-2 truncate group-hover:text-blue-900">
                    {{ $kata->kata }}
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                    <span class="font-medium text-blue-500">Artinya:</span> {{ $kata->arti }}
                </p>
                <div class="mt-3 text-xs text-blue-400 italic group-hover:text-blue-600">
                    klik untuk detail ➜
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Baris 2 -->
    <div class="relative w-full overflow-visible mt-8" data-aos="fade-up" data-aos-delay="300">
        <div class="flex gap-6 animate-scroll-right">
            @foreach($kosakataHariIni->slice(8) as $kata)
            <div
                class="flex-shrink-0 w-64 h-48 p-5 rounded-3xl bg-gradient-to-br from-white to-blue-50 border border-blue-200 shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:scale-[1.04] cursor-pointer group"
                onclick="showDetail(
            '{{ addslashes($kata->kata) }}',
            '{{ addslashes($kata->kelas_kata) }}',
            '{{ addslashes($kata->suku_kata) }}',
            '{{ addslashes($kata->arti) }}',
            '{{ addslashes($kata->contoh) }}',
            '{{ addslashes($kata->asal_kamus) }}'
          )">
                <h3 class="font-poppins font-semibold text-lg text-blue-700 mb-2 truncate group-hover:text-blue-900">
                    {{ $kata->kata }}
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                    <span class="font-medium text-blue-500">Artinya:</span> {{ $kata->arti }}
                </p>
                <div class="mt-3 text-xs text-blue-400 italic group-hover:text-blue-600">
                    klik untuk detail ➜
                </div>
            </div>
            @endforeach
            @foreach($kosakataHariIni->slice(8) as $kata)
            <div
                class="flex-shrink-0 w-64 h-48 p-5 rounded-3xl bg-gradient-to-br from-white to-blue-50 border border-blue-200 shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:scale-[1.04] cursor-pointer group"
                onclick="showDetail(
            '{{ addslashes($kata->kata) }}',
            '{{ addslashes($kata->kelas_kata) }}',
            '{{ addslashes($kata->suku_kata) }}',
            '{{ addslashes($kata->arti) }}',
            '{{ addslashes($kata->contoh) }}',
            '{{ addslashes($kata->asal_kamus) }}'
          )">
                <h3 class="font-poppins font-semibold text-lg text-blue-700 mb-2 truncate group-hover:text-blue-900">
                    {{ $kata->kata }}
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                    <span class="font-medium text-blue-500">Artinya:</span> {{ $kata->arti }}
                </p>
                <div class="mt-3 text-xs text-blue-400 italic group-hover:text-blue-600">
                    klik untuk detail ➜
                </div>
            </div>
            @endforeach
        </div>
    </div>
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
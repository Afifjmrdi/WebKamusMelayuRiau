<footer class="bg-white border-t border-gray-200" data-aos="fade-up" data-aos-delay="200">
    <div class="max-w-7xl mx-auto px-5 py-6 md:py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-sm text-gray-600">

            <!-- Kolom 1 -->
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/BBP.png') }}" alt="Logo" class="h-7">
                    <span class="font-semibold text-gray-800 text-sm sm:text-base">Balai Bahasa Provinsi Riau</span>
                </div>
                <p class="text-gray-500 text-[12px] sm:text-[13px] leading-snug">
                    Sistem ini memiliki beragam kamus yang berasal dari berbagai daerah di Provinsi Riau.
                </p>
                <div class="flex items-center gap-3 pt-1">
                    <a href="#"><img src="{{ asset('assets/facebook.png') }}" class="h-5 w-5"></a>
                    <a href="#"><img src="{{ asset('assets/instagram.png') }}" class="h-5 w-5"></a>
                    <a href="#"><img src="{{ asset('assets/youtube.png') }}" class="h-5 w-5"></a>
                </div>
            </div>

            <!-- Kolom 2 -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm">Menu</h3>
                <ul class="space-y-1.5 text-[12px] sm:text-[13px]">
                    <li><a href="{{ url('/') }}" class="hover:text-blue-600 transition">Beranda</a></li>
                    <li><a href="{{ url('/koreksi') }}" class="hover:text-blue-600 transition">Koreksi Kosakata</a></li>
                    <li><a href="{{ url('/ajukan') }}" class="hover:text-blue-600 transition">Ajukan Kosakata</a></li>
                    <li><a href="{{ url('/tentang') }}" class="hover:text-blue-600 transition">Tentang Kami</a></li>
                    <li>
                        <a href="{{ route('kamus.istilah') }}"
                            class=" hover:text-blue-600 transition">
                            Kamus Istilah
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3 -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm">Alamat</h3>
                <p class="text-gray-500 text-[12px] sm:text-[13px] leading-snug">
                    Pengembangan dan Pembinaan Bahasa<br>
                    Kementerian Pendidikan Dasar dan Menengah, Kebudayaan, Riset, dan Teknologi
                </p>
                <p class="text-gray-500 text-[12px] sm:text-[13px] mt-2 leading-snug">
                    Balai Bahasa Provinsi Riau Jalan Binawidya, Kompleks Universitas Riau,<br>
                    Panam, Kota Pekanbaru, Riau 28292
                </p>
            </div>

            <!-- Kolom 4 -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm">Lokasi</h3>
                <div class="rounded-md overflow-hidden border border-gray-100">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.682349616947!2d101.37938137477644!3d0.4730259995223464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a853e3083e97%3A0x5c40a215adfd57fd!2sBalai%20Bahasa%20Riau!5e0!3m2!1sid!2sid!4v1761535604563!5m2!1sid!2sid"
                        width="100%" height="110" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <!-- Garis dan Hak Cipta -->
        <div class="border-t border-gray-200 mt-6 pt-4 flex flex-col md:flex-row justify-between items-center text-[11px] sm:text-[12px] text-gray-400 text-center gap-1">
            <p>© 2025 Balai Bahasa Provinsi Riau, Kementerian Pendidikan Dasar dan Menengah.</p>

            <div>
                Icons by <a href="https://www.flaticon.com/" target="_blank" class="underline hover:text-blue-500">Freepik - Flaticon</a> |
                Dev by <a target="_blank" class="underline hover:text-blue-500">Afifjmrdi</a>
            </div>
        </div>
    </div>
</footer>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kamus Balai Bahasa Riau</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
    style="background-image:url('{{ asset('assets/background4.png') }}')">

    <div class="absolute inset-0 bg-black/20 backdrop-blur-md"></div>

    <div class="relative z-10 w-full max-w-md bg-white/50 p-8 rounded-2xl shadow-xl backdrop-blur-md border border-white/30">
        <h2 class="text-2xl font-semibold text-center mb-2 text-gray-800">Lupa Password?</h2>
        <p class="text-center text-sm text-gray-600 mb-6">Masukkan email admin untuk menerima kode OTP reset password.</p>

        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-3 text-center text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-3 text-center text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.forgot.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-2 text-sm text-gray-700">Email Admin</label>
                <input type="email" name="email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 bg-white/70" required>
            </div>
            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Kirim Kode OTP
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('admin.login') }}" class="text-sm text-blue-700 hover:underline">Kembali ke halaman login</a>
        </div>
    </div>
</body>

</html>
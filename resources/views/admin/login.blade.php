{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/background4.png') }}');"></div>

    <!-- Card Login -->
    <div class="relative w-full max-w-md bg-white/40 backdrop-blur-lg border border-white/30 rounded-2xl shadow-xl p-8 z-10">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="w-37 h-37 rounded-full bg-white/60 backdrop-blur-md shadow-lg flex items-center justify-center">
                <img src="{{ asset('assets/logobbpr.png') }}" alt="Logo" class="w-33 h-33 object-contain mt-4">
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">Selamat Datang</h2>
        <p class="text-sm text-gray-600 text-center mb-6">Masukkan username atau email, dan password untuk masuk</p>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-100/80 text-green-700 p-3 rounded mb-4 text-sm text-center shadow-md border border-green-200">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100/80 text-red-700 p-3 rounded mb-4 text-sm text-center shadow-md border border-red-200">
            {{ session('error') }}
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Username -->
            <div>
                <p class="text-[13px] mb-2 text-gray-600 ml-[2px]">Username atau Email</p>
                <input type="text" name="username" required
                    class="w-full px-4 py-2 border border-gray-300/60 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition bg-white/60 backdrop-blur-sm">
            </div>

            <!-- Password -->
            <div class="relative">
                <p class="text-[13px] mb-2 text-gray-600 ml-[2px]">Password</p>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300/60 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition bg-white/60 backdrop-blur-sm">
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                    <i id="eye-icon" data-feather="eye-off" class="w-5 h-5 -mt-[-30px]"></i>
                </button>
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between text-sm text-gray-700">
                <!-- 🔹 Tambahan: Forgot Password -->
                <a href="{{ route('admin.forgot') }}" class="text-blue-700 hover:underline">
                    Lupa Password?
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full py-2 rounded-lg bg-blue-600/90 text-white font-semibold hover:bg-blue-700 transition shadow-md">
                Masuk
            </button>
        </form>
    </div>

    <script>
        feather.replace();

        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eye-icon");
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("data-feather", "eye");
            } else {
                input.type = "password";
                icon.setAttribute("data-feather", "eye-off");
            }
            feather.replace();
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Persetujuan Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
    style="background-image:url('{{ asset('assets/background4.png') }}')">

    <div class="absolute inset-0 bg-black/20 backdrop-blur-md"></div>

    <div class="relative z-10 w-full max-w-md bg-white/60 p-8 rounded-2xl shadow-xl">

        <h2 class="text-2xl font-semibold text-center mb-2">
            Persetujuan Admin Baru
        </h2>

        <p class="text-center text-sm text-gray-600 mb-6">
            Admin berikut meminta akses ke sistem
        </p>

        <div class="bg-white/70 rounded-lg p-4 mb-6 text-center">
            <p class="text-sm text-gray-500">Nama</p>
            <p class="font-semibold text-lg">{{ $pending->name }}</p>

            <p class="text-sm text-gray-500 mt-2">Username</p>
            <p>{{ $pending->username }}</p>

            <p class="text-sm text-gray-500 mt-2">Email</p>
            <p>{{ $pending->email }}</p>
        </div>

        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.approve.post', $pending->token) }}" class="w-full">
                @csrf
                <button class="w-full py-2 bg-blue-600 text-white rounded-lg">
                    Setujui
                </button>
            </form>

            <form method="POST" action="{{ route('admin.reject', $pending->token) }}" class="w-full">
                @csrf
                <button class="w-full py-2 bg-red-600 text-white rounded-lg">
                    Tolak
                </button>
            </form>
        </div>

    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Persetujuan Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-300">

    {{-- CARD --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        {{-- TITLE --}}
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">
            Persetujuan Admin Baru
        </h2>

        <p class="text-sm text-gray-500 text-center mb-6">
            Admin berikut mengajukan permintaan akses ke sistem
        </p>

        {{-- INFO ADMIN --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-3">
            <div>
                <p class="text-xs text-gray-500">Nama Admin</p>
                <p class="font-medium text-gray-800">{{ $pending->name }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Username</p>
                <p class="font-medium text-gray-800">{{ $pending->username }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Email</p>
                <p class="font-medium text-gray-800">{{ $pending->email }}</p>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="space-y-3">

            {{-- SETUJUI --}}
            <form method="POST" action="{{ route('admin.approve.post', $pending->token) }}">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    Setujui Admin
                </button>
            </form>

            {{-- TOLAK --}}
            <form method="POST" action="{{ route('admin.reject.post', $pending->token) }}">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    Tolak Admin
                </button>
            </form>

        </div>

        {{-- FOOTER --}}
        <div class="text-center mt-6">
            <a href="{{ route('admin.login') }}"
                class="text-sm text-blue-600 hover:underline">
                Kembali ke halaman login
            </a>
        </div>

    </div>

</body>

</html>
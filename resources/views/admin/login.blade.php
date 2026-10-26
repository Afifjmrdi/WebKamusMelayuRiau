<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Balai Bahasa Provinsi Riau</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Card Ramping & Bersih */
        .login-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .input-group:focus-within {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .input-field {
            background: transparent !important;
            color: #1e293b !important;
            outline: none;
        }

        @keyframes entrance {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-entrance {
            animation: entrance 0.7s ease-out;
        }

        .btn-blue {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .btn-blue:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
        }

        /* Logo Floating Animation */
        .logo-float {
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
            transition: all 0.5s ease;
        }

        .logo-float:hover {
            transform: translateY(-5px);
            filter: drop-shadow(0 15px 20px rgba(0, 0, 0, 0.15));
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center relative overflow-hidden bg-slate-50 px-4">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/background9.png') }}" class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-white/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 via-transparent to-transparent"></div>
    </div>

    <div class="relative w-full max-w-sm z-10">
        <div class="login-card rounded-3xl p-8 md:p-10 animate-entrance">

            <div class="flex flex-col items-center mb-8 text-center">
                <img src="{{ asset('assets/logobbpr.png') }}"
                    alt="Logo"
                    class="w-78 h-auto object-contain logo-float mb-4">

                <h2 class="text-xl font-black text-slate-800 tracking-tight">KEMALA ADMIN</h2>
                <p class="text-[9px] font-bold text-blue-600 tracking-[0.3em] uppercase mt-1">Balai Bahasa Provinsi Riau</p>
            </div>

            @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-lg mb-4 text-[10px] font-bold border border-emerald-100 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-rose-50 text-rose-600 px-4 py-2 rounded-lg mb-4 text-[10px] font-bold border border-rose-100 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Username</label>
                    <div class="input-group flex items-center h-11 rounded-xl px-4">
                        <span class="text-slate-400 mr-3"><i data-feather="user" class="w-4 h-4"></i></span>
                        <input type="text" name="username" required placeholder="Identitas admin..."
                            class="input-field w-full text-xs font-semibold">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                        <a href="{{ route('admin.forgot') }}" class="text-[9px] font-bold text-blue-600 hover:text-blue-800 transition">Lupa?</a>
                    </div>
                    <div class="input-group flex items-center h-11 rounded-xl px-4">
                        <span class="text-slate-400 mr-3"><i data-feather="lock" class="w-4 h-4"></i></span>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="input-field w-full text-xs font-semibold">
                        <button type="button" onclick="togglePassword()" class="text-slate-400 hover:text-blue-400 transition ml-2">
                            <i id="eye-icon" data-feather="eye-off" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="btn-blue w-full h-12 rounded-xl text-white font-bold text-xs shadow-lg flex items-center justify-center gap-2 active:scale-95 transition-all mt-2">
                    <span>AUTENTIKASI</span>
                    <i data-feather="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-5 border-t border-slate-100 text-center">
                <p class="text-[9px] text-slate-400 font-medium leading-relaxed uppercase tracking-tighter">
                    &copy; 2025 Balai Bahasa Provinsi Riau. <br>
                    Dev by <span class="text-slate-600 font-black">AFIFJMRDI</span>
                </p>
            </div>
        </div>
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
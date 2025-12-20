<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: #ffffff;
            /* samakan dengan background web */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        video {
            width: 420px;
            max-width: 85vw;
            height: auto;
        }

        @media (max-width: 768px) {
            video {
                width: 280px;
            }
        }


        .fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    </style>
</head>

<body>

    <!-- VIDEO SPLASH -->
    <video id="splashVideo" autoplay muted playsinline>
        <source src="{{ asset('assets/splash3.mp4') }}" type="video/mp4">
        Browser anata tidak mendukung video.
    </video>

    <script>
        // Kalau sudah pernah masuk web di TAB ini → langsung ke home
        if (sessionStorage.getItem('hasEnteredWeb')) {
            window.location.href = "{{ route('home') }}";
        }

        const video = document.getElementById('splashVideo');

        video.addEventListener('ended', () => {
            // Tandai bahwa user sudah masuk web
            sessionStorage.setItem('hasEnteredWeb', 'true');

            window.location.href = "{{ route('home') }}";
        });
    </script>


</body>

</html>
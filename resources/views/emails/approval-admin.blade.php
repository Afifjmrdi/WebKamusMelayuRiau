<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Persetujuan Admin Baru</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 0;
            margin: 0;
        }

        .email-container {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 480px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 30px 25px;
            color: #333;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #1f1f7a;
            margin-bottom: 16px;
        }

        .text {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            background: #1f1f7a;
            color: #ffffff !important;
            padding: 12px 22px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            font-size: 13px;
            color: #777;
            margin-top: 25px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="card">

            <div class="title">Persetujuan Admin Baru</div>

            <p class="text">
                Hai Superadmin,<br><br>
                Ada admin baru yang mendaftar dengan nama:
            </p>

            <p class="text" style="font-size: 16px; font-weight: bold;">
                {{ $name }}
            </p>

            <p class="text">
                Silakan klik tombol di bawah ini untuk menyetujui admin tersebut:
            </p>

            <a href="{{ $approveUrl }}" class="btn">Setujui Admin</a>

            <p class="footer">
                Jika tombol tidak berfungsi, gunakan link berikut:<br>
                <a href="{{ $approveUrl }}">{{ $approveUrl }}</a>
            </p>

        </div>
    </div>

</body>

</html>
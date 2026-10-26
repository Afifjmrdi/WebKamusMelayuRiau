<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Persetujuan Admin Baru</title>
</head>

<body>
    <p>Halo Superadmin,</p>

    <p>Admin baru dengan nama:</p>

    <p><strong>{{ $name }}</strong></p>

    <p>meminta persetujuan untuk mengakses sistem.</p>

    <p>Silakan klik link di bawah ini:</p>

    <p>
        <a href="{{ $approveUrl }}">
            Setujui Admin
        </a>
    </p>

    <p>Jika Anda tidak mengenal permintaan ini, abaikan email ini.</p>

    <br>
    <p>Salam,<br>
        Kamus Balai Bahasa Riau</p>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Akun Admin Disetujui</title>
</head>

<body>
    <p>Halo {{ $name }},</p>

    <p>
        Permohonan pembuatan akun admin Anda di
        <strong>Kamus Balai Bahasa Riau</strong>
        telah <strong>DISETUJUI</strong>.
    </p>

    <p>
        Sekarang Anda sudah dapat login dan mengakses sistem.
    </p>

    <p>
        Silakan login melalui halaman berikut:<br>
        <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
    </p>

    <br>
    <p>Salam,<br>
        Tim Kamus Balai Bahasa Riau</p>
</body>

</html>
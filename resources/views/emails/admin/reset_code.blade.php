<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kode Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f6fa; padding:20px;">
    <div style="max-width:500px; margin:auto; background:#ffffff; padding:24px; border-radius:10px;">
        <h2 style="color:#1f2937;">Kode Reset Password</h2>

        <p>Halo <strong>{{ $admin->name }}</strong>,</p>

        <p>Gunakan kode OTP berikut untuk mereset password admin Anda:</p>

        <div style="
            font-size:28px;
            font-weight:bold;
            letter-spacing:4px;
            margin:20px 0;
            color:#2563eb;
            text-align:center;
        ">
            {{ $code }}
        </div>

        <p>Kode ini berlaku selama <strong>15 menit</strong>.</p>

        <p>Jika Anda tidak merasa meminta reset password, silakan abaikan email ini.</p>

        <hr style="margin:24px 0;">

        <p style="font-size:12px; color:#6b7280;">
            Email ini dikirim otomatis oleh sistem Kamus Balai Bahasa Riau.
        </p>

@component('mail::message')
# Kode Reset Password

Halo **{{ $admin->name }}**,

Kamu meminta untuk mereset password akun admin. Gunakan kode OTP berikut (berlaku 15 menit):

@component('mail::panel')
**{{ $code }}**
@endcomponent

Jika kamu tidak meminta, abaikan email ini.

Terima kasih,
Kamus Balai Bahasa Riau
@endcomponent
<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;


class GmailApiService
{
    protected Gmail $gmail;

    public function __construct()
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        // token OAuth Google (akun pengirim)
        $client->setAccessToken(
            json_decode(file_get_contents(storage_path('app/google-token.json')), true)
        );

        $this->gmail = new Gmail($client);
    }

    public function send(string $to, string $subject, string $html): void
    {
        $raw =
            "To: {$to}\r\n" .
            "Subject: {$subject}\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n\r\n" .
            $html;

        $encoded = rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');

        $message = new Message();
        $message->setRaw($encoded);

        $this->gmail->users_messages->send('me', $message);
    }
}

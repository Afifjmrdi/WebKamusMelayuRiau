<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected Gmail $service;

    public function __construct()
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessType('offline');
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);

        $tokenPath = storage_path('app/google-token.json');
        $token = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($token);

        // auto refresh
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        $this->service = new Gmail($client);
    }

    public function send($to, $subject, $html)
    {
        $rawMessage = "To: {$to}\r\n";
        $rawMessage .= "Subject: {$subject}\r\n";
        $rawMessage .= "MIME-Version: 1.0\r\n";
        $rawMessage .= "Content-Type: text/html; charset=utf-8\r\n\r\n";
        $rawMessage .= $html;

        $msg = new Message();
        $msg->setRaw(rtrim(strtr(base64_encode($rawMessage), '+/', '-_'), '='));

        return $this->service->users_messages->send('me', $msg);
    }
}

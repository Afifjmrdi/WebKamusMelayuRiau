<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;

class GenerateGoogleToken extends Command
{
    protected $signature = 'google:token';
    protected $description = 'Generate Google OAuth token for Gmail API';

    public function handle()
    {
        $client = new Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->setScopes([
            'https://www.googleapis.com/auth/gmail.send',
        ]);

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $authUrl = $client->createAuthUrl();

        $this->info('🔗 Buka URL ini di browser:');
        $this->line($authUrl);
        $this->newLine();

        $code = $this->ask('Paste kode verifikasi dari Google di sini');

        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            $this->error('❌ Gagal mendapatkan token');
            return;
        }

        file_put_contents(
            storage_path('app/google-token.json'),
            json_encode($token, JSON_PRETTY_PRINT)
        );

        $this->info('✅ Token Google berhasil dibuat!');
        $this->info('📁 Disimpan di storage/app/google-token.json');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $code;

    public function __construct($admin, $code)
    {
        $this->admin = $admin;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Kode Reset Password — Kamus Balai Bahasa Riau')
            ->markdown('emails.admin.reset_code');
    }
}

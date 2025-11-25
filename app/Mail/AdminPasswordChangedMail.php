<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin;

class AdminPasswordChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('Password Akun Admin Berhasil Diubah')
            ->view('emails.admin_password_changed')
            ->with([
                'admin' => $this->admin,
            ]);
    }
}

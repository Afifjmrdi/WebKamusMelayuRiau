<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pending;

    public function __construct($pending)
    {
        $this->pending = $pending;
    }

    public function build()
    {
        return $this->subject('Persetujuan Admin Baru')
            ->view('emails.approval-admin')
            ->with([
                'name' => $this->pending->name,
                'approveUrl' => url('/admin/approve/' . $this->pending->token),
            ]);
    }
}

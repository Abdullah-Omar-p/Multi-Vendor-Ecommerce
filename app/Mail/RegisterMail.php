<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($randomNumber)
    {
        $this->randomNumber = $randomNumber;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Mail',
        );
    }

    public function build()
    {
        return $this->view('signup', ['token' => $this->randomNumber]);
    }

    public function attachments(): array
    {
        return [];
    }
}

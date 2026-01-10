<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type; // 'deposit', 'withdrawal', 'verification'
    public $data;
    public $userName;
    public $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($type, $data, $userName, $userEmail)
    {
        $this->type = $type;
        $this->data = $data;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjects = [
            'deposit' => 'Permintaan Deposit Baru',
            'withdrawal' => 'Permintaan Withdrawal Baru',
            'verification' => 'Permintaan Verifikasi Akun Baru',
        ];

        return new Envelope(
            subject: $subjects[$this->type] . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

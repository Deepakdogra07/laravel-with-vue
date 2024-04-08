<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisteredAgent extends Mailable
{
    use Queueable, SerializesModels;
    private $username, $email, $password, $creator;
    /**
     * Create a new message instance.
     */
    public function __construct($username, $email, $password, $creator)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->creator = $creator;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Instant Loan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.RegisterAgent',
            with: ['username' => $this->username, 'email' => $this->email,'password'=>$this->password,'creator'=>$this->creator],
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

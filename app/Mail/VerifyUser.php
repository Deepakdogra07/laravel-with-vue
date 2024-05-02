<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyUser extends Mailable
{
    use Queueable, SerializesModels;
    private $user_id , $username, $email, $password, $creator;
    /**
     * Create a new message instance.
     */
    public function __construct($user_id ,$username,$email,$password,$creator)
    {
        $this->username = $username;
        $this->user_id = $user_id;
        $this->email = $email;
        $this->password = $password;
        $this->creator = $creator;
// dd($username,$email,$password,$creator);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to  Unstoppable Job',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd(Auth::user());
        $url = url('/verify-email/'.$this->user_id);
        return new Content(
            view: 'emails.VerifyEmail',
            with: ['username' => $this->username, 'email' => $this->email, 'actionUrl'=>$url],
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

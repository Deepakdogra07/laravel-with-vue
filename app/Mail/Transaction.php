<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Transaction extends Mailable
{
    use Queueable, SerializesModels;
    private $user_id , $username, $email,$transaction_id,$job,$jobstatus,$transaction_status;
    /**
     * Create a new message instance.
     */
    public function __construct($user_id ,$username,$email,$transaction_id,$job,$jobstatus,$transaction_status)
    {
        $this->username = $username;
        $this->user_id = $user_id;
        $this->email = $email;
        $this->transaction_id = $transaction_id;
        $this->job = $job;
        $this->jobstatus = $jobstatus;
        $this->transaction_status = $transaction_status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Transaction Verified',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction',
            with: ['username' => $this->username, 'email' => $this->email,
            'transaction_id'=>$this->transaction_id,'job_title'=>$this->job,
            'job_status'=> $this->jobstatus,'transaction_status'=>$this->transaction_status
        ],
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

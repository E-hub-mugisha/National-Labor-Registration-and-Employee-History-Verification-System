<?php

namespace App\Mail;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployerWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User     $user,
        public readonly Employer $employer,
        public readonly string   $plainPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Employer Account – Login Credentials',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.employer-welcome',
            with: [
                'user'          => $this->user,
                'employer'      => $this->employer,
                'plainPassword' => $this->plainPassword,
                'loginUrl'      => route('login'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
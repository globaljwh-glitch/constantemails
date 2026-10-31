<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    // Make target array payload data publicly accessible across layouts
    public array $formData;

    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Corporate Pipeline Lead Inquiry Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lead_submission', // Points to a simple email view file
        );
    }
}

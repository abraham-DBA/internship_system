<?php

namespace App\Mail;

use App\Models\StudentInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffInquiryNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public StudentInquiry $inquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Student Inquiry Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.staff-inquiry-notification',
            with: [
                'inquiry' => $this->inquiry,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Internship Approval & Supervisor Assignment',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.student-approved',
            with: [
                'student' => $this->student,
            ],
        );
    }

    public function attachments(): array
    {
        $s = $this->student;
        $body = "Approval Letter\n\n".
            "Dear {$s->full_name},\n\n".
            "Your internship registration has been approved.\n\n".
            "Supervisor: {$s->supervisor_name}\n".
            "Supervisor Email: {$s->supervisor_email}\n\n".
            "Regards,\nInternship Office";
        return [
            Attachment::fromData(fn () => $body, 'approval_letter.txt')
                ->withMime('text/plain')
        ];
    }
}
